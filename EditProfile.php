<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();
?>
<?php
//fetching Admin data start
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch()){
    $ExistingName     = $DataRows['aname'];
    $ExistingUsername = $DataRows['username'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio      = $DataRows['abio'];
    $ExistingImage    = $DataRows['aimage'];
}
//fetching admin data ends
if(isset($_POST["Submit"])){
    $AName     = $_POST["Name"];
    $AHeadline = $_POST["Headline"];
    $ABio      = $_POST["Bio"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "images/".basename($_FILES["Image"]["name"]);
    if (strlen($AHeadline)>30) {
        $_SESSION["ErrorMessage"] = "Headline Should be less than 30 characters";
        Redirect_to("EditProfile.php");
    }elseif (strlen($ABio)>500) {
        $_SESSION["ErrorMessage"] = "Bio should be less than than 500 characters";
        Redirect_to("EditProfile.php");
    }else{

        // Query to Update Admin Data in DB When everything is fine
        global $ConnectingDB;
        if (!empty($_FILES["Image"]["name"])) {
            $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
              WHERE id='$AdminId'";
        }else {
            $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
              WHERE id='$AdminId'";
        }
        $Execute= $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute){
            $_SESSION["SuccessMessage"]="Details Updated Successfully";
            Redirect_to("EditProfile.php");
        }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("EditProfile.php");
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
    <title>Edit Profile</title>
</head>
<body>
<?php  ?>
<!--NAVBAR STARTS-->

<div class="navbar navbar-expand-lg navbar-dark bg-custom">
    <div class="container">
        <a href="#" class="navbar-brand " style= "color:aliceblue; font-family: mindsagacustom;">MindSaga</a>
        <button class="navbar-toggler ml-auto custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Rcollapse" aria-controls="Rcollapse" aria-expanded="false" aria-label="Toggle navigation">
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
                <li class="nav-item"><a href="Logout.php" class="nav-link text-warning"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
                <h1><i class="fas fa-user text-success mar-2"></i> @<?php echo $ExistingUsername; ?></h1>
                <small><?php echo $ExistingHeadline;?></small>
            </div>
        </div>
    </div>
</header>
<br><br><br>
<!--HEADER ENDS-->

<!----MAIN AREA---->
<section class="container py-2 mb-4">
    <div class="row">
        <!--RIGHT AREA-->
        <div class="offset-lg-2 col-lg-8" style="min-height: 400px;">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="" action="EditProfile.php" method="post" enctype="multipart/form-data">
                <div class="card bg-dark text-light">
                    <div class="card-header bg-secondary text-light">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input class="form-control" type="text" name="Name" id="title"  value=" ">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" id="title" placeholder="Headline" name="Headline" value="">
                            <small class="text-muted"> Add a professional headline like, 'Engineer' at XYZ or 'Architect' </small>
                            <span class="text-danger">Not more than 30 characters</span>
                        </div>
                        <div class="form-group">
                            <textarea  placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80">

                            </textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="MyProfile.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To My Profile</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!--FOOTER STARTS-->
<?php require_once ("Backendfooter.php");?>
