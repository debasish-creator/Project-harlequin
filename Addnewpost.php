<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
if(isset($_POST["Submit"])){
    $PostTitle = $_POST["PostTitle"];
    $Category = $_POST["Category"];
    $Image = $_FILES["Image"]["name"];
    $Target = "Uploads/".basename($_FILES["Image"]["name"]);
    $PostText = $_POST["PostDescription"];
    //    2nd content
    $Image2 = $_FILES["Image2"]["name"];
    $Target2 = "Uploads/".basename($_FILES["Image2"]["name"]);
    $PostText2 = $_POST["PostDescription2"];
    // 3 rd content
    $Image3 = $_FILES["Image3"]["name"];
    $Target3 = "Uploads/".basename($_FILES["Image3"]["name"]);
    $PostText3 = $_POST["PostDescription3"];
    //---end
    $Admin = $_SESSION["UserName"];
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H: %M: %S",$CurrentTime);


    if(empty($PostTitle)){
        $_SESSION["ErrorMessage"] = "Title Cannot be empty";
        Redirect_to("Addnewpost.php");
    }elseif (strlen($PostTitle)<5){
        $_SESSION["ErrorMessage"] = "Post title should be greater than 5 character";
        Redirect_to("Addnewpost.php");
    }elseif (strlen($PostText)>9999) {
        $_SESSION["ErrorMessage"] = "Primary content of post should be less than 1000 character";
        Redirect_to("Addnewpost.php");
    }elseif (strlen($PostText2)>9999) {
        $_SESSION["ErrorMessage"] = "secondary content should be less than 1000 character";
        Redirect_to("Addnewpost.php");
    }elseif (strlen($PostText3)>9999) {
        $_SESSION["ErrorMessage"] = "Tertiary content should be less than 1000 character";
        Redirect_to("Addnewpost.php");
    }else{
        //Query to insert post in database when everything is good
        global $ConnectingDB;
        $sql = "INSERT INTO posts(datetime,title,category,author,image,post,image2,post2,image3,post3)VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription,:imageName2,:postDescription2,:imageName3,:postDescription3)";
        $stmt = $ConnectingDB->prepare($sql);

        //binding the values
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':postTitle',$PostTitle);
        $stmt->bindValue(':categoryName',$Category);
        $stmt->bindValue(':adminName',$Admin);
        $stmt->bindValue(':imageName',$Image);
        $stmt->bindValue(':postDescription',$PostText);
        //
        $stmt->bindValue(':imageName2',$Image2);
        $stmt->bindValue(':postDescription2',$PostText2);
        //
        $stmt->bindValue(':imageName3',$Image3);
        $stmt->bindValue(':postDescription3',$PostText3);


        $Execute=$stmt->execute();
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        move_uploaded_file($_FILES["Image2"]["tmp_name"],$Target2);
        move_uploaded_file($_FILES["Image3"]["tmp_name"],$Target3);

        if($Execute){
            $_SESSION["SuccessMessage"]="post with id : ".$ConnectingDB->lastInsertId() ." Added Successfully";
            Redirect_to("Addnewpost.php");
        }else{
            $_SESSION["ErrorMessage"]= "something went wrong. Try Again !";
            Redirect_to("Addnewpost.php");
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scal=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/7f6ee3d237.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <title>Add New Post</title>
</head>
<body>
<?php  ?>
<!--NAVBAR STARTS-->
<div class="navbar navbar-expand-lg navbar-light bg-custom">
    <div class="container">
        <a href="#" class="navbar-brand " style= "color:aliceblue; font-family: mindsagacustom;">MindSaga</a>
        <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse" data-bs-target="#Rcollapse" aria-controls="Rcollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="Rcollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link" style= "color:white ; font-weight: bolder;">My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link" style= "color:white ; font-weight: bolder;">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link" style= "color:white ; font-weight: bolder;">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link" style= "color:white ; font-weight: bolder;">Categories</a>
                </li>

                <li class="nav-item">
                    <a href="Admins.php" class="nav-link" style= "color:white ; font-weight: bolder;">Manage-Admins</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link" style= "color:white ; font-weight: bolder;">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link" style= "color:white ; font-weight: bolder;">GO Live</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="Logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

    </div>
</div>
<!--NAVBAR ENDS-->

<!--HEADER STARTS-->
<header class="text-white py-3"style="background-image:linear-gradient(360deg, #1B80B2 ,#1B0039);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-edit"></i> Add New Post</h1>
            </div>
        </div>
    </div>
</header>
<!--HEADER ENDS-->

<!--MAIN AREA-->
<section class="container py-2 mb-4">
    <div class="row">
        <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="" action="Addnewpost.php" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="fieldinfo">Post Title :</span></label>
                            <input class="form-control" type="text" name="PostTitle" placeholder="Type title here">
                        </div>
                        <div class="form-group">
                            <label for="CategoryTitle"><span class="fieldinfo">Choose Category :</span></label>
                            <select class="form-control" id="CategoryTitle" name="Category">
                                <?php
                                // fetching all the category from category table
                                global $ConnectingDB;
                                $sql = "SELECT id,title FROM category";
                                $stmt = $ConnectingDB->Query($sql);
                                while ($Datarows =$stmt->fetch()){
                                    $Id = $Datarows["id"];
                                    $CategoryName = $Datarows["title"];
                                    ?>
                                    <option><?php echo $CategoryName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!--Primary part-->
                        <div class="form-group">
                            <div class="custom-file">
                                <input class="custom-file-input"type="file" name="Image" id="imageselect" value="">
                                <label for="imageselect" class="custom-file-label">Select Image 1 </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post"><span class="fieldinfo">Content 1:</span></label>
                            <textarea class="form-control" name="PostDescription" cols="80" rows="8" id="Post"></textarea>
                        </div>
                        <!--Primary part ends-->
                        <!--secondary part-->
                        <div class="form-group">
                            <div class="custom-file">
                                <input class="custom-file-input"type="file" name="Image2" id="imageselect2" value="">
                                <label for="imageselect2" class="custom-file-label">Select Image 2 </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post2"><span class="fieldinfo">Content 2 :</span></label>
                            <textarea class="form-control" name="PostDescription2" cols="80" rows="8" id="Post2"></textarea>
                        </div>
                        <!--secondary part ends-->
                        <!--tertiary part-->
                        <div class="form-group">
                            <div class="custom-file">
                                <input class="custom-file-input"type="file" name="Image3" id="imageselect3" value="">
                                <label for="imageselect3" class="custom-file-label">Select Image 3 </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post3"><span class="fieldinfo">Content 3 :</span></label>
                            <textarea class="form-control" name="PostDescription3" cols="80" rows="8" id="Post3"></textarea>
                        </div>
                        <!--tertiary part end-->
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="#" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="Submit" name="Submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!--footer starts-->
<?php require_once ("Backendfooter.php");?>


