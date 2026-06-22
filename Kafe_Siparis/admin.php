<?php
session_start();
require "db.php";
if(empty($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$sayfa = $_GET['sayfa'] ?? 'dashboard';


$siparisler = $db->query("SELECT * FROM siparisler ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$urunler = $db->query("SELECT * FROM urunler")->fetchAll(PDO::FETCH_ASSOC);

$urunSayisi = $db->query("SELECT COUNT(*) FROM urunler")->fetchColumn();
$siparisSayisi = $db->query("SELECT COUNT(*) FROM siparisler")->fetchColumn();
$kullaniciSayisi = $db->query("SELECT COUNT(*) FROM kullanicilar")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>

<style>
body{margin:0;font-family:Poppins,Arial;background:#f4f6f9;}
.header{
    background:#2c3e50;
    color:white;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.logout{
    background:#e74c3c;
    color:white;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
}
.container{display:flex;padding:20px;gap:20px;}
.sidebar{
    width:200px;
    background:#2c3e50;
    height:100vh;
    padding:15px;
    display:flex;
    flex-direction:column;
    gap:10px;
    border-radius:10px;
}
.sidebar a{
    color:white;
    text-decoration:none;
    padding:10px;
    border-radius:6px;
    background:#34495e;
}
.sidebar a:hover{background:#1abc9c;}
.content{flex:1;background:white;padding:20px;border-radius:10px;}
.cards{display:grid;grid-template-columns:repeat(3,1fr);gap:15px;margin-bottom:20px;}
.card{
    background:linear-gradient(135deg,#3498db,#2980b9);
    color:white;
    padding:20px;
    border-radius:10px;
    text-align:center;
}
.btn-edit{
    background:#f39c12;
    color:white;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
}
.delete-btn{
    background:#e74c3c;
    color:white;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
table th, table td{
    padding:10px;
    border-bottom:1px solid #eee;
}
.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
    gap:15px;
    margin-top:15px;
}
.product-card{
    background:white;
    padding:15px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.2s;
}
.product-card:hover{transform:translateY(-3px);}
.price{
    color:#27ae60;
    font-weight:bold;
    margin-top:5px;
}
.mesaj-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:15px;
    margin-top:15px;
}
.mesaj-card{
    background:white;
    border-radius:12px;
    padding:15px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    border-left:5px solid #3498db;
    transition:0.2s;
}
.mesaj-card:hover{
    transform:translateY(-3px);
}
.mesaj-header{
    font-weight:bold;
    margin-bottom:8px;
    color:#2c3e50;
}
.mesaj-email{
    font-size:12px;
    color:#7f8c8d;
    margin-bottom:10px;
}
.mesaj-text{
    font-size:14px;
    color:#34495e;
    line-height:1.4;
    background:#f8f9fa;
    padding:10px;
    border-radius:8px;
}
.delete-btn{
    margin-top:10px;
    display:inline-block;
    background:#e74c3c;
    color:white;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
}
.delete-btn:hover{
    opacity:0.85;
}
.form-box{
    max-width:400px;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
}
input{
    width:100%;
    padding:10px;
    margin:8px 0 15px 0;
    border:1px solid #ddd;
    border-radius:8px;
}
button{
    width:100%;
    padding:12px;
    background:linear-gradient(135deg,#27ae60,#2ecc71);
    border:none;
    color:white;
    border-radius:8px;
    cursor:pointer;
}
.btn-home {
    background: linear-gradient(135deg,#1abc9c,#16a085);
    color: white;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    margin-right: 10px;
    transition: 0.2s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.btn-home:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}
.bottom-btn {
    position: fixed;
    left: 20px;
    bottom: 20px;

    background: linear-gradient(135deg,#2c3e50,#34495e);
    color: #fff;

    padding: 12px 16px;
    border-radius: 12px;

    text-decoration: none;
    font-weight: 600;
    font-size: 13px;

    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);

    z-index: 9999;

    transition: 0.25s ease;
}
.bottom-btn:hover {
    transform: translateY(-3px);
    background: linear-gradient(135deg,#34495e,#2c3e50);
}
.bottom-btn {
    position: fixed;
    left: 20px;
    bottom: 20px;

    background: #ffffff;
    color: #2c3e50;

    padding: 10px 14px;
    border-radius: 10px;

    text-decoration: none;
    font-weight: 500;
    font-size: 13px;

    border: 1px solid #ddd;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);

    z-index: 9999;

    transition: 0.2s ease;
}

.bottom-btn:hover {
    background: #f5f6fa;
    transform: translateY(-2px);
}

</style>
</head>

<body>

<div class="header">
    <h2>Dark Cafe Yönetici Paneli</h2>
    <div style="display:flex;align-items:center;gap:10px;">
        <a href="index.php" class="btn-home">🏠 Sipariş Sayfası</a>
        <a href="logout.php" class="logout">Çıkış</a>
    </div>
</div>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <a href="?sayfa=dashboard">📊 Kontrol Paneli</a>
    <a href="?sayfa=urunler">📦 Ürünler</a>
    <a href="?sayfa=ekle">➕ Ürün Ekle</a>
    <a href="?sayfa=kullanicilar">👤 Kullanıcılar</a>
    <a href="?sayfa=mesajlar">📩 Mesajlar</a>
</div>

<!-- CONTENT -->
<div class="content">
<?php if($sayfa == "mesajlar"): ?>

<h2>📩 İletişim Mesajları</h2>

<?php
$mesajlar = $db->query("SELECT * FROM iletisim ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if(empty($mesajlar)): ?>

<p>Henüz mesaj yok</p>

<?php else: ?>

<div class="mesaj-grid">

<?php foreach($mesajlar as $m): ?>

<div class="mesaj-card">

    <div class="mesaj-header">
        #<?php echo $m['id'] ?> <?php echo $m['isim'] ?>
    </div>

    <div class="mesaj-email">
        📧 <?php echo $m['email'] ?>
    </div>

    <div class="mesaj-text">
        <?php echo $m['mesaj'] ?>
    </div>

    <a class="delete-btn"
       href="mesaj_sil.php?id=<?php echo $m['id'] ?>"
       onclick="return confirm('Silinsin mi?')">
       🗑 Sil
    </a>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

<?php endif; ?>
<?php if($sayfa == "dashboard"): ?>

<div class="cards">
    <div class="card"><h3><?php echo $urunSayisi ?></h3><p>Ürün</p></div>
    <div class="card"><h3><?php echo $siparisSayisi ?></h3><p>Sipariş</p></div>
    <div class="card"><h3><?php echo $kullaniciSayisi ?></h3><p>Kullanıcı</p></div>
</div>

<h3>Son Siparişler</h3>

<table>
<tr>
    <th>ID</th>
    <th>Kullanıcı</th>
    <th>Tutar</th>
    <th>Durum</th>
    <th>Tarih</th>
    <th>İşlem</th>
</tr>

<?php foreach($siparisler as $s): ?>
<tr>
    <td><?php echo $s['id'] ?></td>
    <td><?php echo $s['kullaniciadi'] ?></td>
    <td><?php echo $s['toplam_fiyat'] ?> TL</td>
    <td><?php echo $s['durum'] ?></td>
    <td>
        <?php echo !empty($s['olusturma_tarihi']) ? date("d.m.Y H:i", strtotime($s['olusturma_tarihi'])) : '' ?>
    </td>
    <td>
        <a href="siparis_duzenle.php?id=<?php echo $s['id'] ?>" class="btn-edit">Güncelle</a>
        <a href="siparis_sil.php?id=<?php echo $s['id'] ?>" class="delete-btn" onclick="return confirm('Silinsin mi?')">Sil</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php endif; ?>


<?php if($sayfa == "urunler"): ?>

<h2>📦 Ürünler</h2>

<div class="product-grid">

<?php foreach($urunler as $u): ?>

<div class="product-card">

    <div><b><?php echo $u['ad'] ?></b></div>

    <div class="price"><?php echo $u['fiyat'] ?> TL</div>

    
    <div style="display:flex;flex-direction:column;gap:6px;margin-top:10px;">

       
        <a href="urun_duzenle.php?id=<?php echo $u['id'] ?>" 
           style="
                background:#f39c12;
                color:white;
                text-align:center;
                padding:6px;
                border-radius:8px;
                text-decoration:none;
                font-size:13px;
           ">
            ✏ Güncelle
        </a>

        
        <a href="urun_sil.php?id=<?php echo $u['id'] ?>" 
           onclick="return confirm('Ürün silinsin mi?')"
           style="
                background:#e74c3c;
                color:white;
                text-align:center;
                padding:6px;
                border-radius:8px;
                text-decoration:none;
                font-size:13px;
           ">
            🗑 Sil
        </a>

    </div>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>


<?php if($sayfa == "ekle"): ?>

<h2>➕ Ürün Ekle</h2>

<div class="form-box">
<form method="POST" action="urun_ekle.php">

    <label>Ürün Adı</label>
    <input type="text" name="ad" required>

    <label>Fiyat</label>
    <input type="number" name="fiyat" required>

    <button type="submit">Kaydet</button>

</form>
</div>

<?php endif; ?>


<?php if($sayfa == "kullanicilar"): ?>

<h2>👤 Kullanıcılar</h2>

<?php
$kullanicilar = $db->query("SELECT * FROM kullanicilar ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
<tr>
    <th>ID</th>
    <th>Kullanıcı Adı</th>
    <th>Rol</th>
    <th>İşlem</th>
</tr>

<?php foreach($kullanicilar as $k): ?>
<tr>
    <td><?php echo $k['id'] ?></td>
    <td><?php echo $k['kullaniciadi'] ?></td>
    <td><?php echo $k['rol'] ?></td>
    <td>

        <a href="kullanici_duzenle.php?id=<?php echo $k['id'] ?>" class="btn-edit">Güncelle</a>

        <a href="kullanici_sil.php?id=<?php echo $k['id'] ?>"
           class="delete-btn"
           onclick="return confirm('Kullanıcı silinsin mi?')">
            🗑 Sil
        </a>

    </td>
</tr>
<?php endforeach; ?>

</table>

<?php endif; ?>
</div>
</div>
</body>
</html>