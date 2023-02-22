<?php
    require_once '../config/connection.php';
    if(isset($_SESSION['user'])){
        $file = fopen(currentlyLogged, 'w');
        $data = file(currentlyLogged);
        $allData = [];
        foreach($data as $d){
            $allData[] = explode('\n', $d);
            echo $allData;
        }
        for($i=0;$i<count($allData);$i++){
            if($allData[$i][0]==$_SESSION['user']->username){
                unset($allData[$i]);
            }
        }
        $newData = implode('\n', $allData);
        fwrite($file, $newData);
        fclose($file);
        unset($_SESSION['user']);
        session_destroy();
        header("Location: ../index.php");
    }
    else{
        header("Location: ../index.php");
    }
?>