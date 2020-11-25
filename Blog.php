<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scal=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/7f6ee3d237.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <title>Blog Page</title>
</head>
<body>
<!--NAVIGATION BAR STARTS-->
<div style="height: 10px; background: cornflowerblue"></div>
<div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="#" class="navbar-brand">THINK HARD</a>
        <button style="background-color: #BEC9F2;" class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#Rcollapse">
            <span class="navbar-toggle-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="Rcollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="Blog.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php" class="nav-link">Blog</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Features</a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <form class="form-inline d-none d-sm-block" action="Blog.php">
                    <div class="form-group">
                        <input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
                        <button  class="btn btn-primary" name="SearchButton">Go</button>

                    </div>
                </form>
            </ul>
        </div>

    </div>
</div>
<div style="height: 10px; background: cornflowerblue"></div>
<!--NAVIGATION BAR STARTS-->

<!--HEADER STARTS-->
<div class="container">
    <div class="row mt-4">

        <!--main area starts---->

        <div class="col-sm-8">
          <h1>The Complete Responsive CMS Blog</h1>
            <h1 class="lead">By Debashis Nayak</h1>
            <?php
            $ConnectingDB;
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

            else{
                $sql = "SELECT * FROM posts ORDER BY id desc";
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
            <div class="card">
                <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height: 450px;" class="img-fluid card-img-top"/>
                <div class="cardbody">
                    <h4 class="card-title px-3"><?php echo htmlentities($PostTitle)?></h4>
                    <small class="text-muted px-3">Written by <?php echo htmlentities($Admin);?> on <?php echo htmlentities($DateTime); ?></small>
                    <span style="float: right" class="badge badge-dark text-light px-3">Comments 20</span>
                    <hr>
                    <p class="card-text px-4">
                        <?php if (strlen($PostDescription)>150){$PostDescription = substr($PostDescription,0,150).'...';} echo htmlentities($PostDescription) ?>
                    </p>
                    <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float: right" class="px-2 py-2">
                        <span class="btn btn-info px-1"> Read More >></span>
                    </a>
                </div>
            </div>
                <br>
            <?php } ?>
        </div>
        <div class="offset-sm-1 col-sm-3 " style="min-height:40px;background: red">

        </div>
    </div>
</div>
<!--HEADER ENDS-->

<!--FOOTER STARTS-->
<div style="height: 5px; background: cornflowerblue"></div>
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">THINK HARD |  <span id="year"></span>&copy: -----All right reserved</p>
            </div>
        </div>
    </div>
</footer>
<div style="height: 5px; background: cornflowerblue"></div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
    $('#year').text(new Date().getFullYear());
</script>
</body>
</html>

