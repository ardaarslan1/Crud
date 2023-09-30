<?php include "header.php"?>

<form method="get" header="index.php?query=<?=isset($_GET['query'])?>">
    <input type="text" name="query">
    <button type="submit">Search</button>
</form>
<?php
$content=new Contents();
$content->showContents();
?>
<?php include "footer.php"?>
