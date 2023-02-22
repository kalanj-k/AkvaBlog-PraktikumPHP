<?php
    require_once "models/functions.php";
    $userId = $_GET['id'];
    $data = getUserEdit($userId);
    $roles = getRoles();
?>
<div class="d-flex flex-column align-items-center justify-content-center text-left">
    <div class="col-12 col-md-5 m-5 p-4 profilePersonal">
        <h3>Edit user</h3>
        <div class="form-group mt-2">
        <form method="POST" action="models/editUser.php" enctype="multipart/form-data" onsubmit="return editCheck()">
            <input type="hidden" name="userId" value="<?= $userId ?>">
            <label for="username">Change username - small letters or numbers, 4-20</label><br>
            <input type="text" class="form-control mb-1" id="username" name="username" value="<?= $data->username ?>">
            <label for="password">Change password - must contain uppercase, lowercase, number, spec. char, 8+</label><br>
            <input type="password" class="form-control mb-1" id="password" name="password">
            <label for="email">Change email - ex. topshrimp@gmail.com</label><br>
            <input type="text" class="form-control mb-1" id="email" name="email" value="<?= $data->email ?>">
            <label for="role">Change role </label><br>
            <select class="custom-select mb-2" id="role" name="role">
                <?php
                    foreach($roles as $r):
                ?>
                  <option value="<?= $r->role_id ?>"><?= $r->name ?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <label for="slika">Change image </label>
            <input type="file" class="form-control-file mt-1" id="slika" name="slika">
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
                    echo "You've successfully edited a user.";
                }
                else{
                    echo "Something went wrong, try again.";
                }
            }
        ?>
    </div>
</div>