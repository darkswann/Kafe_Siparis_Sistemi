<?php
require "db.php";


$id = $_GET['id'] ?? null;

if(!$id){
    die("ID bulunamadı");
}


$stmt = $db->prepare("SELECT * FROM urunler WHERE id=?");
$stmt->execute([$id]);
$urun = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$urun){
    die("Ürün bulunamadı");
}


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $ad = $_POST['ad'];
    $fiyat = $_POST['fiyat'];

    $guncelle = $db->prepare("UPDATE urunler SET ad=?, fiyat=? WHERE id=?");
    $guncelle->execute([$ad, $fiyat, $id]);

    header("Location: admin.php?sayfa=urunler");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Ürün Güncelle</title>

<style>
body{
    font-family:Poppins,Arial;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    padding:25px;
    border-radius:12px;
    width:320px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
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
    background:#f39c12;
    color:white;
    cursor:pointer;
    font-weight:600;
}

button:hover{
    opacity:0.9;
}
</style>
</head>

<body>

<div class="box">

<h3>Ürün Güncelle</h3>

<form method="POST">

    <input type="text" name="ad" value="<?php echo $urun['ad'] ?>" required>

    <input type="number" name="fiyat" value="<?php echo $urun['fiyat'] ?>" required>

    <button type="submit">Güncelle</button>

</form>

</div>

</body>
</html>