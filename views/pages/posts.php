<?php
    require_once "models/functions.php";
    $posts = allPosts();
    $numOfPosts = numOfInitialPosts();
    $numOfPages = numOfPages($numOfPosts->num);
?>
<div class="d-flex flex-column flex-md-row justify-content-center">
    <div class="col-12 col-md-9 order-2 order-md-1">
    <div id="sviPostovi">
    <?php
      foreach($posts as $p):
        $dat = explode(' ', $p->created);
    ?>
    <div class="d-flex flex-column flex-md-row justify-content-center m-5 text-center col-11">
        <div class="d-flex flex-column align-items-center justify-content-center postAu col-2">
            <img src="<?= $p->src ?>" alt="<?= $p->alt ?>" class="img-fluid postIco">
            <p><?= $p->username ?></p>
        </div>
        <div class="postBckgSmall d-flex flex-column p-3 col-9">
            <div class="a">
                    <img src="<?= $p->pSrc ?>" alt="<?= $p->pAlt ?>" class="img-fluid postSlika">
            </div>
            <div class="postTitle mt-2">
                <a href="index.php?page=post&postId=<?= $p->id ?>"><h2><?= $p->title ?></h2></a>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <i class="far fa-clock pr-2 pl-2"></i> <?= $dat[0] ?>
            </div>
        </div>
    </div>
    <?php
      endforeach;
    ?>
    </div>
    <div class="d-flex justify-content-center col-12">
      <ul id ="pagination" class="d-flex flex-row justify-content-center text-center col-12">
      <?php
          for($i=1;$i<=$numOfPages;$i++):
        ?>
            <li class="paginacija m-2"><a href="#" class="paginationNum" data-limit="<?= $i ?>"><?= $i ?></a></li>
        <?php
          endfor;
        ?>
      </ul>
    </div>
    </div>
    <div id="filter" class="col-12 col-md-3 order-1 order-nd-2">
        <div class="m-5 d-flex justify-content-center">
              <div class="form-group  d-flex flex-column justify-content-center">
                <select class="custom-select mt-2 mb-2" id="ddSort" name="ddSort">
                  <option value="ASC-id" selected>Sort By...</option>
                  <option value="DESC-date">Newest</option>
                  <option value="ASC-date">Oldest</option>
                  <option value="ASC-title">A-Z</option>
                  <option value="DESC-title">Z-A</option>
                </select>
                <select class="custom-select mt-2 mb-2" id="ddCategory" name="ddCategory">
                <option value="0" selected>All</option>
                <?php
                    $categories = getCategories();
                    foreach($categories as $cat):
                ?>
                    <option value="<?= $cat->cat_id ?>"><?= $cat->name ?></option>
                <?php
                    endforeach;
                ?>
                </select>
                <input type="text" class="form-control mt-2 mb-2" id="srchTxt" name="srchTxt" placeholder="Search...">

                <button type="button" class="btn btn-light btn-outline-success mt-1 mb-2" id="filSub">SUBMIT</button>
                <button type="button" class="btn btn-light btn-outline-success mt-1 mb-2" id="filRes">RESET</button>
              </div>
                </div>
    </div>
</div>
