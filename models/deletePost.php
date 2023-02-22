<?php
    if(isset($_GET['id'])){
        $postId = $_GET['id'];
        try{
            require_once "../config/connection.php";
            $query = "DELETE FROM posts WHERE post_id=$postId";
            $result = $conn->exec($query);
            header("Location: ../index.php?page=account");
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

?>