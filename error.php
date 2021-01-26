<?php
include "inc/session.inc.php";
include 'helpers/HTTPFunctions.php';
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc.php' ?>
<!---->
<?php
include 'components/nav.php';
generateNavBar();
?>
<body>
<img src="images/Error.jpg">
<h1><?php echo $_GET['error']?></h1>
</body>
</html>