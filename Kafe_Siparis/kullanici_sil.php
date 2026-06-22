<?php
session_start();
require "db.php";
if(empty($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
$id = $_GET['id'] ?? null;
if(!$id){
    header("Location: admin.php?sayfa=kullanicilar");
    exit;
}
$sorgu = $db->prepare("DELETE FROM kullanicilar WHERE id = ?");
$sorgu->execute([$id]);
header("Location: admin.php?sayfa=kullanicilar");
exit;
?>