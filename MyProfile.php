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
        Redirect_to("MyProfile.php");
    }elseif (strlen($ABio)>500) {
        $_SESSION["ErrorMessage"] = "Bio should be less than than 500 characters";
        Redirect_to("MyProfile.php");
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
            Redirect_to("MyProfile.php");
        }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("MyProfile.php");
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
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/MyProfile.css">
        <title>My Profile</title>
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
                        <a href="#" class="nav-link" style= "color:white ; font-weight: bolder;">My Profile</a>
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
<?php
echo ErrorMessage();
echo SuccessMessage();
?>
    <div class="test-2">
     <section class="profile-card">
        <header>
            <!-- Profile Image-->
            <a href="#">
                <img src="images/<?php echo $ExistingImage; ?>" alt="image">
            </a>

            <!-- Name of author -->
            <h1><?php echo$ExistingName; ?></h1>

            <!-- Field of Profession -->
            <h2><?php echo $ExistingHeadline; ?></h2>
        </header>
        <!-- bit of a bio; who are you? -->
        <div class="profile-bio">
            <p><?php echo $ExistingBio; ?></p>
        </div>
        <!-- some social links to show off -->
        <ul class="profile-social-links">
            <!-- your first social profile -->
            <li>
                <a href="#">
                    <svg viewBox="0 0 24 24">
                        <path fill="#3b5998" d="M17,2V2H17V6H15C14.31,6 14,6.81 14,7.5V10H14L17,10V14H14V22H10V14H7V10H10V6A4,4 0 0,1 14,2H17Z" />
                    </svg>
                </a>
            </li>
            <!-- your 2nd social profile -->
            <li>
                <a href="#">
                    <svg viewBox="0 0 24 24">
                        <path fill="#82B541" d="M18.334,1.909c-0.604-0.327-2.313-0.125-4.375,0.503c-3.621,2.464-6.664,6.11-6.89,11.971c-0.05,0.148-0.402-0.025-0.478-0.053c-0.981-1.859-1.358-3.846-0.554-6.688C6.189,7.39,5.686,7.089,5.611,7.165C5.435,7.34,4.681,8.145,4.178,9c-2.464,4.249-0.855,9.733,3.445,12.122c4.299,2.389,9.733,0.855,12.12-3.445C22.533,12.695,19.969,2.814,18.334,1.909z"
                        />
                    </svg>
                </a>
            </li>
            <!--- your 3rd social profile-->
            <li>
                <a href="#">
                    <svg viewBox="0 0 24 24">
                        <path fill="#000000" d="M19.45,13.29L17.5,12L19.45,10.71M12.77,18.78V15.17L16.13,12.93L18.83,14.74M12,13.83L9.26,12L12,10.17L14.74,12M11.23,18.78L5.17,14.74L7.87,12.93L11.23,15.17M4.55,10.71L6.5,12L4.55,13.29M11.23,5.22V8.83L7.87,11.07L5.17,9.26M12.77,5.22L18.83,9.26L16.13,11.07L12.77,8.83M21,9.16C21,9.15 21,9.13 21,9.12C21,9.1 21,9.08 20.97,9.06C20.97,9.05 20.97,9.03 20.96,9C20.96,9 20.95,9 20.94,8.96C20.94,8.95 20.93,8.94 20.92,8.93C20.92,8.91 20.91,8.89 20.9,8.88C20.89,8.86 20.88,8.85 20.88,8.84C20.87,8.82 20.85,8.81 20.84,8.79C20.83,8.78 20.83,8.77 20.82,8.76A0.04,0.04 0 0,0 20.78,8.72C20.77,8.71 20.76,8.7 20.75,8.69C20.73,8.67 20.72,8.66 20.7,8.65C20.69,8.64 20.68,8.63 20.67,8.62C20.66,8.62 20.66,8.62 20.66,8.61L12.43,3.13C12.17,2.96 11.83,2.96 11.57,3.13L3.34,8.61C3.34,8.62 3.34,8.62 3.33,8.62C3.32,8.63 3.31,8.64 3.3,8.65C3.28,8.66 3.27,8.67 3.25,8.69C3.24,8.7 3.23,8.71 3.22,8.72C3.21,8.73 3.2,8.74 3.18,8.76C3.17,8.77 3.17,8.78 3.16,8.79C3.15,8.81 3.13,8.82 3.12,8.84C3.12,8.85 3.11,8.86 3.1,8.88C3.09,8.89 3.08,8.91 3.08,8.93C3.07,8.94 3.06,8.95 3.06,8.96C3.05,9 3.05,9 3.04,9C3.03,9.03 3.03,9.05 3.03,9.06C3,9.08 3,9.1 3,9.12C3,9.13 3,9.15 3,9.16C3,9.19 3,9.22 3,9.26V14.74C3,14.78 3,14.81 3,14.84C3,14.85 3,14.87 3,14.88C3,14.9 3,14.92 3.03,14.94C3.03,14.95 3.03,14.97 3.04,15C3.05,15 3.05,15 3.06,15.04C3.06,15.05 3.07,15.06 3.08,15.07C3.08,15.09 3.09,15.11 3.1,15.12C3.11,15.14 3.12,15.15 3.12,15.16C3.13,15.18 3.15,15.19 3.16,15.21C3.17,15.22 3.17,15.23 3.18,15.24C3.2,15.25 3.21,15.27 3.22,15.28C3.23,15.29 3.24,15.3 3.25,15.31C3.27,15.33 3.28,15.34 3.3,15.35C3.31,15.36 3.32,15.37 3.33,15.38C3.34,15.38 3.34,15.38 3.34,15.39L11.57,20.87C11.7,20.96 11.85,21 12,21C12.15,21 12.3,20.96 12.43,20.87L20.66,15.39C20.66,15.38 20.66,15.38 20.67,15.38C20.68,15.37 20.69,15.36 20.7,15.35C20.72,15.34 20.73,15.33 20.75,15.31C20.76,15.3 20.77,15.29 20.78,15.28C20.79,15.27 20.8,15.25 20.82,15.24C20.83,15.23 20.83,15.22 20.84,15.21C20.85,15.19 20.87,15.18 20.88,15.16C20.88,15.15 20.89,15.14 20.9,15.12C20.91,15.11 20.92,15.09 20.92,15.07C20.93,15.06 20.94,15.05 20.94,15.04C20.95,15 20.96,15 20.96,15C20.97,14.97 20.97,14.95 20.97,14.94C21,14.92 21,14.9 21,14.88C21,14.87 21,14.85 21,14.84C21,14.81 21,14.78 21,14.74V9.26C21,9.22 21,9.19 21,9.16Z"
                        />
                    </svg>
                </a>
            </li>
        </ul>
         <svg class="icon" id="edit">
             <use xlink:href="images/edit.svg#edit" />
         </svg>

     </section>
<!--    modal-->

        <!--MAIN AREA-->
        <div class="bg-modal">
	       <div class="modal-contents">
              <div class="col-lg-12" style="min-height: 400px;">
                   <div class="close">+</div>

                <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
                <div class="card"  style=" box-shadow: 0 8px 14px 0 rgb(159 171 255), 0 16px 20px 0 rgb(121 255 255 / 19%) ">
                    <div class="card-header" style="background-color:rgb(180 177 217)">
                        <h4 style="     
  font-family: Montserrat;
  text-align: left;
  color: #FFF;
  display: flex;
  flex-direction: column;
  letter-spacing: 1px;
  background-image: url(https://media.giphy.com/media/26BROrSHlmyzzHf3i/giphy.gif);
  background-size: cover;
  color: transparent;
  -moz-background-clip: text;
  -webkit-background-clip: text;
  text-transform: uppercase;
  font-size: 60px;
  line-height: .75;
">Edit Profile</h4>
                    </div>
                    <div class="card-body" style="background-image:linear-gradient(270deg,#310265,#1B80B2);">
                        <div class="form-group">
                            <input class="form-control" type="text" name="Name" id="title"  value=" ">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" id="title" placeholder="Headline" name="Headline" value="">
                            <small style="color:white"> Add a professional headline like, 'Engineer' at XYZ or 'Architect' </small>
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
                            <div class="col-lg-12 mb-2">
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
       </div>
</div>
<script >
document.getElementById('edit').addEventListener("click", function() {
	document.querySelector('.bg-modal').style.display = "flex";
});

document.querySelector('.close').addEventListener("click", function() {
	document.querySelector('.bg-modal').style.display = "none";
});
</script>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br>
    <!--FOOTER STARTS-->
<?php require_once ("Backendfooter.php");?>