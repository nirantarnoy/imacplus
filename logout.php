<?php
ob_start();
session_start();

include("common/dbcon.php");
unset($_SESSION["userid"]);
session_unset();
session_destroy();

header("location: loginpage.php");

?>