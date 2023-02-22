<div class="d-flex flex-column align-items-center justify-content-center mt-5 text-center">
    <div id="logovanje" class="p-3">
            <h3>Log In</h3>

            <form method="POST" action="models/login.php">
            <div class="form-group mt-4">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username">
</div>
    <div class="form-group mt-2">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password">
</div>
<div class="form-group mt-2 pb-3" id="loginSbmt">
<button type="submit" class="btn btn-light btn-outline-success" id="login" name="login">Log In</button>
</div>
<p>
Don't have an account?<br>
Click <span id="regClick"><a href="index.php?page=register">here</a></span> to register.

</p>
</form>
    </div>
    <?php
        if(isset($_GET['outcome'])):
    ?>
       <div class="fttxt title text-center mb-2"><h5>Something went wrong, try again.</h5>
        </div>
    <?php
        endif;
    ?>
</div>