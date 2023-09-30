<?php include 'header.php'?>
<div class="login" align="center">
    <form method="post" action="" name="login">
        <label>Username Or Email</label><br><br>
        <input type="text" name="namail" value=""><br><br>
        <label>Password</label><br><br>
        <input type="password" name="password" value=""><br><br>
        <input type="checkbox" name="rememberme"> Remember Me<br><br>
        <button type="submit">Login</button>

    </form>
    <?php
    $login=htmlspecialchars($_POST['namail']);
    $password=htmlspecialchars($_POST['password']);

    $userClass=new Users();
    $userClass->Login($login,$password);
    ?>
</div>



<?php include 'footer.php'?>
