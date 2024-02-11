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
<a href="read.php?id=<?=$result["id"]?>">[READ]</a>
<a href="edit.php?id=<?=$result["id"]?>">[EDIT]</a>
<a href="delete.php?id=<?=$result["id"]?>">[DELETE]</a><br><br>

<?php endforeach;?>
<?php endif;?>
<?php include "footer.php"?>
