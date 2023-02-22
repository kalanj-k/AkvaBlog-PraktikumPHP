<?php
    if(isset($_POST['login'])){
        require_once "../config/connection.php";
        $username = $_POST['username'];
        $inpass = $_POST['password'];
        $err = false;

        $reUser = "/^[a-z0-9]{4,20}$/";
        $rePass = "/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/";

        if(!preg_match($reUser,$username)){
            $err = true;
        }
        if(!preg_match($rePass,$inpass)){
            $err = true;
        }
        $password = md5($inpass);            
        if($err){
            header("Location: ../index.php?page=login&outcome=error");
        }
        else{
            try{
                $logquery="SELECT * FROM users WHERE username = :username AND password = :password";
                $preparelog = $conn->prepare($logquery);
                $preparelog->bindParam(":username",$username);
                $preparelog->bindParam(":password",$password);
                $result=$preparelog->execute();
                
                if($result){
                    $info = $preparelog->fetch();
                    
                    $_SESSION['user'] = $info;
                    logUser($_SESSION['user']);
                    if($_SESSION['user']->role_id=="2"){
                        header("Location: ../index.php?page=admin");
                    }
                    
                    else if($_SESSION['user']->role_id=="1"){
                        header("Location: ../index.php?page=account");
                    }
                    else{
                        unset($_SESSION['user']);
                        header("Location: ../index.php?page=login&outcome=error");
                    }
                }
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
            }
        }
    }
?>