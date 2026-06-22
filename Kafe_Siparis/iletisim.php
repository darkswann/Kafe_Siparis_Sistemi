<?php
session_start();
require "db.php";

$hata = "";
$basari = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $isim  = trim($_POST['isim']);
    $email = trim($_POST['email']);
    $mesaj = trim($_POST['mesaj']);

    if(empty($isim) || empty($email) || empty($mesaj)){
        $hata = "Lütfen tüm alanları doldurun!";
    } else {

        $stmt = $db->prepare("
            INSERT INTO iletisim (isim, email, mesaj)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([$isim, $email, $mesaj]);

        $basari = "Mesajınız gönderildi!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>İletişim</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#2c3e50,#3498db);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.box{
    width:350px;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

h2{
    text-align:center;
    margin-bottom:15px;
}

input, textarea{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:1px solid #ddd;
    border-radius:8px;
}

textarea{
    height:100px;
    resize:none;
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

.error{color:red;text-align:center;margin-top:10px;}
.success{color:green;text-align:center;margin-top:10px;}

a{
    display:block;
    text-align:center;
    margin-top:10px;
    color:#2c3e50;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="box">

    <h2>📩 İletişim</h2>

    <form method="POST">

        <input type="text" name="isim" placeholder="Adınız">

        <input type="email" name="email" placeholder="E-posta">

        <textarea name="mesaj" placeholder="Mesajınız"></textarea>

        <button type="submit">Gönder</button>

    </form>

    <?php if($hata != ""): ?>
    <script>
    alert("<?php echo $hata ?>");
    </script>
    <?php endif; ?>

    <?php if($basari != ""): ?>
        <script>
        alert("<?php echo $basari ?>");
        </script>
    <?php endif; ?>

    <a href="index.php">← Ana Sayfaya Dön</a>

</div>

</body>
</html>