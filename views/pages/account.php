<?php
    require_once "models/functions.php";
    $userId = $_SESSION['user']->user_id;
    $userData = getAcc($userId);
?>
<div class="d-flex flex-column flex-md-row align-items-center align-items-md-start justify-content-center">
    <div class="col-6 col-md-3 m-5 p-4 text-center d-flex flex-column align-items-center justify-content-center profilePersonal profilLeft">
        <div>
            <p id="hoverEdit"><a href="index.php?page=phChange">Change Photo</a></p>
            <img src="<?= $userData->src_og ?>" alt="<?= $userData->alt ?>" class="img-fluid mb-2 profilSlika">  
            <p><span class="infoAcc"><?= $userData->username ?></span><br>
            <span class="infoAcc">Date od reg :</span> <?php 
                $prep = $userData->created_at;
                $ceo = explode(' ', $prep);
                $date = $ceo[0];
                echo $date;
            ?><br>
            <span class="infoAcc">Last seen :</span> <?php
                echo date('Y-m-d');
            ?>
            </p>
        </div>
    </div>
    <div class="col-11 col-md-7 m-5 p-4 profilePersonal d-flex flex-column align-items-center justify-content-center">        
        <div class="text-right">
        <h3><a href="index.php?page=newPost">New post <i class="far fa-edit"></i></a></h3>
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center">
            <?php
                $posts = getPostsOfAcc($userId);
                if($posts==null){
                    echo "<h3>You haven't made any posts yet.</h3>";
                }
                foreach($posts as $p):
            ?>

            <div class=" d-flex flex-column align-items-center justify-content-center p-3 mt-2 col-10 profilePersonal">
                <div class="a">
                    <img src="<?= $p->src ?>" alt="<?= $p->alt ?>" class="img-fluid postSlika">
                </div>
                <div class="postTitle mt-2">
                    <a href="index.php?page=post&postId=<?= $p->post_id ?>"><h2><?= $p->title ?></h2></a>
                </div>
                <div class="mt-2">
                    <p><?= $p->text ?></p>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <i class="far fa-clock pr-2 pl-2"></i> 
                    <?php 
                        $prep = $p->created_at;
                        $ceo = explode(' ', $prep);
                        $date = $ceo[0];
                        echo $date;
                    ?>
                    <i class="far fa-comment-alt pr-2 pl-2 komClick"></i>
                    <?php
                        $postId = $p->post_id;
                        $number = getNumOfComms($postId);
                        echo $number->num;
                    ?>
                    <a href="index.php?page=editPost&id=<?= $postId ?>"><i class="far fa-edit pr-2 pl-2"></i>edit</a>
                    <a href="models/deletePost.php?id=<?= $postId ?>"><i class="far fa-trash-alt pr-2 pl-2"></i>delete</a>
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
                </div>
            </div>
            <?php
                endforeach;
            ?>
        </div>
    </div>
</div>