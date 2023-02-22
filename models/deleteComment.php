<?php
    if(isset($_GET['id'])){
        $commId = $_GET['id'];
        try{
            require_once "../config/connection.php";
            $query = "DELETE FROM post_comments WHERE id=$commId";
            $result = $conn->exec($query);
            header("Location: ../index.php?page=posts");
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }
?>