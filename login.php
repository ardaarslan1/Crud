<?php include 'header.php'?>
<div class="login" align="center">
    <form method="<?=$method?>" action="" name="login">
        <label>Username Or Email</label><br><br>
        <input type="text" name="namail" value=""><br><br>
        <label>Password</label><br><br>
        <input type="password" name="password" value=""><br><br>
        <input type="checkbox" name="rememberme"> Remember Me<br><br>
        <button type="submit" name="submit">Login</button>

    </form>
    <?php

    $login=isset($_POST['namail']) ? $_POST['namail']:NULL;
    $password=isset($_POST['password']) ? $_POST['password']:NULL;
    $cookie=isset($_POST['rememberme']);


    $userClass=new Users();
    if(isset($_POST['submit'])){
        $userClass->Login($login,$password,$cookie);
    }
    ?>
</div>
<?php include 'footer.php'?>
