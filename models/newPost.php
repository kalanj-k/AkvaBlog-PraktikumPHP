<?php
    if(isset($_POST['submit'])){
        require_once "../config/connection.php";
        $title = $_POST['title'];
        $text = $_POST['text'];
        $userId = $_SESSION['user']->user_id;
        $category = $_POST['category'];
        //reg
        $types = ['image/jpeg', 'image/jpg', 'image/png'];
        $titleReg = '/^[A-zšđžčćŠĐŽČĆ 1-9]{10,100}/';
        $textReg = '/^[A-zšđžčćŠĐŽČĆ 1-9]{10,1000}/';
        define('allowedSize', 2000000);
        $errors= [];
        //image
        if(isset($_FILES['slika'])){
            if($_FILES['slika']['size'] == 0){
            array_push($errors, "You must upload a picture.");
            }
            else{
            $fileName = $_FILES['slika']['name'];
            $fileSize = $_FILES['slika']['size'];
            $fileType = $_FILES['slika']['type'];
            $fileTmp = $_FILES['slika']['tmp_name'];
            $typePrep = explode('/', $fileType);
            echo $fileType;
            $type = $typePrep[1];
            
            
        if(!in_array($fileType, $types)){
            array_push($errors, "Wrong file type.");
        }
        if($fileSize > allowedSize){
            array_push($error, "The file is too big.");
        }
            }
        }
        
        
        //checks
        if(!preg_match($titleReg, $title)){
            array_push($errors, "Wrong title length.");
        }
        if(!preg_match($textReg, $text)){
            array_push($errors, "Wrong text length.");
        }
        if($category == 0){
            array_push($errors, "You must choose a category.");
        }
        if(count($errors) > 0){
            $_SESSION['errors'] = $errors;
            header("Location: ../index.php?page=newPost");
        }
        else{
            try{
                $path = "assets/img/posts/post_".$userId.time().".".$type;
                move_uploaded_file($fileTmp, "../".$path); 
                $query = "INSERT INTO posts( title, text, user_id, cat_id) VALUES( :title, :text, :userId, :category)";
                $prep = $conn->prepare($query);
                $prep->bindParam(':title', $title);
                $prep->bindParam(':text', $text);
                $prep->bindParam(':userId', $userId);
                $prep->bindParam(':category', $category);
                $result = $prep->execute();
                if($result){
                    $lastId = $conn->lastInsertId();
                    $alt = $_SESSION['user']->username.time();
                    $queryImg = "INSERT INTO post_img( src, alt, post_id) VALUES( :src, :alt, :post_id)";
                    $prepImg = $conn->prepare($queryImg);
                    $prepImg->bindParam(':src', $path);
                    $prepImg->bindParam(':alt', $alt);
                    $prepImg->bindParam(':post_id', $lastId);
                    $done = $prepImg->execute();
                    if($done){
                        header("Location: ../index.php?page=newPost&outcome=done");
                    }
                    else{
                        header("Location: ../index.php?page=newPost&outcome=failed");
                    }
                }
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
            }
            
        }
    }

?>