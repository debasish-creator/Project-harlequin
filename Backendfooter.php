<?php Confirm_Login(); ?>
<head>
    <title>Backend footer</title>
    <link rel="stylesheet" href="css/footer.css">
</head>
<!--FOOTER STARTS-->
<div style="height: 5px; background: cornflowerblue"></div>
<footer class="footer-distributed" id="contact">
    <div class="footer-left">
        <h3>MindSaga <span id="year"></span></h3>
        <p class="footer-links">
            <a href="#" class="nav-link">About Us</a>
            ·
            <a href="index.php" class="nav-link">Blog</a>
            ·
            <a href="#" class="nav-link">Contact Us</a>
            ·
            <a href="#" class="nav-link">Features</a>
            .
        </p>
        <p class="footer-company-name">Made with 💕 by Webwiz</p>
    </div>

    <div class="footer-center">

        <div>
            <i class="fa fa-map-marker"></i>
            <p><span>Loremlaudantium assumenda</span> Odisha, India</p>
        </div>

        <div>
            <i class="fa fa-phone"></i>
            <p>random789</p>
        </div>

        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="">webwiz.nitrkl@gmail.com</a></p>
        </div>

    </div>

    <div class="footer-right">

        <p class="footer-company-about">
            <span>About MindSaga</span>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni expedita assumenda temporibus sapiente veritatis veniam
        </p>
        <ul class="social">
            <li>
                <a href="#" class="tw" title="Tweet this page!">
                    <i class="icon-twitter"></i>
                </a>
            </li>
            <li>
                <a href="#" class="fb" title="Share this page!">
                    <i class="icon-facebook"></i>
                </a>
            </li>
            <li>
                <a href="#" class="gp" title="Share this page!">
                    <i class="icon-google-plus"></i>
                </a>
            </li>
            <li>
                <a href="#" class="gh" title="Tweet this page!">
                    <i class="icon-github"></i>
                </a>
            </li>
            <li>
                <a href="#" class="insta" title="Tweet this page!">
                    <i class="icon-instagram"></i>
                </a>
            </li>
            <li>
                <a href="#" class="in" title="Tweet this page!">
                    <i class="icon-linkedin"></i>
                </a>
            </li>
        </ul>
    </div>
</footer>
<div style="height: 5px; background: cornflowerblue"></div>
<!----FOOTER ENDS---->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
    $('#year').text(new Date().getFullYear());
</script>
</body>
</html>
