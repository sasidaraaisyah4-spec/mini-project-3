<?php
require '../../config/database.php';
require '../../helpers/auth.php'; 
require '../../helpers/validation.php';
require '../../helpers/escape.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = validateQty($_POST['quantity']);
    $pid = $_POST['product_id'];

    if ($qty) {
        try {
            $pdo->beginTransaction(); 
            
            $stmt = $pdo->prepare("SELECT name, stock FROM products WHERE id = :id FOR UPDATE");
            $stmt->execute(['id' => $pid]);
            $product = $stmt->fetch();

            if ($product && $product['stock'] >= $qty) {
                $pdo->prepare("UPDATE products SET stock = stock - :qty WHERE id = :id")->execute(['qty'=>$qty, 'id'=>$pid]);
                
                $pdo->prepare("INSERT INTO stock_movements (product_id, user_id, type, quantity) VALUES (:pid, :uid, 'OUT', :qty)")
                    ->execute(['pid'=>$pid, 'uid'=>$_SESSION['user']['id'], 'qty'=>$qty]);
                
                $pdo->commit();
                $sukses = "Sukses: $qty pcs " . $product['name'] . " berhasil terjual/keluar!";
            } else {
                throw new Exception("Stok pakaian tidak cukup!");
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Transaksi Gagal: " . $e->getMessage();
        }
    }
}
require '../../views/header.php';
?>
<h2>Form Barang Keluar (Penjualan / Retur)</h2>
<?php if(isset($sukses)) echo "<p style='color:green'>".e($sukses)."</p>"; ?>
<?php if(isset($error)) echo "<p style='color:red'>".e($error)."</p>"; ?>

<form method="POST">
    ID Pakaian: <input type="number" name="product_id" required><br><br>
    Jumlah (Pcs): <input type="number" name="quantity" required><br><br>
    <button type="submit">Proses Barang Keluar</button>
</form>
</body></html>
