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

            if ($product) {
                // UPDATE STOK DITAMBAH (+)
                $pdo->prepare("UPDATE products SET stock = stock + :qty WHERE id = :id")->execute(['qty' => $qty, 'id' => $pid]);
                
                // CATAT SEBAGAI BARANG MASUK ('IN')
                $pdo->prepare("INSERT INTO stock_movements (product_id, user_id, type, quantity) VALUES (:pid, :uid, 'IN', :qty)")
                    ->execute(['pid' => $pid, 'uid' => $_SESSION['user']['id'], 'qty' => $qty]);
                
                $pdo->commit();
                $sukses = "Sukses: $qty pcs " . $product['name'] . " berhasil ditambahkan/restok!";
            } else {
                throw new Exception("ID Pakaian tidak ditemukan!");
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Transaksi Gagal: " . $e->getMessage();
        }
    }
}
require '../../views/header.php';
?>

<div style="padding: 20px;">
    <h2>Form Barang Masuk (Restok / Pembelian)</h2>
    
    <?php if(isset($sukses)) echo "<p style='color:#34D399; font-weight:bold;'>".e($sukses)."</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:#F87171; font-weight:bold;'>".e($error)."</p>"; ?>
    
    <form method="POST" action="">
        <div style="margin-bottom: 15px;">
            <label>ID Pakaian:</label><br>
            <input type="number" name="product_id" required style="padding: 10px; width: 300px; background: #374151; color: white; border: none; border-radius: 5px; margin-top: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Jumlah (Pcs):</label><br>
            <input type="number" name="quantity" min="1" required style="padding: 10px; width: 300px; background: #374151; color: white; border: none; border-radius: 5px; margin-top: 5px;">
        </div>
        <button type="submit" style="padding: 10px 20px; background: #60A5FA; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
            Proses Barang Masuk
        </button>
    </form>
</div>

</body>
</html>