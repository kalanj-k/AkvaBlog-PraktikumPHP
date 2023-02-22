<div class="d-flex flex-column align-items-center justify-content-center mt-5 text-center">
    <div id="phChange" class="d-flex flex-column align-items-center justify-content-center p-3">
            <h3>Change your avatar</h3>

            <form method="POST" action="models/photoChange.php" enctype="multipart/form-data">
            

<input type="file" class="form-control-file" id="slika" name="slika">
<button type="submit" class="btn btn-light btn-outline-success mt-2" id="submit" name="submit">SUBMIT</button>

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