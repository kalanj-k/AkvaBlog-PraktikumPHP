<?php
    session_start();

    $location = $_SERVER['PHP_SELF'];
    if($location == "/pphp/sajt/config/connection.php"){
        header("Location: ../index.php");
    }
    require_once "config.php";

    pageAccess();
    try{
        $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
    }

    function pageAccess(){
        $username = "Anon";
        $page = "Login";
        $date = date("Y-m-d H:i:s");
        $location = $_SERVER['PHP_SELF'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $postId = 0;
        if(isset($_SESSION['user'])){
            $username = $_SESSION['user']->username;
        }
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        if(isset($_GET['postId'])){
            $postId = $_GET['postId'];
        }
        define("forbiddenFolder","models");
        $file = fopen(logsFile, "a");

        if($file){
            if(!strpos($_SERVER['PHP_SELF'],forbiddenFolder)){
                if($postId!=0){
                    fwrite($file, "{$location}\t\t{$postId}\t\t{$username}\t\t{$ip}\t\t{$date}\n");
                    fclose($file);
                }
                else{
                    fwrite($file, "{$location}\t\t{$page}\t\t{$username}\t\t{$ip}\t\t{$date}\n");
                    fclose($file);
                }
            }
        }
    }
    function logUser($user){
        $file = fopen(currentlyLogged, "a");
        fwrite($file, "{$user->username}\n");
        fclose($file);
    }
    
?>