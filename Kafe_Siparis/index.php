<?php
session_start();
require "db.php";

if(empty($_SESSION['user']['id'])){
    header("Location: login.php");
    exit;
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

$urunler = $db->query("SELECT * FROM urunler")->fetchAll(PDO::FETCH_ASSOC);

$kullaniciadi = $_SESSION['user']['kullaniciadi'];

$siparisler = $db->prepare("
    SELECT * FROM siparisler 
    WHERE kullaniciadi = ? 
    ORDER BY id DESC
");
$siparisler->execute([$kullaniciadi]);
$siparisler = $siparisler->fetchAll(PDO::FETCH_ASSOC);

$cart = $_SESSION['cart'];
$toplam = 0;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Kafe Sistemi</title>

<style>
*{box-sizing:border-box;}

body{
    margin:0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #eef2f7;
    color:#2c3e50;
}

/* HEADER */
.header{
    background: linear-gradient(135deg,#1f2c3a,#2c3e50);
    color:white;
    padding:18px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
}

.header-title{
    font-size:20px;
    font-weight:700;
    letter-spacing:0.5px;
}

/* BUTTON GROUP */
.top-actions{
    display:flex;
    gap:12px;
    align-items:center;
}

.top-actions a{
    text-decoration:none;
    color:white;
    padding:11px 18px;
    border-radius:12px;
    font-size:14px;
    font-weight:600;
    transition:0.25s;
    display:inline-block;
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
}

.top-actions a:hover{
    transform:translateY(-3px);
    opacity:0.95;
}

.btn-contact{background:linear-gradient(135deg,#3498db,#2980b9);}
.btn-admin{background:linear-gradient(135deg,#f39c12,#e67e22);}
.btn-logout{background:linear-gradient(135deg,#e74c3c,#c0392b);}


.wrapper{
    display:flex;
    gap:18px;
    padding:18px;
}


.products{
    flex:3;
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(190px, 1fr));
    gap:18px;
}


.card{
    background:white;
    padding:15px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.25s;
}

.card:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 35px rgba(0,0,0,0.12);
}

.card h4{
    margin:0;
    font-size:16px;
}

.price{
    color:#27ae60;
    font-weight:700;
    margin-top:6px;
    font-size:15px;
}

.btn{
    width:100%;
    margin-top:12px;
    padding:10px;
    border:none;
    background:linear-gradient(135deg,#27ae60,#2ecc71);
    color:white;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
    transition:0.2s;
}

.btn:hover{
    filter:brightness(1.05);
}


.side{
    flex:1;
    display:flex;
    flex-direction:column;
    gap:18px;
}


.box{
    background:white;
    padding:15px;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.06);
    max-height:340px;
    overflow-y:auto;
}


.item{
    display:flex;
    justify-content:space-between;
    margin:8px 0;
    font-size:14px;
    padding:6px 0;
    border-bottom:1px dashed #eee;
}

.total{
    font-weight:700;
    margin-top:12px;
    color:#2c3e50;
}

.confirm, .clear{
    width:100%;
    margin-top:10px;
    padding:11px;
    border:none;
    border-radius:10px;
    color:white;
    font-weight:600;
    cursor:pointer;
}

.confirm{
    background:linear-gradient(135deg,#2980b9,#3498db);
}

.clear{
    background:linear-gradient(135deg,#e74c3c,#c0392b);
}


.box::-webkit-scrollbar{
    width:6px;
}

.box::-webkit-scrollbar-thumb{
    background:#bbb;
    border-radius:10px;
}


@media (max-width:900px){
    .wrapper{
        flex-direction:column;
    }

    .top-actions a{
        padding:9px 14px;
        font-size:13px;
    }
}
</style>
</head>

<body>

<div class="header">

    <div class="header-title">Dark Cafe Sipariş Takip</div>

    <div class="top-actions">

        <a href="iletisim.php" class="btn-contact">İletişim</a>

        <?php if($_SESSION['user']['rol'] == "admin"): ?>
            <a href="admin.php" class="btn-admin">Admin</a>
        <?php endif; ?>

        <a href="logout.php" class="btn-logout">Çıkış</a>

    </div>

</div>

<div class="wrapper">


<div class="products">

<?php foreach($urunler as $u): ?>
<div class="card">
    <h4><?php echo $u['ad'] ?></h4>
    <div class="price"><?php echo $u['fiyat'] ?> TL</div>

    <a href="urun_ekle.php?id=<?php echo $u['id'] ?>">
        <button class="btn">Sepete Ekle</button>
    </a>
</div>
<?php endforeach; ?>

</div>


<div class="side">

<div class="box">

<h3>🛒 Sepet</h3>

<?php if(!empty($cart)): ?>

    <?php foreach($cart as $item): ?>
        <?php $toplam += $item['fiyat']; ?>

        <div class="item">
            <span><?php echo $item['ad'] ?></span>
            <span><?php echo $item['fiyat'] ?> TL</span>
        </div>
    <?php endforeach; ?>

    <div class="total">Toplam: <?php echo $toplam ?> TL</div>

    <form method="POST" action="siparis_kaydet.php">
        <button class="confirm">✔ Siparişi Onayla</button>
    </form>

    <a href="sepet_temizle.php">
        <button class="clear">🗑 Sepeti Temizle</button>
    </a>

<?php else: ?>
    <p>Sepet boş</p>
<?php endif; ?>

</div>

<div class="box">

<h3>📦 Geçmiş Siparişler</h3>

<?php if(empty($siparisler)): ?>
    <p>Henüz sipariş yok</p>
<?php endif; ?>

<?php foreach($siparisler as $s): ?>

<div style="border-bottom:1px solid #ddd;padding:10px 0;">
    <div style="display:flex;justify-content:space-between;">
        <b>#<?php echo $s['id'] ?></b>
        <span><?php echo $s['toplam_fiyat'] ?> TL</span>
    </div>

    <div style="font-size:12px;color:#666;">
        <?php echo $s['olusturma_tarihi'] ?>
    </div>

    <div>
        <b>Durum:</b> <?php echo $s['durum'] ?>
    </div>
</div>

<?php endforeach; ?>

</div>

</div>

</div>

</body>
</html>