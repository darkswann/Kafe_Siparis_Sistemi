<?php
require "db.php";
$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM kullanicilar WHERE id=?");
$stmt->execute([$id]);
$k = $stmt->fetch(PDO::FETCH_ASSOC);

if($_POST){
    $kadi = $_POST['kullaniciadi'];
    $rol  = $_POST['rol'];
    if(!empty($_POST['sifre'])){
        $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);

        $update = $db->prepare("
            UPDATE kullanicilar 
            SET kullaniciadi=?, rol=?, sifre=? 
            WHERE id=?
        ");
        $update->execute([$kadi, $rol, $sifre, $id]);
    } else {
        $update = $db->prepare("
            UPDATE kullanicilar 
            SET kullaniciadi=?, rol=? 
            WHERE id=?
        ");
        $update->execute([$kadi, $rol, $id]);
    }
    header("Location: admin.php?sayfa=kullanicilar");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Kullanıcı Güncelle</title>
<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Poppins,Arial;
    background:linear-gradient(135deg,#2c3e50,#3498db);
}
.form-box{
    width:350px;
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
    text-align:center;
}
input, select{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:8px;
}
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:linear-gradient(135deg,#27ae60,#2ecc71);
    color:white;
    cursor:pointer;
    font-weight:bold;
    transition:0.2s;
}
button:hover{
    opacity:0.9;
}
h2{
    margin-bottom:15px;
}
</style>
</head>
<body>
<div class="form-box">
    <h2>👤 Kullanıcı Güncelle</h2>
    <form method="POST">
        <input type="text" name="kullaniciadi" 
               value="<?php echo $k['kullaniciadi'] ?>" required>
        <select name="rol">
            <option value="admin" <?php echo $k['rol']=="admin"?"selected":"" ?>>Admin</option>
            <option value="user" <?php echo $k['rol']=="user"?"selected":"" ?>>User</option>
        </select>
        <input type="password" name="sifre" placeholder="Yeni şifre (boş bırakırsan değişmez)">
        <button type="submit">Güncelle</button>
    </form>
</div>
</body>
</html>