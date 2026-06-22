<?php
session_start();
require "db.php";


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $ad = $_POST['ad'] ?? '';
    $fiyat = $_POST['fiyat'] ?? '';

    if($ad != "" && $fiyat != ""){

        $stmt = $db->prepare("INSERT INTO urunler (ad, fiyat) VALUES (?, ?)");
        $stmt->execute([$ad, $fiyat]);

    }

    header("Location: admin.php?sayfa=urunler");
    exit;
}


$id = $_GET['id'] ?? null;

if($id){

    $stmt = $db->prepare("SELECT * FROM urunler WHERE id=?");
    $stmt->execute([$id]);
    $urun = $stmt->fetch(PDO::FETCH_ASSOC);

    if($urun){
        $_SESSION['cart'][] = [
            "id" => $urun['id'],
            "ad" => $urun['ad'],
            "fiyat" => $urun['fiyat']
        ];
    }

    header("Location: index.php");
    exit;
}