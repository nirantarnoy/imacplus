<?php
include("header.php");
include("models/PointCalculator.php");

$x = calmpoint($connect,20);
echo $x;

include("footer.php");
?>