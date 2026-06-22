<?php
session_start();
require "db.php";

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

        
        $kontrol = $db->prepare("SELECT id FROM kullanicilar WHERE kullaniciadi = ?");
        $kontrol->execute([$kullanici]);

        if($kontrol->rowCount() > 0){
            $hata = "Bu kullanıcı adı zaten var!";
        } else {

            $hash = password_hash($sifre, PASSWORD_DEFAULT);

            $ekle = $db->prepare("
                INSERT INTO kullanicilar (kullaniciadi, sifre, rol)
                VALUES (?, ?, 'user')
            ");

            $ekle->execute([$kullanici, $hash]);

            
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Kayıt Ol</title>

<style>
body{
    margin:0;
    font-family:Poppins, Arial;
    background:linear-gradient(135deg,#8e44ad,#3498db);
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
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    text-align:center;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:8px;
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
a{
    display:inline-block;
    margin-top:12px;
    text-decoration:none;
    padding:10px;
    width:100%;
    border-radius:8px;
    background:#34495e;
    color:white;
    font-weight:bold;
    text-align:center;
    transition:0.3s;
}
.btn{
    display:block;
    width:100%;
    padding:10px;
    margin-top:10px;
    border-radius:8px;
    text-align:center;
    font-weight:bold;
    font-family:Poppins, Arial;
    font-size:14px;
    cursor:pointer;
    text-decoration:none;
    transition:0.3s;
    box-sizing:border-box;
}


button.btn{
    border:none;
    background:linear-gradient(135deg,#27ae60,#2ecc71);
    color:white;
}


a.btn{
    background:#34495e;
    color:white;
}


button.btn:hover{
    opacity:0.9;
}

a.btn:hover{
    background:#2c3e50;
}
a:hover{
    background:#2c3e50;
}


.error{
    color:red;
    margin-top:10px;
}
</style>
</head>

<body>

<div class="box">

    <h2>📝 Kayıt Ol</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Kullanıcı Adı">
        <input type="password" name="password" placeholder="Şifre">
        <button type="submit" class="btn">Kayıt Ol</button>
        <a href="login.php" class="btn">← Giriş Yap</a>
    </form>

    <?php if(!empty($hata)): ?>
        <div class="error"><?php echo $hata; ?></div>
    <?php endif; ?>


</div>

</body>
</html>