<?php
    require_once "models/functions.php";
    $commId = $_GET['id'];
    $data = getComment($commId);
?>
<div class="d-flex flex-column align-items-center justify-content-center text-left">
    <div class="col-6 m-5 p-4 profilePersonal">
        <h3>Edit comment</h3>
        <div class="form-group mt-2">
        <form method="POST" action="models/editComment.php" enctype="multipart/form-data">
            <input type="hidden" name="postId" value="<?= $commId ?>">
            <label for="text">Change text </label><br>
            <textarea class="p-2" id="text" name="text"><?= $data->text ?></textarea>
            <button type="submit" class="btn btn-light btn-outline-success mt-3 mb-2" id="btnSrc" name="update">UPDATE</button>
        </form>
        <?php
            if(isset($_SESSION['errors'])){
                echo "You've made a few mistakes: <br>";
                foreach($_SESSION['errors'] as $err){
                    echo "- ".$err."<br>";
                }
                unset($_SESSION['errors']);
            }
            if(isset($_GET['outcome'])){
                if($_GET['outcome']=='done'){
                    echo "You've successfully edited your comment.";
                }
                else{
                    echo "Something went wrong, try again.";
                }
            }
        ?>
    </div>
</div>