<div class="d-flex flex-column align-items-center justify-content-center text-left">
    <div class="col-6 m-5 p-4 profilePersonal">
        <h3>Contact us</h3>
        <div class="form-group mt-2">
        <form method="POST" action="models/mail.php" onsubmit="return editContact()">
            <label for="name">Your name</label><br>
            <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Your Name">
            <label for="email">Your email</label><br>
            <input type="text" class="form-control mb-1" id="email" name="email" placeholder="ex. yourname@gmail.com">
            <label for="subject">Subject</label><br>
            <input type="text" class="form-control mb-1" id="subject" name="subject" placeholder="10-150 characters">
            <label for="text">Text </label><br>
            <textarea class="p-2" id="text" name="text">up to 300 characters</textarea>
            <button type="submit" class="btn btn-light btn-outline-success mt-3 mb-2" id="btnSrc" name="submit">SUBMIT</button>
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
                    echo "You've successfully edited a post.";
                }
                else{
                    echo "Something went wrong, try again.";
                }
            }
        ?>
    </div>
</div>