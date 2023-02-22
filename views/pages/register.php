<div class="d-flex flex-column align-items-center justify-content-center mt-5 text-center">
    <div id="logovanje" class="p-3">
        <h3>Register</h3>
        <form id="forma" action="models/register.php" method="POST" onsubmit="return formCheck()">
        <div class="form-group mt-4">
            <label for="username">Username:</label><br>
            <input type="text" class="form-control" id="username" name="username" placeholder="small letters or numbers, 4-20">
            <span class="text-center feedbackBad">Try again!</span>
        </div>
        <div class="form-group mt-2">
            <label for="email">Email :</label><br>
            <input type="text" class="form-control" id="email" name="email" placeholder="ex. topshrimp@gmail.com">
            <span class="text-center feedbackBad">Try again!</span>
        </div>
        <div class="form-group mt-2">
            <label for="password">Password:</label><br>
            <input type="password" class="form-control" id="password" name="password" placeholder="no less than 8 characters!">
            <span class="text-center feedbackBad">Try again!</span>    
        </div>
        <div class="form-group mt-2">
            <label for="rePassword"> Repeat Password:</label><br>
            <input type="password" class="form-control" id="rePassword" name="rePassword">
            <span class="text-center feedbackBad">Try again!</span>
        </div>
        <div class="form-group mt-2">
            <button type="submit" class="btn btn-light btn-outline-success" id="register" name="register">Register</button>
        </div>
        </form>
    </div>
    
    <?php
        if(isset($_GET['outcome'])):
            if($_GET['outcome']=='done'):
    ?>
        <div class="flex-column d-flex justify-content-center align-items-center mt-2 short p-2">
            <div class="fttxt title text-center mb-2"><h5>You have been registered.<br>
                <span class="fttxt"><a href="index.php?page=login">Log in!</a></span></h5>
            </div>
        </div>
    <?php
        endif;
        endif;
    ?>
    <?php
        if(isset($_GET['outcome'])){
            if($_GET['outcome']=='failed'){
                echo "Something went wrong, try again.";
            }
        }
    ?>
</div>