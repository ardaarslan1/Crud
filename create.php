<!doctype html>
<?php
include_once "header.php";
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    die();
}
$content=new Contents();

?>


<form method="<?=$method?>" action="">

    İçerik Başlığı:<input type="text" name="content_adi" maxlength="40" required value="<?php echo isset($_GET['content_adi']) ? $_GET['content_adi'] :null ?>"><br><br>
    İçerik: <br><br><textarea type="text" class="content_icerik" rows="10" cols="60" maxlenght="100" name="content_icerik" required value="<?php echo isset($_GET['content_icerik'])? $_GET['content_icerik'] :null ?>" multiple size=></textarea><br><br>
    <!--İçerik Türü:<br><br>   <select name="content_tur[]" id="content_tur" multiple size=5>
        <?php /*foreach($categories as $key=>$context):?>
            <option value="<?php echo $context['id'];?>"><?php echo $context['kategori_adi']?></option>
        <?php endforeach;*/?>
    </select>--><br><br>

    <!-- İçerik Sahibi: <input type="text" name="content_author" value="<?php //echo isset($_GET['content_author']) ? $_GET['content_author'] :null ?>"><br><br> -->
    <button name="submit" type="submit">Ekle</button>
    <?php
    if(isset($_POST['submit'])){
        $content_adi=isset($_POST['content_adi']) ? htmlspecialchars($_POST['content_adi']):null;
        $content_icerik=isset($_POST['content_icerik']) ? htmlspecialchars($_POST['content_icerik']):null;
        //$content_tur=isset($_GET['content_tur']) && is_array($_GET['content_tur']) ? implode(',',$_GET['content_tur']) :"";
        $content_author=$_SESSION['username'];
        $content->create($content_adi,$content_icerik,$content_author);
    }
    ?>
<?php include_once 'footer.php'?>