<?php
include_once "header.php";
if(!isset($_SESSION['id'])){
    header('Location:login.php');
    die();
}
$userClass=new Users();
?>


<div class="profile">
    <form method="<?=$method?>" action="">
        <?php foreach ($userClass->showUser() as $result):?>
        Username:<input type="text" name="username" maxlength="40" required value="<?php echo isset($_POST['username']) ? $_POST['username'] :$result['username'] ?>"><br><br>
        Name:<input type="text" name="name" maxlength="40" required value="<?php echo isset($_POST['name']) ? $_POST['name'] :$result['name'] ?>"><br><br>
        Surname:<input type="text" name="surname" maxlength="40" required value="<?php echo isset($_POST['surname']) ? $_POST['surname'] :$result['surname'] ?>"><br><br>
        Email:<input type="email" name="email" maxlength="40" required value="<?php echo isset($_POST['email']) ? $_POST['email'] :$result['email'] ?>"><br><br>
        Password:<input type="password" name="password" maxlength="40" required value="<?php echo isset($_POST['password']) ? password_hash($_POST['password'],PASSWORD_BCRYPT) : $result["password"]?>"><br><br>
        Role:<select name="role" <?php echo ($_SESSION["role"] !== "5") ? 'disabled' : ''; ?>>
                <option value="1" <?php echo isset($_POST['role']) && $_POST['role'] === "1" ? 'selected' : ''; ?>>User</option>
                <option value="5" <?php echo isset($_POST['role']) && $_POST['role'] === "5" ? 'selected' : ''; ?>>Admin</option>
            </select>



        <?php endforeach;?>
        <button name="submit" type="submit">Update</button>
    </form>
    <?php
    if(isset($_POST['submit'])){
        $username=isset($_POST['username']) ? htmlspecialchars($_POST['username']):null;
        $name=isset($_POST['name']) ? htmlspecialchars($_POST['name']):null;
        $surname=isset($_POST['surname']) ? htmlspecialchars($_POST['surname']):null;
        $email=isset($_POST['email']) ? htmlspecialchars($_POST['email']):null;
        $password=isset($_POST['password']) ? htmlspecialchars($_POST['password']):null;
        $role=isset($_POST['role']) ? htmlspecialchars($_POST['role']):null;

        $userClass->edit($username,$name,$surname,$email,$password,NULL,$role);
    }
    ?>
</div>
<script>

</script>