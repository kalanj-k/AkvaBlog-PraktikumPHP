<div class="d-flex justify-content-center text-left">
    
    <div class="col-6 m-5 p-4 profilePersonal">
        <h3>New post</h3>
        <div class="form-group mt-2">
        <form method="POST" action="models/newPost.php" enctype="multipart/form-data"">
            <label for="title">Input title *</label><br>
            <input type="text" class="form-control mb-1" id="newTitle" name="title" placeholder="10-100 characters">
            <label for="text">Input text *</label><br>
            <textarea class="p-2" id="text" name="text" placeholder="10-1000 characters"></textarea>
            <label for="category">Choose category *</label><br>
            <select class="custom-select mb-2" id="newCategory" name="category">
                <option selected value="0">Category...</option>
                <?php
                    require_once "models/functions.php";
                    $categories = getCategories();
                    foreach($categories as $cat):
                ?>
                    <option value="<?= $cat->cat_id ?>"><?= $cat->name ?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <label for="slika">Add image *</label>
            <input type="file" class="form-control-file mt-1" id="slika" name="slika">
            <button type="submit" class="btn btn-light btn-outline-success mt-3 mb-2" id="btnSrc" name="submit">SUBMIT</button>
        </form>
        </div>
        <?php
            if(isset($_SESSION['errors'])){
                echo "You've made a few mistakes: <br>";
                foreach($_SESSION['errors'] as $err){
                    echo "- ".$err."<br>";
                }
                unset($_SESSION['errors']);
            }
            if(isset($_GET['outcome'])){
                echo "You've successfully made a post.";
            }
        ?>
        
    </div>
</div>