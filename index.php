<?php
  
  include "views/fixed/head.php";
  include "views/fixed/nav.php";

  if(isset($_GET['page'])){
    switch($_GET['page'])
    {
      case 'login':
        if(isset($_SESSION['user']))
          include "views/pages/posts.php";
        else
          include "views/pages/login.php";
        break;
      case 'register':
        if(isset($_SESSION['user']))
          include "views/pages/posts.php";
        else
          include "views/pages/register.php";
        break;
      case 'posts':
        if(!isset($_SESSION['user']))
          include "views/pages/login.php";
        else
          include "views/pages/posts.php";
        break;
      case 'post':
        if(!isset($_SESSION['user']))
          include "views/pages/login.php";
        else
          include "views/pages/post.php";
        break;
      case 'account':
        if(!isset($_SESSION['user']))
          include "views/pages/login.php";
        else
          include "views/pages/account.php";
        break;
      case 'admin':
        if(isset($_SESSION['user']) && $_SESSION['user']->role_id==2)
          include "views/pages/admin.php";
        else
          include "views/pages/login.php";
        break;
      case 'editPost':
        if(!isset($_SESSION['user']))
          include "views/pages/login.php";
        else
          include "views/pages/editPost.php";
        break;
      case 'newPost':
        if(!isset($_SESSION['user']))
          include "views/pages/login.php";
        else
          include "views/pages/newPost.php";
        break;
      case 'phChange':
        if(!isset($_SESSION['user']))
          include "views/pages/login.php";
        else
          include "views/pages/photoChange.php";
        break;
      case 'editComment':
        if(!isset($_SESSION['user']))
          include "views/pages/login.php";
        else
          include "views/pages/editComment.php";
        break;
      case 'author':
        include "views/pages/author.php";
        break;
      case 'editUser':
        if(!isset($_SESSION['user']))
          include "views/pages/login.php";
        else
          include "views/pages/editUser.php";
        break;
    }
  } else {
    include "views/pages/login.php";
  }

  include "views/fixed/footer.php";
  include "views/fixed/scripts.php";
?>


      