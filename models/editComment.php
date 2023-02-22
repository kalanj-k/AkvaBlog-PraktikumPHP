<?php
    if(isset($_POST['update'])){
        require_once "../config/connection.php";
        $id = $_POST['postId'];
        $text = $_POST['text'];
        //reg
        $textReg = '/^[A-zšđžčćŠĐŽČĆ 1-9]{5,250}/';
        $errors= [];
        //check
        if(!preg_match($textReg, $text)){
            array_push($errors, "Wrong text length.");
        }
        if(count($errors) > 0){
            $_SESSION['errors'] = $errors;
            header("Location: ../index.php?page=editComment&id=".$id);
        }
        else{
            try{
                $query = "UPDATE post_comments SET `text`=:text WHERE id = :id";
                $prep = $conn->prepare($query);
                $prep->bindParam(':text', $text);
                $prep->bindParam(':id', $id);
                $done = $prep->execute();
                if($done){
                    header("Location: ../index.php?page=editComment&id=".$id."&outcome=done");
                }
                else{
                    header("Location: ../index.php?page=editComment&id=".$id."&outcome=failed");
                }
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
            }
        }
    }
?>