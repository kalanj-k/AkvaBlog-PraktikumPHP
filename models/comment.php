<?php
    if(isset($_POST['komentar'])){
        require_once "../config/connection.php";
        $postId = $_POST['postId'];
        $txt = $_POST['tkomentar'];
        $userId = $_SESSION['user']->user_id;
        //reg
        $textReg = '/^[A-zšđžčćŠĐŽČĆ 1-9]{5,250}/';
        $errors= [];
        if(!preg_match($textReg, $txt)){
            array_push($errors, "Wrong text length.");
        }
        if(count($errors) > 0){
            $_SESSION['errors'] = $errors;
            header("Location: ../index.php?page=posts");
        }
        else{
            try{
                $query = "INSERT INTO post_comments(text, post_id, user_id) VALUES(:txt, :post_id, :user_id)";
                $prep = $conn->prepare($query);
                $prep->bindParam(':txt', $txt);
                $prep->bindParam(':post_id', $postId);
                $prep->bindParam(':user_id', $userId);
                $data = $prep->execute();
                if($data){
                    header("Location: ../index.php?page=post&postId=".$postId);
                }
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
            }
        }
    }
?>