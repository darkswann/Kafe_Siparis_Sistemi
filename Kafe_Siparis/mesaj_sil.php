<?php
session_start();
require "db.php";


if(empty($_SESSION['user'])){
    header("Location: login.php");
    exit;
}


$id = $_GET['id'] ?? null;

if($id){

    $sil = $db->prepare("DELETE FROM iletisim WHERE id = ?");
    $sil->execute([$id]);
}


header("Location: admin.php?sayfa=mesajlar");
exit;
?>