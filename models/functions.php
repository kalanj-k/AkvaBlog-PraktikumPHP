<?php
require_once "config/connection.php";

function getCategories(){
    global $conn;
    $data = $conn->query("SELECT * FROM categories")->fetchAll();
    return $data;
}

function getAdminPosts(){
    global $conn;
    $data = $conn->query("SELECT * FROM posts")->fetchAll();
    return $data;
}

function getPostWithUserAndImages($postId){
    global $conn;
    $data = $conn->query("SELECT p.post_id as postId, p.title as title, p.text as txt, p.created_at as created, pm.src as postSrc, 
    pm.alt as postAlt, username, ui.src userSrc, ui.alt as userAlt
    FROM posts p INNER JOIN post_img pm ON p.post_id=pm.post_id 
    INNER JOIN users u ON u.user_id=p.user_id 
    INNER JOIN user_img ui ON u.user_id=ui.user_id
    WHERE p.post_id=$postId")->fetchAll();
    return $data;
}

function getCommentsOfPost($postId){
    global $conn;
    $query = "SELECT pc.id as id, pc.text as txt, pc.created_at as created, u.username as username, u.user_id as userId, um.src as src, um.alt as alt 
    FROM post_comments pc INNER JOIN users u ON pc.user_id=u.user_id 
    INNER JOIN user_img um ON u.user_id=um.user_id
    WHERE pc.post_id = :postId
    ORDER BY pc.created_at ASC";
    $prep = $conn->prepare($query);
    $prep->bindParam(':postId', $postId);
    $prep->execute();
    $data = $prep->fetchAll();
    return $data;
}

function getNumOfComms($postId){
    global $conn;
    $query = "SELECT COUNT(id) as num FROM post_comments WHERE post_id=:postId";
    $prep = $conn->prepare($query);
    $prep->bindParam(':postId', $postId);
    $prep->execute();
    $data = $prep->fetch();
    return $data;
}

function getAcc($userId){
    global $conn;
    $data = $conn->query("SELECT * FROM users u INNER JOIN user_img um ON u.user_id=um.user_id WHERE u.user_id=$userId")->fetch();
    return $data;
}

function getPostsOfAcc($userId){
    global $conn;
    $data = $conn->query("SELECT * FROM posts p INNER JOIN post_img pm ON p.post_id=pm.post_id WHERE p.user_id=$userId")->fetchAll();
    return $data;
}

function getPostEdit($postId){
    global $conn;
    $data = $conn->query("SELECT * FROM posts WHERE post_id=$postId")->fetch();
    return $data;
}

function getComment($commId){
    global $conn;
    $data = $conn->query("SELECT * FROM post_comments WHERE id=$commId")->fetch();
    return $data;
}

function getUserEdit($userId){
    global $conn;
    $data = $conn->query("SELECT * FROM users WHERE user_id=$userId")->fetch();
    return $data;
}

function getRoles(){
    global $conn;
    $data = $conn->query("SELECT * FROM roles");
    return $data;
}

//

function allPosts($limit = 0){
    global $conn;
    $query="SELECT p.post_id as id, um.src as src, um.alt as alt, title, p.created_at as created, username, pm.src as pSrc, pm.alt as pAlt
    FROM posts p INNER JOIN users u ON p.user_id=u.user_id INNER JOIN user_img um ON u.user_id=um.user_id 
    INNER JOIN post_img pm ON pm.post_id=p.post_id ORDER BY p.post_id ASC
    LIMIT $limit, 10";
    $data = $conn->query($query)->fetchAll();
    return $data;
}

function numOfInitialPosts(){
    global $conn;
    $data = $conn->query("SELECT COUNT(post_id) as num FROM posts")->fetch();
    return $data;
}

function numOfPosts($posts){
    $num = count($posts);
    return $num;
}

function numOfPages($num){
    $numOfPosts = $num;
    $numOfPages = ceil($numOfPosts / 9);
    return $numOfPages;
}
?>