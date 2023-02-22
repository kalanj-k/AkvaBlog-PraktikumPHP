<?php

    require_once "../config/connection.php";
    if(isset($_POST["register"])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $inpass = $_POST['password'];
        $err = false;

        //reg

        $reUser = "/^[a-z0-9]{4,20}$/";
        $reEmail = "/^[a-z][a-z\d\_\.\-]+\@[a-z\d]+(\.[a-z]{2,4})+$/";
        $rePass = "/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/";

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
            $mailquery = "SELECT * FROM users WHERE email = :email OR username = :username";
            $preparemail = $conn->prepare($mailquery);
            $preparemail->bindParam(":email",$email);
            $preparemail->bindParam(":username",$username);
            $preparemail->execute();
            $doesExist= $preparemail->fetch();
            if($doesExist){
                header("Location: ../index.php?page=register&outcome=failed");
            }
            else{
                    $query = "INSERT INTO users (username,email,password,role_id) VALUES (:username, :email, :password, 1)";
                    $prep = $conn->prepare($query);
                    $prep->bindParam(":username", $username);
                    $prep->bindParam(":email", $email);
                    $prep->bindParam(":password", $password);
                    $userInsert = $prep->execute();
                    if($userInsert){
                        $lastId = $conn->lastInsertId();
                        $alt = $username.date('Ymd');
                        $srcDefault = 'assets/img/account/default.png';
                        $queryImg = "INSERT INTO user_img (src,src_og,alt,user_id) VALUES(:src,:srcog,:alt,:user_id)";
                        $prep = $conn->prepare($queryImg);
                        $prep->bindParam(':src', $srcDefault);
                        $prep->bindParam(':srcog', $srcDefault);
                        $prep->bindParam(':alt', $alt);
                        $prep->bindParam(':user_id', $lastId);
                        $done = $prep->execute();
                        if($done){
                            header("Location: ../index.php?page=register&outcome=done");
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