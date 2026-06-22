<?php
require "db.php";
$id = $_GET['id'] ?? null;

if(!$id){
    header("Location: admin.php");
    exit;
}


$sorgu = $db->prepare("SELECT * FROM siparisler WHERE id=?");
$sorgu->execute([$id]);
$siparis = $sorgu->fetch(PDO::FETCH_ASSOC);


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $durum = $_POST['durum'];

    $update = $db->prepare("UPDATE siparisler SET durum=? WHERE id=?");
    $update->execute([$durum, $id]);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Sipariş Güncelle</title>

<style>
body{
    margin:0;
    font-family:Poppins, Arial;
    background:linear-gradient(135deg,#2c3e50,#3498db);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    width:380px;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    text-align:center;
}

h2{
    margin-bottom:20px;
    color:#2c3e50;
}

.info{
    font-size:13px;
    margin-bottom:15px;
    color:#666;
}

select{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
    margin-bottom:15px;
    font-size:14px;
    outline:none;
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
    transition:0.3s;
}

button:hover{
    opacity:0.9;
}

.back{
    display:block;
    margin-top:10px;
    font-size:12px;
    color:#555;
    text-decoration:none;
}

.badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    background:#f1f3f6;
    margin-bottom:10px;
    font-size:12px;
}
</style>

</head>

<body>

<div class="box">

    <h2>📝 Sipariş Güncelle</h2>

    <div class="badge">
        ID: <?php echo $siparis['id'] ?>
    </div>

    <div class="info">
        <?php
            echo $siparis['kullaniciadi'];
            echo "<br>";
            echo $siparis['toplam_fiyat'] . " TL";
?>
    </div>

    <form method="POST">

    <select name="durum">

        <option value="Hazırlanıyor"
            <?php echo $siparis['durum']=="Hazırlanıyor" ? "selected" : "" ?>>
            Hazırlanıyor
        </option>

        <option value="Hazır"
            <?php echo $siparis['durum']=="Hazır" ? "selected" : "" ?>>
            Hazır
        </option>

        <option value="Teslim Edildi"
            <?php echo $siparis['durum']=="Teslim Edildi" ? "selected" : "" ?>>
            Teslim Edildi
        </option>

    </select>

    <button type="submit">Güncelle</button>

</form>

    <a href="admin.php" class="back">← Geri Dön</a>

</div>

</body>
</html>