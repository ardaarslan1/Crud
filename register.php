<!doctype html>
<?php include_once 'header.php';?>

<form style="text-align:center;" action="" method="<?=$method?>">
    <label>Kullanıcı Adınız</label><br><br>
    <input type="text" name="username"><br><br>
    <label>Adınız</label><br><br>
    <input type="text" name="loginname"><br><br>
    <label>Soyadınız</label><br><br>
    <input type="text" name="loginlastname"><br><br>
    <label>Şifre</label><br><br>
    <input type="password" name="password"><br><br>
    <label>E-Posta</label><br><br>
    <input type="email" name="email"><br><br>
    <button name="submit" type="submit" class="login">Kayıt Ol</button><br><br>
</form>

<?php
    $username=isset($_POST['username']) ? $_POST['username']:null;
    $name=isset($_POST['loginname']) ? $_POST['loginname']:null;
    $surname=isset($_POST['loginlastname']) ? $_POST['loginlastname']:null;
    $password=isset($_POST['password']) ? $_POST['password']:null;
    $email=isset($_POST['email']) ? $_POST['email']:null;
    $userClass=new Users();
    if(isset($_POST['submit'])){
        $userClass->Register($username,$name,$surname,$email,$password);
        die();
    }


?>
<?php include_once 'footer.php'?>