<?php
    $location = $_SERVER['PHP_SELF'];
    if($location == "/pphp/sajt/config/connection.php"){
        header("Location: ../index.php");
    }
// abs
define("absolutePath", $_SERVER['DOCUMENT_ROOT'].'/pphp/sajt');
// 
define("envFile", absolutePath."/config/.env");
define("logsFile", absolutePath."/data/logs.txt");
define("currentlyLogged", absolutePath."/data/currentlyLogged.txt");
// db
define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));




//baza
function env($naziv){
    $prep = fopen(envFile, "r");
    $data = file(envFile);
    $value= "";
    foreach($data as $key=>$d){
        $config = explode("=", $d);
        if($config[0]==$naziv){
            $value = trim($config[1]);
        }
    }
    return $value;
}