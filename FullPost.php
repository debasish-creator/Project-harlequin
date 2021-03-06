<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"];?>
<?php
//setting connection of name submit
if(isset($_POST["Submit"])) {
    $Name = $_POST["CommenterName"];
    $Email = $_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H: %M: %S", $CurrentTime);

    if (empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
    } elseif (strlen($Comment)>500) {
        $_SESSION["ErrorMessage"] = "comment length should be less than 500 character";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
    } else{
        //Query to insert comment in database when everything is good
        global $ConnectingDB;
        $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)VALUES(:datetime,:name ,:email,:comment,'Pending','OFF',:postIdFromURL)";
        $stmt = $ConnectingDB->prepare($sql);

        //binding the values

        $stmt->bindValue(':datetime', $DateTime);
        $stmt->bindValue(':name', $Name);
        $stmt->bindValue(':email', $Email);
        $stmt->bindValue(':comment', $Comment);
        $stmt->bindValue(':postIdFromURL', $SearchQueryParameter);
        $Execute = $stmt->execute();


        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Comment submitted Successfully";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
        } else {
            $_SESSION["ErrorMessage"] = "something went wrong... Try Again !";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
        }
    }
}

?>
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
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="css/FullPost.css">
    <link rel="stylesheet" href="css/main.css">

    <title>Full Post</title>
</head>
<body>
<!--NAVIGATION BAR STARTS-->
<div class="navbar navbar-expand-lg navbar-dark bg-custom cst">
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
<!--HEADER STARTS-->
<div class="user-info" style="font-family: 'Times New Roman';font-weight: bold;" data-aos = "fade-right">
    WEBWIZ
    <br>
    <br>
    The official Medium <br>
    of WEBWIZ. <br>Learn more:
    <br>
    https://webwiz.xyz
    <br>
    <br>
    <button type="button" class="btn btn-success">Follow</button>
    <!-- left sidebar ends -->

    <!-- comment sidebar starts... -->
    <div class="sidenav" id="mySidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
            &times;
        </a>
        <section>
            <div class="container">
                <div class="row">
                    <div class="">
                        <h1>Comments</h1>
                        <?php
                        global $ConnectingDB;
                        $sql ="SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
                        $stmt =$ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()){
                            $CommentDate = $DataRows['datetime'];
                            $CommenterName = $DataRows['name'];
                            $CommentContent = $DataRows['comment'];

                            ?>
                            <div class="comment mt-4 text-justify float-left"> <img src="images/comment.png" alt="" class="rounded-circle" width="40" height="40">
                                <h4><?php echo $CommenterName; ?></h4> <span>- <?php echo $CommentDate; ?></span> <br>
                                <p>
                                    <?php echo $CommentContent; ?>
                                </p>
                            </div>
                            <hr>
                        <?php } ?>
                    </div>
                    <!--ends of fetching commenting parts-->
                    <div class="">
                        <form  class="" id="algin-form" action="FullPost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
                            <div class="form-group">
                                <h4>Leave a comment</h4>
                                <label for="message">Message</label>
                                <textarea name="CommenterThoughts" id=""  cols="30" rows="5" class="form-control" style="background-color: white;">

                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="CommenterName" id="" class="form-control" placeholder="want your name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="CommenterEmail" placeholder="want your Email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="Submit" class="btn btn-success" style="margin: 1rem 0 1rem 0;">Post Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <a href="javascript:void(0)"><i class="fa fa-comment comt" aria-hidden="true" onclick="openNav()"></i></a>
</div>
<div class="container">
    <div class="row justify-content-md-center">

        <!--main area starts---->
        <div class="col-md-6 align-self-center">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>

            <!--            when search button is active-->
            <?php
            global $ConnectingDB;
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
//                default query

            else{
                $PostIdFromURL = $_GET["id"];
                if(!isset($PostIdFromURL)){
                    $_SESSION["ErrorMessage"]="Bad Request !";
                    Redirect_to("index.php");
                }
                $sql = "SELECT * FROM posts WHERE id= '$PostIdFromURL'";
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
            //
            $Image2 = $DataRows["image2"];
            $PostDescription2 = $DataRows["post2"];
            //
            $Image3 = $DataRows["image3"];
            $PostDescription3 = $DataRows["post3"];

            ?>

            <h1 class="phoenix" style="margin-left:-1.50rem; 
    font-family: fell, Georgia, Cambria, 'Times New Roman', Times, serif;
 padding: 2rem;  font-size: 48px ; letter-spacing: -0.011em;">
                <?php echo htmlentities($PostTitle)?>
                <br>
            </h1>
            <article class="blog-post">
                <!--author description-->
                <img alt="Sean Kernan" class="cimg" src="images/comment.png"  style="width:40px; height:40px; margin-right:3px;">
                <p class="blog-post-meta">
                <h5 style="padding-top: 0.64rem; font-size:1rem">
                    <a  style="color:rgba(26, 137, 23, 1);" href="Profile.php?username=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin);?></a>
                    on <?php echo htmlentities($DateTime); ?>
                </h5>
                <br>
                </p>

                <p>
                <h5 style="    font-family: sohne, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:22px; color:rgba(117, 117, 117, 1);font-weight: 400;">This blog post shows a few different types of content that’s supported and styled with
                    Bootstrap. Basic typography, images, and code are all supported.
                </h5>
                </p>
                <img src="Uploads/<?php echo htmlentities($Image); ?>" alt="" class="responsive">

                <hr>
                <p>
                    <?php  echo nl2br($PostDescription) ?>
                </p>
                <img src="Uploads/<?php echo htmlentities($Image2); ?>" alt="" class="responsive">
                <p>
                    <?php  echo nl2br($PostDescription2) ?>
                </p>
                <img src="Uploads/<?php echo htmlentities($Image3); ?>" alt="" class="responsive">
                <p>
                    <?php  echo nl2br($PostDescription3) ?>
                </p>
            </article>

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
                         <span class="badge" style="padding: 0.65rem; margin-bottom: 1rem; background-color:#f2f2f2; color:#757575; font-size: 13px; font-weight: 400;">
                         <?php echo $CategoryName; ?>
                         </span>
                    </a>
                <?php }?>
            </div>
        </div>
        <?php } ?>

        <br>
        <br>
        <!--starting of comment part.-->
        <!--fetching existing comments from database-->
        <section class="mobile-comt">
            <div class="container2">
                <div class="row">
                    <div class="">
                        <h1>Comments</h1>
                        <?php
                        global $ConnectingDB;
                        $sql ="SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
                        $stmt =$ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()){
                            $CommentDate = $DataRows['datetime'];
                            $CommenterName = $DataRows['name'];
                            $CommentContent = $DataRows['comment'];

                            ?>


                            <div class="comment mt-4 text-justify float-left"> <img src="images/comment.png" alt="" class="rounded-circle" width="40" height="40">
                                <h4><?php echo $CommenterName; ?></h4> <span>- <?php echo $CommentDate; ?></span> <br>
                                <p>
                                    <?php echo $CommentContent; ?>
                                </p>
                            </div>
                            <hr>
                        <?php } ?>
                    </div>
                    <!--ends of fetching commenting parts-->
                    <div class="">
                        <form id="algin-form" class=""action="FullPost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
                            <div class="form-group">
                                <h4>Leave a comment</h4>
                                <label for="message">Message</label>
                                <textarea name="CommenterThoughts" id="" msg resize="none" class="form-control" style="background-color: white;">

                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="CommenterName" id="fullname" class="form-control" placeholder="want your name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="CommenterEmail" placeholder="want your Email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="Submit" class="btn btn-success" style="padding: 1rem;">Post Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        offset: 500,
        duration: 1000,
    });

    const openNav = () => {
        document.getElementById('mySidenav').style.width="20rem";
    }
    const closeNav = () => {
        document.getElementById('mySidenav').style.width="0";
    }
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>


</body>

</html>

