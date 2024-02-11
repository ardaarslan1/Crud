<?php
include_once "header.php";
if (!isset($_GET["id"]) || empty(trim($_GET["id"])) || ){
    header("Location:index.php");
}



?>