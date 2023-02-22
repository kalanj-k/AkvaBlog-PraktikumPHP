<?php
    require_once '../config/connection.php';
    $users = $conn->query("SELECT * FROM users WHERE role_id=1")->fetchAll();
    $fileName = "User info.xls";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$fileName");  
    header("Pragma: no-cache");
    header("Expires: 0");
    if($users){
        echo "Username"."\t\t"."Email"."\t\t\t"."Registered"."\n";
        foreach($users as $u){
            $date = explode(" ", $u->created_at);
            echo "$u->username"."\t\t"."$u->email"."\t\t\t"."$date[0]"."\n";
        }
    }
?>