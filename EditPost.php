<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php Confirm_Login(); ?>

<?php
$SearchQueryParameter = $_GET["id"];
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
        Redirect_to("Posts.php");
    }elseif (strlen($PostTitle)<5){
        $_SESSION["ErrorMessage"] = "Post title should be greater than 5 character";
        Redirect_to("Posts.php");
    }elseif (strlen($PostText)>7999) {
        $_SESSION["ErrorMessage"] = "Post content should be less than 8000 character";
        Redirect_to("Posts.php");
    }elseif (strlen($PostText2)>2999) {
        $_SESSION["ErrorMessage"] = "Content 2 description should be less than 3000 character";
        Redirect_to("Posts.php");
    }elseif (strlen($PostText3)>2999) {
        $_SESSION["ErrorMessage"] = "Content 3 description should be less than 3000 character";
        Redirect_to("Posts.php");
    }else{
        //Query to update post in database when everything is good
        global $ConnectingDB;
        if(!empty($_FILES["Image"]["name"]) && !empty($_FILES["Image2"]["name"]) && !empty($_FILES["Image3"]["name"])){
            $sql = "UPDATE posts SET title='$PostTitle', category='$Category', image='$Image', post='$PostText', image2='$Image2', post2='$PostText2', image3='$Image3', post3='$PostText3' 
        WHERE id='$SearchQueryParameter'";
        }else{
            $sql = "UPDATE posts SET title='$PostTitle', category='$Category', post='$PostText', post2='$PostText2', post3='$PostText3'
        WHERE id='$SearchQueryParameter'";
        }
        $Execute = $ConnectingDB->query($sql);

        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        move_uploaded_file($_FILES["Image2"]["tmp_name"],$Target2);
        move_uploaded_file($_FILES["Image3"]["tmp_name"],$Target3);

        if($Execute){
            $_SESSION["SuccessMessage"]="post  updated Successfully";
            Redirect_to("Posts.php");
        }else{
            $_SESSION["ErrorMessage"]= "something went wrong. Try Again !";
            Redirect_to("Posts.php");
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
    <title>Edit Post</title>
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
<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-edit"></i> Edit Post</h1>
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
            //            taking existing contents from post
            global $ConnectingDB;
            $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
            $stmt = $ConnectingDB ->query($sql);
            while ($DataRows=$stmt->fetch()){
                $TitleToBeUpdated = $DataRows['title'];
                $CategoryToBeUpdated = $DataRows['category'];
                $ImageToBeUpdated = $DataRows['image'];
                $PostToBeUpdated = $DataRows['post'];
                //
                $ImageToBeUpdated2 = $DataRows['image2'];
                $PostToBeUpdated2 = $DataRows['post2'];
                //
                $ImageToBeUpdated3 = $DataRows['image3'];
                $PostToBeUpdated3 = $DataRows['post3'];
            }
            ?>
            <form class="" action="EditPost.php?id=<?php echo $SearchQueryParameter;?>" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="fieldinfo">Post Title :</span></label>
                            <input class="form-control" type="text" name="PostTitle" placeholder="Type title here" value="<?php echo $TitleToBeUpdated;?>">
                        </div>
                        <div class="form-group">
                            <span class="fieldinfo">Existing Category:</span>
                            <?php echo $CategoryToBeUpdated;?>
                            <br>
                            <label for="CategoryTitle"><span class="fieldinfo">Choose Title :</span></label>
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
                        <!--primary content-->
                        <div class="form-group">
                            <span class="fieldinfo">Existing Image-1: </span>
                            <img class="mb-2" src="uploads/<?php echo $ImageToBeUpdated; ?>" width="170px" alt="image" ; height="70px" ; alt="image">

                            <div class="custom-file">
                                <input class="custom-file-input" type="file" name="Image" id="imageselect" value="">
                                <label for="imageselect" class="custom-file-label">Select Image 1</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post"><span class="fieldinfo">Content 1 :</span></label>
                            <textarea class="form-control" name="PostDescription" cols="80" rows="8" id="Post">
                                <?php echo $PostToBeUpdated; ?>
                            </textarea>
                        </div>
                        <!--secondary content-->
                        <div class="form-group">
                            <span class="fieldinfo">Existing Image-2: </span>
                            <img class="mb-2" src="uploads/<?php echo $ImageToBeUpdated2; ?>" width="170px" ; height="70px" ;alt="image">

                            <div class="custom-file">
                                <input class="custom-file-input" type="file" name="Image2" id="imageselect2" value="">
                                <label for="imageselect2" class="custom-file-label">Select Image 2</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post"><span class="fieldinfo">Content 2:</span></label>
                            <textarea class="form-control" name="PostDescription2" cols="80" rows="8" id="Post2">
                                <?php echo $PostToBeUpdated2; ?>
                            </textarea>
                        </div>
                        <!--tertiary content-->
                        <div class="form-group">
                            <span class="fieldinfo">Existing Image-3: </span>
                            <img class="mb-2" src="uploads/<?php echo $ImageToBeUpdated3; ?>" width="170px" ; height="70px" ; alt="image">

                            <div class="custom-file">
                                <input class="custom-file-input" type="file" name="Image3" id="imageselect3" value="">
                                <label for="imageselect3" class="custom-file-label">Select Image 3</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post"><span class="fieldinfo">Content 3 :</span></label>
                            <textarea class="form-control" name="PostDescription3" cols="80" rows="8" id="Post3">
                                <?php echo $PostToBeUpdated3; ?>
                            </textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Posts.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Posts</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="Submit" name="Submit" class="btn btn-success btn-block">
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
<?php require_once ("Backendfooter.php");?>



