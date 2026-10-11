<?php
require '../config/database.php';
require '../helpers/auth.php'; 
require '../helpers/escape.php';
requireLogin(); 
require '../views/header.php';

$totalProduk = $pdo->query("SELECT COUNT(id) FROM products")->fetchColumn();
$nilaiInventory = $pdo->query("SELECT SUM(stock * price) FROM products")->fetchColumn();
$lowStocks = $pdo->query("SELECT name, stock, minimum_stock FROM products WHERE stock <= minimum_stock")->fetchAll();
?>
<h2>Dashboard Toko Pakaian</h2>
<div style="display:flex; gap: 20px; margin-top: 20px;">
    <!-- Widget 1 -->
    <div style="background-color:#3B4252; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.2); flex: 1;">
        <h3 style="margin-top: 0; color: #8FBCBB;">Total Model Pakaian</h3>
        <p style="font-size: 28px; font-weight: bold; margin: 0; color: #ECEFF4;"><?= e($totalProduk) ?> <span style="font-size: 14px; font-weight: normal; color: #D8DEE9;">Item</span></p>
    </div>
    
    <!-- Widget 2 -->
    <div style="background-color:#3B4252; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.2); flex: 1;">
        <h3 style="margin-top: 0; color: #EBCB8B;">Total Aset (Rupiah)</h3>
        <p style="font-size: 28px; font-weight: bold; margin: 0; color: #ECEFF4;">Rp <?= e(number_format($nilaiInventory, 0, ',', '.')) ?></p>
    </div>
</div>

<h3 style="margin-top: 40px; border-bottom: 2px solid #4C566A; padding-bottom: 10px;">Peringatan: Pakaian Hampir Habis!</h3>
<ul style="list-style-type: none; padding: 0;">
    <?php foreach($lowStocks as $item): ?>
        <li style="background-color: #4C566A; border-left: 5px solid #BF616A; padding: 15px; margin-bottom: 10px; border-radius: 4px;">
            <strong style="color: #ECEFF4;"><?= e($item['name']) ?></strong> 
            <span style="float: right; color: #BF616A; font-weight: bold;">Sisa: <?= e($item['stock']) ?> pcs</span>
        </li>
    <?php endforeach; ?>
</ul>

</div> <!-- Penutup div container dari header.php -->
</body></html>