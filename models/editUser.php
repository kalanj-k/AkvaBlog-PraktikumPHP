<?php
    require_once "../config/connection.php";
    if($_SESSION['user']->role_id != 2){
        header("Location: ../index.php");
    }
    if(isset($_POST['update'])){
        $userId = $_POST['userId'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $inpass = $_POST['password'];
        $roleId = $_POST['role'];
        //reg
        $reUser = "/^[a-z0-9]{4,20}$/";
        $reEmail = "/^[a-z][a-z\d\_\.\-]+\@[a-z\d]+(\.[a-z]{2,4})+$/";
        $rePass = "/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/";
        $err=false;
        if(!preg_match($reUser,$username)){
            $err = true;
        }
        if(!preg_match($reEmail,$email)){
            $err = true;
        }
        if(!preg_match($rePass,$inpass)){
            $err = true;
        }
        $password = md5($inpass);
        if($err){
            echo "Something isn't quite right!";
        }
        else{
            try{
            $mailquery = "SELECT * FROM users WHERE (email = :email OR username = :username) AND NOT user_id=:userId";
            $preparemail = $conn->prepare($mailquery);
            $preparemail->bindParam(":email",$email);
            $preparemail->bindParam(":username",$username);
            $preparemail->bindParam(":userId",$userId);
            $preparemail->execute();
            $doesExist= $preparemail->fetch();
            if($doesExist){
                header("Location: ../index.php?page=editUser&outcome=failed&id=".$userId);
            }
            else{
                $query = "UPDATE users SET `username`=:username,`email`=:email,`password`=:password,`role_id`=:roleId WHERE user_id = :userId";
                $prep = $conn->prepare($query);
                $prep->bindParam(":username", $username);
                $prep->bindParam(":email", $email);
                $prep->bindParam(":password", $password);
                $prep->bindParam(":roleId", $roleId);
                $prep->bindParam(":userId", $userId);
                $userInsert = $prep->execute();
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
                            header("Location: ../index.php?page=editUser&id=".$userId);
                        }
                        else{
                            
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
                                    $alt = $username.date('Ymd');
                                    echo $alt;
                                    $query = "UPDATE user_img SET `src`=:path,`src_og`=:srcOg,`alt`=:alt WHERE user_id = :idUser ";
                                    $prep = $conn->prepare($query);
                                    $prep->bindParam(':path', $path);
                                    $prep->bindParam(':srcOg', $pathOg);
                                    $prep->bindParam(':alt', $alt);
                                    $prep->bindParam(':idUser', $userId);
                                    $result = $prep->execute();
                                    if($result){
                                        header("Location: ../index.php?page=editUser&id=".$userId."&outcome=done");
                                    }
                                    else{
                                        header("Location: ../index.php?page=editUser&id=".$userId."&outcome=done");
                                    }
                                }
                                catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }
                                }
                                
                            
                        }    
                    }
                    else{
                        header("Location: ../index.php?page=editUser&id=".$userId."&outcome=done");
                    }
                }
            } 
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
            }
        }
    }
?>