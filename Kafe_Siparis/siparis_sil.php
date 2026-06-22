<?php
require "db.php";

$id = $_GET['id'];

$stmt = $db->prepare("DELETE FROM siparisler WHERE id=?");
$stmt->execute([$id]);

header("Location: admin.php");
exit;
?>