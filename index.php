<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/7f6ee3d237.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <title>Mind Saga</title>
    <style>
        .heading{
            font-family: Bitter,Georgia,"Times New Roman",Times,serif;
            font-weight: bold;
            color: blue;
        }
    </style>
</head>
<body>
<!--NAVIGATION BAR STARTS-->
<div class="navbar navbar-expand-lg navbar-dark bg-custom">
    <div class="container-fluid">
        <a href="#" class="navbar-brand " style= "color:aliceblue; font-family: mindsagacustom;">MindSaga</a>
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#NavbarContent" aria-controls="NavbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
<!--        CONTENT WHEN NAVBAR IS COLLAPSE-->
        <div class="collapse navbar-collapse" id="NavbarContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link active" style= "color:white ; font-weight: bolder; ">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link " style= "color:white ; font-weight: bolder; ">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link " style= "color:white ; font-weight: bolder; ">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" style= "color:white ; font-weight: bolder; ">Features</a>
                </li>
                <li class="nav-item">
                    <a href="Login.php" class="nav-link " style= "color:white ; font-weight: bolder; " >Log In</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <form class="form-inline d-none d-sm-block" action="index.php">
                    <div class="form-group">
                        <input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
                        <button  class="btn btn-primary" name="SearchButton">Go</button>
                    </div>
                </form>
            </ul>
        </div>
    </div>
</div>
<!--NAVIGATION BAR ends-->

<!--HEADER STARTS-->

<div class="card" style="margin: 10px 50px 20px 50px;">
    <div class="card-body col-xs-6 col-sm-4 col-lg-12" style="    background-color: rgb(250, 250, 250);">
        <?php
        global $ConnectingDB;
        $sql= "SELECT * FROM posts ORDER BY id desc LIMIT 0,8";
        $stmt= $ConnectingDB->query($sql);
        while ($DataRows=$stmt->fetch()) {
            $Id     = $DataRows['id'];
            $Title  = $DataRows['title'];
            $DateTime = $DataRows['datetime'];
            $Image = $DataRows['image'];
            ?>
            <div class="media" style="display: inline-flex; flex-direction: row; margin-left: 30px; margin-right: 30px; float: left; width=30%;">
                <div class="" style="flex-basis: 40%;">
                    <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start"  width="90" height="94" alt="">
                </div>
                <div class="media-body" style="flex-basis: 60%;" >
                    <a style="text-decoration:none;"href="FullPost.php?id=<?php echo htmlentities($Id) ; ?>" target="_blank">
                        <h6 class="lead heading"><?php echo htmlentities($Title); ?></h6>
                    </a>
                    <p class="small"><?php echo htmlentities($DateTime); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="container">
    <div class="row mt-5">
        <!--main area starts---->
        <div class="col-sm-8">

            <div class="card-body">
            <?php
            global $ConnectingDB;
            //sql query when search button is active
            if(isset($_GET["SearchButton"])){
                $Search = $_GET["Search"];
                $sql="SELECT * FROM posts 
                 WHERE datetime LIKE :Search
                 OR title LIKE :Search
                 OR category LIKE :Search 
                 OR post LIKE :Search";
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindvalue(':Search','%'.$Search.'%');
                $stmt->execute();
            }

            //Query when pagination is active
            elseif (isset($_GET["page"])){
                $Page = $_GET["page"];
                if($Page==0||$Page<1){
                    $ShowPostFrom=0;
                }else {
                    $ShowPostFrom = ($Page * 10) - 10;
                }
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,10";
                $stmt = $ConnectingDB->query($sql);
            }
            //Query when category is active in URL tab
            elseif(isset($_GET["category"])){
                $Category = $_GET["category"];
                $sql = "SELECT * FROM posts  WHERE category='$Category' ORDER BY id desc";
                $stmt = $ConnectingDB->query($sql);
            }
            //the default SQL query
            else{
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,10";
                $stmt = $ConnectingDB->query($sql);
            }
            while ($DataRows = $stmt->fetch()){
                $PostId = $DataRows["id"];
                $DateTime = $DataRows["datetime"];
                $PostTitle = $DataRows["title"];
                $Category  = $DataRows["category"];
                $Admin = $DataRows["author"];
                $Image = $DataRows["image"];
                $PostDescription = $DataRows["post"];
                ?>
                <div class="media" style='    font-family: sohne, "Helvetica Neue", Helvetica, Arial, sans-serif;color: rgba(41, 41, 41, 1);font-size:16px;'>
                    <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" style="width: 155px; height: 155px; margin-top: 9px;" alt="">
                        <div class="media-body ml-2 card-body" style="outline:hidden; margin-top: 25px; padding-left: 6px; ">
                            <h3 class="card-title" >
                                <a href="FullPost.php?id=<?php echo htmlentities($PostId);?>" target="_blank" style="color: #1B0039;font-weight:bolder;">
                                 <h3 style="    font-weight: 550;font-size:23.5px;     line-height: normal;"><?php echo htmlentities($PostTitle); ?></h3>
                                </a>
                            </h3>
                            <p class="card-text" style="color: rgba(117, 117, 117, 1);">
                               By <a href="Profile.php?username=<?php echo htmlentities($Admin); ?>" style="color: rgba(26, 137, 23, 1); font-weight:400;">
                                  <?php echo htmlentities($Admin); ?>
                                  </a>
                                  </br>
                           
                               <?php if (strlen($PostDescription)>150){$PostDescription = substr($PostDescription,0,70).'...';} echo htmlentities($PostDescription) ?>
                               </br>
                               <?php echo htmlentities($DateTime); ?>
                           </p>
                      </div>
                </div>
                <hr>
            <?php } ?>
            </div>
        </div>
        <!--side area starts-->
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header text-light" style = "background-color:#430264!important">
                    <h2 class="lead">Discover More of What Matters to You</h2>
                </div>
                <div class="card-body">
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT *FROM category ORDER BY id desc";
                    $stmt = $ConnectingDB->query($sql);
                    while ($DataRows = $stmt->fetch()){
                        $categoryId = $DataRows["id"];
                        $CategoryName=$DataRows["title"];
                        ?>
                        <a href="index.php?category=<?php echo $CategoryName; ?>">
                            <span class="badge bg-secondary" style="padding: 0.8rem; margin: 1rem 1rem 1rem 1rem ;background-color:#6509bb!important; ">
                                <?php echo $CategoryName; ?>
                            </span></a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--pagination-->
<nav style="float: left;">
    <ul class="pagination pagination-lg">
        <!--backward button-->
        <?php
        if(isset($Page)){
            if($Page>1){
                ?>
                <li class="page-item">
                    <a href="index.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
                </li>
            <?php } }?>
        <?php
        global $ConnectingDB;
        $sql = "SELECT COUNT(*) FROM posts";
        $stmt = $ConnectingDB->query($sql);
        $RowPagination=$stmt->fetch();
        $TotalPosts=array_shift($RowPagination);
        //echo $TotalPosts."<br>";
        $PostPagination=$TotalPosts/10;
        $PostPagination=ceil($PostPagination);
        // echo $PostPagination;
        for ($i=1; $i<=$PostPagination ; $i++){
            if(isset($Page)){
                if($i==$Page){
                    ?>
                    <li class="page-item active">
                        <a href="index.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                    </li>

                    <?php
                }else{
                    ?>

                    <li class="page-item">
                        <a href="index.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                    </li>
                    <?php
                } } }
        ?>
        <!--                       forward button-->
        <?php
        if(isset($Page)&&!empty($Page)){
            if($Page+1<=$PostPagination){

                ?>
                <li class="page-item">
                    <a href="index.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
                </li>
            <?php } }?>
    </ul>
</nav>
<!--side area and footer-->
<?php require_once ("footer.php");?>

