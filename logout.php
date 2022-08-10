<?php
ob_start();
session_start();

include("common/dbcon.php");

session_destroy();

header("location: loginpage.php");

?>