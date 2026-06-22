<?php
session_start();
require "db.php";

$hata = "";


if(isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $kullanici = trim($_POST['username']);
    $sifre = $_POST['password'];

    if(empty($kullanici) || empty($sifre)){
    echo "<script>alert('Boş alan bırakmayınız!');</script>";
    } else {

        $stmt = $db->prepare("SELECT * FROM kullanicilar WHERE kullaniciadi = ?");
        $stmt->execute([$kullanici]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($sifre, $user['sifre'])){

    $_SESSION['user'] = [
        'id' => $user['id'],
        'kullaniciadi' => $user['kullaniciadi'],
        'rol' => $user['rol']
    ];

    header("Location: index.php");
    exit;

} else {
    $hata = "Hatalı kullanıcı adı veya şifre!";
}
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Giriş Yap</title>

<style>
body{
    margin:0;
    font-family:Poppins, Arial;
    background:linear-gradient(135deg,#2c3e50,#3498db);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.box{
    background:white;
    padding:30px;
    border-radius:15px;
    width:320px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:8px;
}

button, .btn{
    width:100%;
    padding:10px;
    margin-top:10px;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
    text-decoration:none;
    display:block;
    text-align:center;
    font-size:14px;
}

/* Giriş butonu */
button{
    background:linear-gradient(135deg,#27ae60,#2ecc71);
    color:white;
}

/* Kayıt butonu */
.btn{
    background:linear-gradient(135deg,#e67e22,#f39c12);
    color:white;
}

button{
    width:100%;
    padding:10px;
    border:none;
    border-radius:8px;
    background:linear-gradient(135deg,#27ae60,#2ecc71);
    color:white;
    font-weight:bold;
    cursor:pointer;
}

.btn-group{
    display:flex;
    gap:10px;
    margin-top:10px;
}

.btn-group .btn{
    flex:1;
    margin-top:0;
}

.btn-register{
    display:block;
    margin-top:10px;
    padding:10px;
    border-radius:8px;
    background:linear-gradient(135deg,#e67e22,#f39c12);
    color:white;
    text-decoration:none;
    font-weight:bold;
}

.home-link{
    display:block;
    margin-top:10px;
    font-size:13px;
    color:#2c3e50;
    text-decoration:none;
}

.error{
    color:red;
    margin-top:10px;
}
</style>
</head>

<body>

<div class="box">

    <h2>🔐 Giriş Yap</h2>

    <form method="POST">
    <input type="text" name="username" placeholder="Kullanıcı Adı">
    <input type="password" name="password" placeholder="Şifre">
<div class="btn-group">
    <button type="submit" class="btn btn-login">Giriş Yap</button>
    <a href="register.php" class="btn btn-register">Kayıt Ol</a>
</div>
</form>




    <?php if($hata != ""): ?>
        <script>
            alert("<?php echo $hata; ?>");
        </script>

        <div class="error">
            <?php echo $hata; ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>