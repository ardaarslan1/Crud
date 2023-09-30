<?php
class Db{
    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost", "root", "root");
        } catch (PDOException $e) {
            die("DB ERROR1: " . $e->getMessage());
        }
        try {
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS `basic_crud`;
                         CREATE USER IF NOT EXISTS 'root'@'localhost' IDENTIFIED BY 'root';
                         GRANT ALL ON `basic_crud`.* TO 'root'@'localhost';
                         FLUSH PRIVILEGES;");
        } catch (PDOException $e) {
            die("DB ERROR2: " . $e->getMessage());
        }
        try {
            $statements = ["
CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    name VARCHAR(255),
    surname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role INT NOT NULL DEFAULT '1',
    profile_pic VARCHAR(255),
    register_date TIMESTAMP
);","
CREATE TABLE IF NOT EXISTS Contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    header VARCHAR(255),
    content VARCHAR(255),
    publisher VARCHAR(255),
    publish_date TIMESTAMP
);"];
            foreach($statements as $statement){
                $useDb="USE basic_crud;";
                $this->conn->exec($useDb);
                $this->conn>exec($statement);
            }
        }
        catch(PDOException $e){
            die("DB ERROR: ". $e->getMessage());
        }
        try{
            $sql="SELECT * FROM users WHERE id=:id";
            $prepare=$this->conn->prepare($sql);
            $prepare->execute([
                'id' => 1
            ]);
            $rowCount=$prepare->rowCount();

            if($rowCount == 0){
                $password=password_hash('admin',PASSWORD_BCRYPT);
                $sql=$this->conn->prepare("INSERT INTO users(username, name, surname, email, password, role, profile_pic) VALUES(:username, :name, :surname, :email, :password, :role, :profile_pic)");
                $sql->execute([
                    ':username' => 'admin',
                    ':name' => 'admin',
                    ':surname' => 'admin',
                    ':email' => 'admin@gmail.com',
                    ':password' => $password,
                    ':role' => 5,
                    ':profile_pic' => NULL
                ]);
                $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e){
            die("DB ERROR3: " . $e->getMessage());
        }
    }
}

class Contents extends Db {
    public function __construct() {
        parent::__construct();
    }
    public function showContents(){
        $conn = $this->conn;
        if(empty($_GET['query'])){
            $sql=$conn->query("SELECT * FROM Contents ORDER BY id DESC");
            $result=$sql->fetchAll(PDO::FETCH_ASSOC);

            if(empty($result)){
                echo "Unfortunate there is no content."." ". '<a href="create.php"> Would you like to add first content ?</a>';
            }

        }else{
                $query=$_GET['query'];
                $sql=$conn->query("SELECT * FROM Contents WHERE header LIKE '%$query%' OR content LIKE '%$query%' OR publisher LIKE '%$query%' ORDER BY id DESC");
                $result=$sql->fetchAll(PDO::FETCH_ASSOC);

                if(empty($result)){
                    echo "Unfortunate there is no content you searched."." ". '<a href="create.php"> Would you like to add first content ?</a>';
                }
        }

    }
    public function create($header,$content,$publisher) {
        $header=htmlspecialchars($header);
        $content=htmlspecialchars($content);
        $publisher=htmlspecialchars($publisher);

        $conn = $this->conn;
        $sql=$conn->prepare("INSERT INTO Contents(header,content,oublisher) VALUES(?,?,?)");
        $sql->execute([
            $header,
            $content,
            $publisher
        ]);
        $result=$sql->fetchColumn(PDO::FETCH_ASSOC);

        if($result){
            $success = true;
        }else{
            $success = false;
        }
    }
    public function delete(){
        $id=htmlspecialchars($_GET['id']);
        $conn = $this->getConnection();

        $sql=$conn->prepare("SELECT * FROM Contents WHERE id=?");
        $sql->execute([
            $id
        ]);
        $rows=$sql->rowCount();

        if($rows = 0){
            header("Location:index.php");
            exit();
        }

        $sql=$conn->prepare("DELETE FROM Contents WHERE id=?");
        $sql->execute([
            $id
        ]);
        $result=$sql->fetchColumn();

        if($result){
            $success = true;
        }else{
            $success = false;
        }
    }
    public function edit($header,$content,$publisher){
        $id=htmlspecialchars($_GET['id']);

        $conn = $this->getConnection();
        $sql=$conn->prepare("SELECT * FROM Contents WHERE id=?");
        $sql->execute([
            $id
        ]);
        $rows=$sql->rowCount();

        if($rows = 0){
            header("Location:index.php");
            exit();
        }

        $header=htmlspecialchars($header);
        $content=htmlspecialchars($content);
        $publisher=htmlspecialchars($publisher);

        $conn = $this->getConnection();
        $sql=$conn->prepare("UPDATE Contents SET header=:header, contents=:contents, publisher=:publisher");
        $sql->execute([
            "header" => $header,
            "contents" => $content,
           "publisher" => $publisher
        ]);
        $result=$sql->fetchColumn();

        if($result){
            $success = true;
        }else{
            $success = false;
        }
    }
}
class Users extends Db {
    public function __construct() {
        parent::__construct();
    }
    public function Login($login,$password,$cookie){
        $login=htmlspecialchars($login);
        $password=htmlspecialchars($password);

        $conn = $this->conn;
        $sql=$conn->prepare("SELECT * FROM Users WHERE username=:username OR email=:email");
        $sql->execute([
            ":username" => $login,
            ":email"=>$login,
        ]);
        $rows=$sql->rowCount();
        $results=$sql->fetch(PDO::FETCH_ASSOC);



        if($rows > 0){
            $passverfy=password_verify($password,$results['password']);
            if($passverfy){
                session_start();
                $_SESSION['id']=$results['id'];
                if($cookie=1){
                    setcookie($hour = time() + 3600 * 24 * 30);
                    setcookie('username', $login, $hour);
                    setcookie('password', $password, $hour);
                }
                header("Location:index.php");
            }else{
                echo "Password is wrong";
            }
        }else{
            echo "There is no acount like that";
        }
    }
    public function LogOut(){
        $id=htmlspecialchars($_GET['id']);
       if(!empty($id)){
           session_start();
           session_destroy();
       }
        header("Location:index.php");
    }
    public function Register($username,$name,$surname,$email,$password,$profile_pic,$role=1){
        $username=htmlspecialchars($username);
        $name=htmlspecialchars($name);
        $surname=htmlspecialchars($surname);
        $email=htmlspecialchars($email);
        $password=htmlspecialchars($password);
        $role=htmlspecialchars($role);
        $profile_pic=htmlspecialchars($profile_pic);

        $conn = $this->conn;
        $sql=$conn->prepare("SELECT * FROM Users WHERE username=:username OR email=:email");
        $sql->execute([
            ":username"=>$username,
            ":email"=>$email
        ]);
        $rows=$sql->rowCount();


        if($rows > 0){
            echo "Böyle bir kullanıcı zaten var !";
            exit();
        }

        $sql=$conn->prepare("INSERT INTO users(username, name, surname, email, password, role, profile_pic) VALUES(:username, :name, :surname, :email, :password, :role, :profile_pic)");
        $sql->execute([
            ':username' => $username,
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role,
            ':profile_pic' => NULL
        ]);
        $result=$sql->fetchAll(PDO::FETCH_ASSOC);
        $lastuserid=$sql->lastInsertId();

        if($result){
            $success = true;
            session_start();
            $_SESSION['id']=$lastuserid;

            header("Location:index.php");
        }else{
            $success = false;
            echo "Bir hata oluştu";
        }
    }
    public function delete(){
        $id=htmlspecialchars($_GET['id']);
        $conn = $this->conn;

        $sql=$conn->prepare("SELECT * FROM Users WHERE id=:id");
        $sql->execute([
            ":id" => $id
        ]);
        $rows=$sql->rowCount();

        if($rows = 0){
            header("Location:index.php");
            exit();
        }

        $sql=$conn->prepare("DELETE FROM Users WHERE id=?");
        $sql->execute([
            $id
        ]);
        $result=$sql->fetchColumn();

        if($result){
            header("Location:index.php");
        }else{
            $success = false;
        }

    }
    public function edit($username,$name,$surname,$email,$password,$profile_pic,$role=1){
        $id=htmlspecialchars($_GET['id']);

        $conn = $this->conn;
        $sql=$conn->prepare("SELECT * FROM Contents WHERE id=:id");
        $sql->execute([
            ":id" => $id
        ]);
        $rows=$sql->rowCount();

        if($rows = 0){
            header("Location:index.php");
            exit();
        }

        $username=htmlspecialchars($username);
        $name=htmlspecialchars($name);
        $surname=htmlspecialchars($surname);
        $email=htmlspecialchars($email);
        $password=htmlspecialchars($password);
        $role=htmlspecialchars($role);
        $profile_pic=htmlspecialchars($profile_pic);

        $conn = $this->getConnection();
        $sql=$conn->prepare("UPDATE Users SET username=:username, name=:name, surname=:surname, email=:email, password=:password, role=:role, profile_pic=:profile_pic)");
        $sql->execute([
            ':username' => $username,
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role,
            ':profile_pic' => $profile_pic
        ]);
        $result=$sql->fetchAll(PDO::FETCH_ASSOC);

        if($result){
            $success = true;
            header("Location:index.php");
        }else{
            $success = false;
            echo "Bir hata oluştu";
        }
    }
}
?>