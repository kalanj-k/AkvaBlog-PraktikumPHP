<?php
    if(isset($_GET['id'])){
        $userId = $_GET['id'];
        try{
            require_once "../config/connection.php";
            $query = "DELETE FROM users WHERE user_id=$userId";
            $result = $conn->exec($query);
            header("Location: ../index.php?page=admin");
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

?>