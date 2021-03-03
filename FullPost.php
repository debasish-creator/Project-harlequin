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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/fullpost.css">

    <title>Full Post</title>
    <style media="screen">
        .heading{
            font-family: Bitter,Georgia,"Times New Roman",Times,serif;
            font-weight: bold;
            color: #005E90;
        }
        .heading:hover{
            color: #0090DB;
        }
    </style>
</head>
<body>
<!--NAVIGATION BAR STARTS-->
<div class="navbar navbar-expand-lg navbar-dark bg-custom">
    <div class="container-fluid">
        <a href="#" class="navbar-brand " style= "color:aliceblue; font-family: mindsagacustom;">MindSaga</a>
        <button class="navbar-toggler ml-auto custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Rcollapse" aria-controls="Rcollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="Rcollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="index.php?page=1" class="nav-link" style= "color:white ; font-weight: bolder;">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" style= "color:white ; font-weight: bolder;">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=1" class="nav-link" style= "color:white ; font-weight: bolder;">Blog</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" style= "color:white ; font-weight: bolder;">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" style= "color:white ; font-weight: bolder;">Features</a>
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
<!--NAVIGATION BAR ENDS-->

<!--HEADER STARTS-->
<div class="user-info" data-aos = "fade-right">
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
                <div class="">
                    <form id="algin-form" class=""action="FullPost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
                        <div class="form-group">
                            <h4>Leave a comment</h4>
                            <label for="message">Message</label>
                            <textarea name="CommenterThoughts" id="" msg cols="30" rows="5" class="form-control" style="background-color: white;">

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
                <h1 class="phoenix" style="align-items: center;  font-family:  'Bebas Neue', cursive; padding: 2rem; padding-left: 4rem; font-size: 60px;">
                    <?php echo htmlentities($PostTitle)?>
                    <br>
                </h1>
                <article class="blog-post">
                  <!--author description-->
                    <img alt="Sean Kernan" class="cimg" src="https://miro.medium.com/fit/c/72/72/1*guKWDyFxW4c3NBQrrHt2PA.jpeg">
                    <p class="blog-post-meta">
                        <h5 style="padding-top: 0.64rem;"><?php echo htmlentities($DateTime); ?> by <a href="#"><?php echo htmlentities($Admin);?></a></h5>
                        <br>
                    </p>

                    <p>
                       <h5 style="font-family: 'Akaya Telivigala', cursive;">This blog post shows a few different types of content that’s supported and styled with
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
                <span class="badge bg-secondary" style="padding: 0.65rem; margin-bottom: 1rem;">Secondary</span>
                <span class="badge bg-secondary"style="padding: 0.65rem;">Secondary</span>
                <span class="badge bg-secondary"style="padding: 0.65rem;">Secondary</span>
                <span class="badge bg-secondary"style="padding: 0.65rem;">Secondary</span>
            </div>
        <?php } ?>
            <br>
            <br>
        <!--starting of comment part.-->
        <!--fetching existing comments from database-->
        <section class="mobile-comt">
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
                        <form id="algin-form" class=""action="FullPost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
                            <div class="form-group">
                                <h4>Leave a comment</h4>
                                <label for="message">Message</label>
                                <textarea name="CommenterThoughts" id="" msg cols="30" rows="5" class="form-control" style="background-color: white;">

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

        <?php require_once ("footer.php");?>



