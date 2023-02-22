<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="index.php">AkvaBlog</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="dokumentacija.pdf" target="_blank">Dokumentacija <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=author">Author <span class="sr-only">(current)</span></a>
      </li>
      <?php
        if(!isset($_SESSION['user'])):
      ?>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=register">Register <span class="sr-only">(current)</span></a>
      </li>
      <?php
        endif;
      ?>
      <?php
        if(isset($_SESSION['user'])):
      ?>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=posts">Posts <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=account">Account <span class="sr-only">(current)</span></a>
      </li>
      <?php
        if(isset($_SESSION['user'])):
        if($_SESSION['user']->role_id=="2"):
      ?>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=admin">Admin <span class="sr-only">(current)</span></a>
      </li>  
      <?php
        endif;
        endif;
      ?>
      <li class="nav-item active">
        <a class="nav-link" href="models/logout.php">Logout <span class="sr-only">(current)</span></a>
      </li>
      <?php
        endif;
      ?>


    </ul>
  </div>
</nav>