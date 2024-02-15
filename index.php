<?php include "header.php"?>

<form method="get" header="index.php?query=<?=isset($_GET['query'])?>">
    <input type="text" name="query">
    <button type="submit">Search</button>
</form>
<?php
$content=new Contents();
$content->showContents();
?>
<?php if(!empty($content->showContents())):?>
<?php foreach ($content->showContents() as $result):?>
<?=$result["header"]?>
<a class="read" href="read.php?id=<?=$result["id"]?>">[READ]</a>
<?php if(isset($result["publisher"])==isset($_SESSION["publisher"]) || isset($_SESSION["role"])==5):?>
    <a class="edit" href="update.php?id=<?=$result["id"]?>">[EDIT]</a>
    <a class="delete" href="delete.php?id=<?=$result["id"]?>">[DELETE]</a><br><br>
<?php endif;?>

        <?php if(isset($result["publisher"])!==isset($_SESSION["publisher"]) || isset($_SESSION["role"])!==5):?>
            <br><br>
        <?php endif;?>
<?php endforeach;?>
<?php endif;?>
<script>
    $(function() {
        $('.delete').click(function() {
            return window.confirm("Are you sure about that?");
        });
    });
</script>
<?php include "footer.php"?>

