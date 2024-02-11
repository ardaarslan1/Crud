<?php
include_once "header.php";
if(!isset($_GET['id'])){
    header("Location:index.php");
}
$content=new Contents();

?>

<a href="index.php"><button class="drpbtn"> Ana sayfaya dön</button></a>

<?php
// Get content based on the provided id
$result = $content->read();

if ($result) {
    ?>
    <h1>Header:<?= $result['header'] ?></h1>
    <p>Content:<?= $result['content'] ?></p>
    <hr>
    <p>Publisher: <?= $result["publisher"] ?></p>
    <p>Date: <?= $result['publish_date'] ?></p>
    <?php
} else {
    echo "Content not found!";
}

include_once "footer.php";
?>
