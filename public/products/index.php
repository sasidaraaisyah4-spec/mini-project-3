<?php
require '../../config/database.php';
require '../../helpers/auth.php'; 
require '../../helpers/escape.php';
requireLogin();

$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$search = $_GET['search'] ?? '';
$sortAllowed = ['name', 'price', 'stock'];
$sort = in_array($_GET['sort'] ?? '', $sortAllowed) ? $_GET['sort'] : 'name';

$sql = "SELECT p.*, c.name as category_name FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.name LIKE :search1 OR p.sku LIKE :search2 
        ORDER BY $sort ASC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search1', "%$search%");
$stmt->bindValue(':search2', "%$search%");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();

require '../../views/header.php';
?>
<h2>Katalog Pakaian</h2>
<form method="GET">
    <input type="text" name="search" value="<?= e($search) ?>" placeholder="Cari Nama Baju / SKU...">
    <select name="sort">
        <option value="name" <?= $sort == 'name' ? 'selected' : '' ?>>Nama Pakaian</option>
        <option value="price" <?= $sort == 'price' ? 'selected' : '' ?>>Harga Terendah</option>
        <option value="stock" <?= $sort == 'stock' ? 'selected' : '' ?>>Stok Sedikit</option>
    </select>
    <button type="submit">Filter & Cari</button>
</form>

<table border="1" style="width:100%; margin-top:10px;">
    <tr><th>SKU</th><th>Nama Pakaian</th><th>Kategori</th><th>Stok</th><th>Harga</th></tr>
    <?php foreach($products as $p): ?>
    <tr>
        <td><?= e($p['sku']) ?></td>
        <td><?= e($p['name']) ?></td>
        <td><?= e($p['category_name']) ?></td>
        <td><?= e($p['stock']) ?> pcs</td>
        <td>Rp <?= e(number_format($p['price'], 0, ',', '.')) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body></html>
