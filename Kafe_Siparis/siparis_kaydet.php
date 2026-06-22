<?php
session_start();
require "db.php";

if(empty($_SESSION['cart'])) exit;

$toplam = 0;

foreach($_SESSION['cart'] as $item){
    $toplam += $item['fiyat'];
}

$stmt = $db->prepare("
INSERT INTO siparisler (kullaniciadi, toplam_fiyat, durum)
VALUES (?, ?, ?)
");

$stmt->execute([
    $_SESSION['user']['kullaniciadi'],
    $toplam,
    "Hazırlanıyor"
]);

unset($_SESSION['cart']);

header("Location: index.php");
exit;