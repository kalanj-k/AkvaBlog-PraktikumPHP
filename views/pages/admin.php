<div class="d-flex flex-column flex-md-row align-items-center align-items-md-start justify-content-center">
    <div class="col-11 col-md-4 m-5 p-4 text-center d-flex flex-column align-items-center justify-content-center profilePersonal profilLeftAdmin">
        <h3>Currently online:<br> 
        <?php
            $file = file(currentlyLogged);
            $number = count($file);
            echo $number;
        ?>
        </h3>
        <h3>Last logs: </h3>
        <table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col">Page</th>
      <th scope="col">Username</th>
      <th scope="col">Time</th>
    </tr>
  </thead>
  <tbody>
        <?php
            $file = file(logsFile);
            $number = count($file);
            $allData = [];
            foreach($file as $d){
                $allData[] = explode('\n', $d);
            }
            $startPos = count($allData);
            for($i=$startPos; $i>=count($allData)-5; $i--):
                $oneLine = explode("\t\t",$allData[$i-1][0]);
                
        ?>
    <tr>
      <td><?= $oneLine[1] ?></td>
      <td><?= $oneLine[2] ?></td>
      <td><?= $oneLine[4] ?></td>
    </tr>
    <?php
        endfor;
    ?>
  </tbody>
</table>
<h3>Most viewed posts: </h3>
<?php
    $fileP = file(logsFile);
    $fileAll = [];
    foreach($fileP as $f){
        $fileAll[]= explode("\t",$f);
    }
    $filePName=[];
    foreach ($fileAll as $fa){
        $filePName[]=$fa[2];
    }


    $allPosts = $conn->query("SELECT * FROM posts")->fetchAll();
    $arrPosts = [];
    foreach($allPosts as $a){
        $arrPosts[$a->post_id]= 0;
    }
    $arrId=[];
    foreach($allPosts as $p){
        $arrId[]=$p->post_id;
    }
    $totalVisit = 0;

    foreach($filePName as $fp){
        if(in_array($fp, $arrId)){
            $arrPosts[$fp]++;
            $totalVisit++;
        }
    }
    arsort($arrPosts);  //najveci prvo
    function visits($val,$totalVisit=1){
        return ((float)$val*100)/$totalVisit;
    }
    $numOfPosts = 0;
    foreach($arrPosts as $key => $val):
        $title = $conn->query("SELECT post_id, title FROM posts WHERE post_id=$key")->fetch();
?>
<h5><a href="index.php?page=post&postId=<?= $title->post_id ?>"><?= $title->title ?></a> : <?= visits($val,$totalVisit) ?>%</h5>
<?php
    var_dump(visits($val,$totalVisit));
    $numOfPosts++;
    if($numOfPosts==5){
        break;
    }
endforeach;
?>
<h3>Excel: </h3>
<a href="models/excelDoc.php"><button type="button" class="btn btn-light btn-outline-success">EXCEL</button></a>
<p>Usernames, emails, date of registration</p>
</div>

<div class="col-11 col-md-6 m-5 p-4 profilePersonal d-flex flex-column align-items-center justify-content-center">        
<h3>Users: </h3>

<table class="table table-dark text-center">
  <thead>
    <tr>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Registration</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
      <?php
        $users = $conn->query("SELECT * FROM users")->fetchAll();
        foreach($users as $u):
        ?>
    <tr>
      <th scope="row"><?= $u->username ?></th>
      <td><?= $u->email ?></td>
      <td><?= $u->created_at ?></td>
      <td><a href="index.php?page=editUser&id=<?= $u->user_id ?>"><i class="far fa-edit"></i></a></td>
      <td><a href="models/deleteUser.php?id=<?= $u->user_id ?>"><i class="fas fa-trash-alt"></i></a></td>
    </tr>
    <?php
        endforeach;
    ?>
  </tbody>
</table>
<h3>Posts: </h3>
<table class="table table-dark text-center">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Username</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
        <?php
        $posts = $conn->query("SELECT * FROM posts p INNER JOIN users u ON p.user_id=u.user_id ORDER BY p.post_id ASC")->fetchAll();
        foreach($posts as $p):
        ?>
    <tr>
      <th scope="row"><?= $p->title ?></th>
      <td><?= $p->username ?></td>
      <td><a href="index.php?page=editPost&id=<?= $p->post_id ?>"><i class="far fa-edit"></i></a></td>
      <td><a href="models/deletePost.php?id=<?= $p->post_id ?>"><i class="fas fa-trash-alt"></i></a></td>
    </tr>
    <?php
        endforeach;
    ?>
  </tbody>
</table>
</div>
</div>
