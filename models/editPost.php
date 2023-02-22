<?php
    if(isset($_POST['update'])){
        require_once "../config/connection.php";
        $title = $_POST['title'];
        $text = $_POST['text'];
        $postId = $_POST['postId'];
        $userId = $_SESSION['user']->user_id;
        //reg
        $titleReg = '/^[A-zšđžčćŠĐŽČĆ 1-9]{10,100}/';
        $textReg = '/^[A-zšđžčćŠĐŽČĆ 1-9]{10,1000}/';
        $errors= [];
        //checks
        if(!preg_match($titleReg, $title)){
            array_push($errors, "Wrong title length.");
        }
        if(!preg_match($textReg, $text)){
            array_push($errors, "Wrong text length.");
        }
        if(count($errors) > 0){
            $_SESSION['errors'] = $errors;
            header("Location: ../index.php?page=editPost&id=".$postId);
        }
        else{
            try{
                $query = "UPDATE posts SET `title`=:title,`text`=:text WHERE post_id = :postId";
                $prep = $conn->prepare($query);
                $prep->bindParam(':title', $title);
                $prep->bindParam(':text', $text);
                $prep->bindParam(':postId', $postId);
                $prep->execute();
                if(isset($_FILES['slika'])){
                    if($_FILES['slika']['size'] != 0){
                    $fileName = $_FILES['slika']['name'];
                    $fileSize = $_FILES['slika']['size'];
                    $fileType = $_FILES['slika']['type'];
                    $fileTmp = $_FILES['slika']['tmp_name'];
                    $typePrep = explode('/', $fileType);
                    $type = $typePrep[1];
                    //reg
                    $types = ['image/jpeg', 'image/jpg', 'image/png'];
                    define('allowedSize', 2000000);
                    if(!in_array($fileType, $types)){
                        array_push($errors, "Wrong file type.");
                    }
                    if($fileSize > allowedSize){
                        array_push($error, "The file is too big.");
                    }
                    if(count($errors) > 0){
                        $_SESSION['errors'] = $errors;
                        header("Location: ../index.php?page=editPost&id=".$postId);
                    }
                    else{
                        $path = "assets/img/posts/post_".$userId.time().".".$type;
                        $alt = $_SESSION['user']->username.time();
                        move_uploaded_file($fileTmp, "../".$path);
                        $queryImg = "UPDATE post_img SET `src`=:src,`alt`=:alt WHERE post_id = :postId";
                        $prepImg = $conn->prepare($queryImg);
                        $prepImg->bindParam(':src', $path);
                        $prepImg->bindParam(':alt', $alt);
                        $prepImg->bindParam(':postId', $postId);
                        $done = $prepImg->execute();
                        if($done){
                            header("Location: ../index.php?page=editPost&id=".$postId."&outcome=done");
                        }
                        else{
                            header("Location: ../index.php?page=editPost&id=".$postId."&outcome=failed");
                        }
                    }    
                    }
                    else{
                        header("Location: ../index.php?page=editPost&id=".$postId."&outcome=done");
                    }
                }
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
            }
            
        }
    }
?>