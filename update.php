<?php
include_once "header.php";
if (!isset($_GET["id"]) || empty(trim($_GET["id"]))){
    header("Location:index.php");
}
$content=new Contents();
$result=$content->read();
?>



<form method="<?=$method?>" action="">
    Header:<input type="text" name="content_adi" maxlength="40" required value="<?php echo isset($_POST['content_adi']) ? $_POST['content_adi'] :$result['header'] ?>"><br><br>
    Content: <br><br><textarea class="content_icerik" rows="10" cols="60" maxlength="100" name="content_icerik" required><?php echo isset($_POST['content_icerik']) ? htmlspecialchars($_POST['content_icerik']) : $result["content"]; ?></textarea>
    <br><br>
    <button name="submit" type="submit">Update</button>
</form>
    <?php
    if(isset($_POST['submit'])){
        $content_adi=isset($_POST['content_adi']) ? htmlspecialchars($_POST['content_adi']):null;
        $content_icerik=isset($_POST['content_icerik']) ? htmlspecialchars($_POST['content_icerik']):null;
        $content_author=$result['publisher'];
        $content->edit($content_adi,$content_icerik,$content_author);
    }
    ?>
<?php include_once 'footer.php'?>
