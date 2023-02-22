<?php

    if(isset($_POST['submit'])){
        require_once "../config/connection.php";
        
        $fileName = $_FILES['slika']['name'];
        $fileSize = $_FILES['slika']['size'];
        $fileType = $_FILES['slika']['type'];
        $fileTmp = $_FILES['slika']['tmp_name'];
        $typePrep = explode('/', $fileType);
        $type = $typePrep[1];
        $types = ['image/jpeg', 'image/jpg', 'image/png'];
        define('allowedSize', 2000000);
        $errors= [];
        
        if(!in_array($fileType, $types)){
            array_push($errors, "Wrong file type.");
        }
        if($fileSize > allowedSize){
            array_push($error, "The file is too big.");
        }
        if(count($errors)==0){
            list($width, $height) = getimagesize($fileTmp);
            $newHeight = 180;
            $newWidth = ($newHeight/$height) * $width;

            $uploadedPic = null;
            switch($fileType){
                case 'image/jpeg':
                    $uploadedPic = imagecreatefromjpeg($fileTmp);
                    break;
                case 'image/png':
                    $uploadedPic = imagecreatefrompng($fileTmp);
                    break;
            }
            $newPic = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newPic, $uploadedPic, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $namePic = 'profile_'.time();
            $path = 'assets/img/account/small_'.$namePic.'.'.$type;
            $pathOg = 'assets/img/account/og_'.$namePic.'.'.$type;
            switch($fileType){
                case 'image/jpeg':
                    imagejpeg($newPic, '../'.$path);
                    break;
                case 'image/png' : 
                    imagepng($newPic, '../'.$path);
                    break;
            }
            $moved = move_uploaded_file($fileTmp, '../'.$pathOg);
            if($moved){
            try{    
                $idUser = $_SESSION['user']->user_id;
                $alt = $_SESSION['user']->username.date('Ymd');
                $query = "UPDATE user_img SET `src`=:path,`src_og`=:srcOg,`alt`=:alt WHERE user_id = :idUser ";
                $prep = $conn->prepare($query);
                $prep->bindParam(':path', $path);
                $prep->bindParam(':srcOg', $pathOg);
                $prep->bindParam(':alt', $alt);
                $prep->bindParam(':idUser', $idUser);
                $result = $prep->execute();
                if($result){
                    header("Location: ../index.php?page=account");
                }
                else{
                    header("Location: ../index.php?page=account&outcome=error");
                }
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
            }
            }
            
        }

    }

?>