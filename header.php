<?php include "classes.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Main Page</title>
</head>
<body>
<a href="index.php">Main Page</a>
<?php if(!isset($_SESSION['id'])):?>
<a href="login.php" style="float: right; margin-left: 10px">Login </a>
<a href="register.php" style="float: right;">Register </a>
<?php endif;?>

<?php if(isset($_SESSION['id'])):?>
    <a href="/Crud/logout.php?id=<?=$_SESSION['id']?>" style="float: right;">Log Out</a>
    <a href="/Crud/create.php" style="float: right;">New Post</a>
    <a href="/Crud/update_user.php?id=<?=$_SESSION['id']?>" style="float: right;">Edit Profile</a>

<?php endif;?>

<hr>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>