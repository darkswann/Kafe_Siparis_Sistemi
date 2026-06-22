<?php
require "db.php";


$id = $_GET['id'] ?? null;

if(!$id){
    die("ID yok");
}


$stmt = $db->prepare("DELETE FROM urunler WHERE id=?");
$stmt->execute([$id]);


header("Location: admin.php?sayfa=urunler");
exit;
?>