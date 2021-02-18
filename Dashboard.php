<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login(); ?>


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
    <title>Dashboard</title>
</head>
<body>
<!--NAVIGATION BAR-->
<div class="navbar navbar-expand-lg navbar-light bg-custom">
    <div class="container">
        <a href="#" class="navbar-brand " style= "color:aliceblue; font-family: mindsagacustom;">MindSaga</a>
        <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse" data-bs-target="#Rcollapse" aria-controls="Rcollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="Rcollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item" >
                    <a href="MyProfile.php" class="nav-link" style= "color:white ; font-weight: bolder;">My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" style= "color:white ; font-weight: bolder;">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link" style= "color:white ; font-weight: bolder;">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link" style= "color:white ; font-weight: bolder;">Categories</a>
                </li>

                <li class="nav-item">
                    <a href="Admins.php" class="nav-link" style= "color:white ; font-weight: bolder;">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link" style= "color:white ; font-weight: bolder;">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link" style= "color:white ; font-weight: bolder;">GO Live</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" ><a href="Logout.php" class="nav-link text-warning" ><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

    </div>
</div>
<!--NAVBAR-->

<!--HEADER-->
<header class=" text-white py-3" style="background-image:linear-gradient(360deg, #1B80B2 ,#1B0039);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1> <i  class="fa fa-dashboard" style="color:rgb(252, 255, 254) ; padding-right:40px; "></i> Dashboard</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Addnewpost.php" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Add New Post
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Categories.php" class="btn btn-info btn-block">
                    <i class="fas fa-folder-plus"></i> Add New category
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Admins.php" class="btn btn-warning btn-block">
                    <i class="fas fa-user-plus"></i> Add New Admin
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Comments.php" class="btn btn-success btn-block">
                    <i class="fas fa-check"></i> Manage Comments
                </a>
            </div>
    </div>
</header>
<!--HEADER-->


<!--MAIN AREA-->
<section class="container py-2 mb-4">
    <div class="row">

               <!-- left side starts-->

        <div class="col-lg-2 d-none d-md-block" >
                    

<div class="flip-card"   >
  <div class="flip-card-inner"  >
    <div class="flip-card-front" style="padding-top:20px;">
      <h1 class="lead" style="font-weight:bold;" >Posts</h1>
      <h4 class="display-5">    
    <i class="fab fa-readme"></i> </h4> 
    </div>
    <div class="flip-card-back">
    <h4 class="display-5" style="padding-top:30px;">    
        <?php 
        TotalPosts();
        ?>
        </h4>
    </div>
  </div>
</div>


<div class="flip-card"   style="margin-top:10px;" >
  <div class="flip-card-inner"  >
    <div class="flip-card-front" style="padding-top:20px;">
      <h1 class="lead" style="font-weight:bold;" >Categories</h1>
      <h4 class="display-5">    
    <i class="fa fa-list" style="padding-top:1px; padding-left:0px;" ></i> </h4> 
    </div>
    <div class="flip-card-back">
    <h4 class="display-5" style="padding-top:30px;">    
        <?php 
         TotalCategories();
        ?>
        </h4>
    </div>
  </div>
</div>

<div class="flip-card"   style="margin-top:10px; " >
  <div class="flip-card-inner"  >
    <div class="flip-card-front" style="padding-top:20px;">
      <h1 class="lead" style="font-weight:bold;" >Admins</h1>
      <h4 class="display-5">    
    <i class="fas fa-users"></i> </h4> 
    </div>
    <div class="flip-card-back">
    <h4 class="display-5" style="padding-top:30px;">    
        <?php 
         TotalAdmins();
        ?>
        </h4>
    </div>
  </div>
</div>


<div class="flip-card"   style="margin-top:10px; " >
  <div class="flip-card-inner"  >
    <div class="flip-card-front" style="padding-top:20px;">
      <h1 class="lead" style="font-weight:bold;" >Comments</h1>
      <h4 class="display-5">    
    <i class="fas fa-comments"></i> </h4> 
    </div>
    <div class="flip-card-back">
    <h4 class="display-5" style="padding-top:30px;">    
        <?php 
         TotalComments();
        ?>
        </h4>
    </div>
  </div>
</div>



            </div>
              <!--left-side ends-->

              <!--right area starts-->
            <div class="col-lg-10" style="padding-left:70px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
            <h1 style="padding-bottom :15px;">Top Posts</h1>
            <table class="styled-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Date&Time</th>
            <th>Author</th>
            <th>Comments</th>
            <th>Details</th>
        </tr>
    </thead>
    <?php
                    $SrNo = 0;
                    global $ConnectingDB;
                    $sql="SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt=$ConnectingDB->query($sql);
                    while($DataRows=$stmt->fetch()){
                        $PostId = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $Author = $DataRows["author"];
                        $Title =  $DataRows["title"];
                        $SrNo++;
                    ?>    
    <tbody>
    <tr>
                        <td><?php echo $SrNo;?></td>
                        <td><?php echo $Title;?></td>
                        <td><?php echo $DateTime;?></td>
                        <td><?php echo $Author;?></td>
                        <td>
                                <?php
                                $Total=ApproveCommentsAccordingtoPost($PostId);
                                if($Total>0) {
                                ?>
                                 <span class="badge badge-success">
                                     <?php
                                    echo $Total; ?>
                                 </span>
                                 <?php } ?>
                                 </span>
                                <?php
                                $Total=DisApproveCommentsAccordingtoPost($PostId);
                                if($Total>0) {
                                    ?>
                                    <span class="badge badge-danger">
                                     <?php
                                     echo $Total; ?>
                                 </span>
                                <?php } ?>
                                </span>
                        </td>
                        <td><a href="FullPost.php?id=<?php echo $PostId; ?>" target="_blank" > </a> <span class="btn" style="background-color: #190053; color:white">Preview</span></td>
                    </tr>

    </tbody>
    <?php } ?>
</table>
</div>
    </div>
</section>
<!--MAIN AREA-->
<!--FOOTER-->
<?php require_once ("Backendfooter.php");?>

