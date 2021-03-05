<?php Confirm_Login(); ?>
<?php
date_default_timezone_set("Asia/Kolkata");
$CurrentTime=time();
$DateTime=strftime(" %a,%d %h %Y , %H:%M %p",$CurrentTime);
echo $DateTime;
?>