<?php
    require_once "../config/connection.php";
    header("Content-Type: application/json");
    $data=null;
    try{
        $limit = isset($_POST['limit'])?$_POST['limit']:0;

        $broj = 10;

        $query="SELECT p.post_id as id, um.src as src, um.alt as alt, title, p.created_at as created, username, pm.src as pSrc, pm.alt as pAlt
        FROM posts p INNER JOIN users u ON p.user_id=u.user_id INNER JOIN user_img um ON u.user_id=um.user_id 
        INNER JOIN post_img pm ON pm.post_id=p.post_id";
        
        if(!isset($_POST['resetuj'])){
            if(isset($_POST['txt'])){
                $txt = "'%".$_POST['txt']."%'";
                $query.= " WHERE title LIKE ".$txt;
            }

            if(isset($_POST['cat'])){
            $category = $_POST['cat'];
                switch($category){
                    case 0: $query.= ""; break;
                    case 1: $query.= " AND p.cat_id=".$category; break;
                    case 2: $query.= " AND p.cat_id=".$category; break;
                    case 3: $query.= " AND p.cat_id=".$category; break;
                    case 4: $query.= " AND p.cat_id=".$category; break;
                }
            }

            if(isset($_POST['sort'])){
                $sort = $_POST['sort'];
                switch($sort){
                    case "ASC-id": $query.= " ORDER BY p.post_id ASC"; break;
                    case "DESC-date": $query.= " ORDER BY p.created_at DESC"; break;
                    case "ASC-date": $query.= " ORDER BY p.created_at ASC"; break;
                    case "ASC-title": $query.= " ORDER BY p.title ASC"; break;
                    case "DESC-title": $query.= " ORDER BY p.title DESC"; break;
                }
            }
            else{
                $query.= " ORDER BY p.post_id ASC";
            }
        }
        $query.=" LIMIT $limit, $broj";
        $posts = $conn->query($query)->fetchAll();
        $num = count($posts);
        $numOfPages = ceil($num / 9);
        echo json_encode([
            "posts" => $posts,
            "num" => $num,
            "pg" => $numOfPages
        ]);
        http_response_code(200);
    }
    catch(PDOException $ex){
        echo $ex->getMessage();
        http_response_code(500);
    }
?>