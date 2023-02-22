<?php
    require_once "models/functions.php";
?>
<div class="d-flex justify-content-center">
    <div id="posts col-9">
<?php
    $postId = $_GET['postId'];
    $data = getPostWithUserAndImages($postId);
    foreach($data as $d):
?>
<div class="d-flex justify-content-center m-5 text-center col-5 col-sm-11">
    <div class="d-flex flex-column align-items-center justify-content-center postAu col-2">
        <img src="<?= $d->userSrc ?>" alt="<?= $d->userAlt ?>" class="img-fluid postIco">
        <p><?= $d->username ?></p>
    </div>
    <div class="postBckg d-flex flex-column p-3 col-9">
        <div class="a">
            <img src="<?= $d->postSrc ?>" alt="<?= $d->postAlt ?>" class="img-fluid postSlika">
        </div>
        <div class="postTitle mt-2">
            <h2><?= $d->title ?></h2>
        </div>
        <div class="text-justify">
            <p><?= $d->txt ?></p>
        </div>
        <div class="d-flex justify-content-end align-items-center">
            <i class="far fa-clock pr-2 pl-2"></i> 
            <?php 
                $prep = $d->created;
                $ceo = explode(' ', $prep);
                $date = $ceo[0];
                echo $date;
            ?>
            <i class="far fa-comment-alt pr-2 pl-2 komClick"></i>
            <?php
                $postId = $d->postId;
                $number = getNumOfComms($postId);
                echo $number->num;
            ?>
        </div>
    <div class="komDiv">
        
        <?php
            $comms = getCommentsOfPost($postId);
            foreach($comms as $c):
        ?>
        <div class="d-flex flex-column komentari mt-2 p-2">
            <div class="d-flex justify-content-end align-items-center">
                <p><?= $c->created ?></p>
                <?php
                    if($_SESSION['user']->user_id == $c->userId || $_SESSION['user']->role_id == 2):
                ?>
                <a href="index.php?page=editComment&id=<?= $c->id ?>"><i class="far fa-edit pr-2 pl-2"></i>edit</a>
                <a href="models/deleteComment.php?id=<?= $c->id ?>"><i class="far fa-trash-alt pr-2 pl-2"></i>delete</a>
                <?php
                    endif;
                ?>
            </div>
            <div class="d-flex">
            <div class="d-flex flex-column justify-content-center align-items-center col-3">
                    <img src="<?= $c->src ?>" alt="<?= $c->alt ?>" class="img-fluid postIco mb-1">
                    <p><?= $c->username ?></p>
            </div>
            <div class="d-flex align-items-center p-2 col-9">
                <p><?= $c->txt ?></p>
            </div>
            
            </div>
        </div>
        <?php
            endforeach;
        ?>
        <div class="komentari d-flex flex-column align-items-center justify-content-center p-2 ">
            <form method="POST" action="models/comment.php">
            <input type="hidden" name="postId" value="<?= $d->postId ?>">
            <textarea class="p-2 mt-2" name="tkomentar" placeholder="5-250 characters"></textarea>
            <button type="submit" class="btn btn-light btn-outline-success mt-2" id="komentar" name="komentar">Leave a comment</button>
            </form>
        </div>
    </div>
    </div>
</div>
<?php
    endforeach;
?>
</div>
</div>
