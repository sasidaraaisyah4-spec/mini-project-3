<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management Pakaian</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            background-color: #2E3440; 
            color: #ECEFF4; 
        }
        nav { 
            background: #3B4252; 
            padding: 15px 25px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-links a { 
            color: #88C0D0; 
            text-decoration: none; 
            margin-right: 25px; 
            font-weight: 600;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: #8FBCBB; }
        .logout-btn {
            color: #BF616A;
            text-decoration: none;
            font-weight: 600;
            background-color: #4C566A;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .logout-btn:hover { background-color: #D08770; color: #2E3440; }
        .container { padding: 30px; }
        
        /* Tema Gelap untuk Tabel dan Input di halaman lain */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background-color: #3B4252; border-radius: 8px; overflow: hidden; }
        th, td { border-bottom: 1px solid #434C5E; padding: 12px 15px; text-align: left; }
        th { background-color: #4C566A; color: #ECEFF4; text-transform: uppercase; font-size: 13px;}
        input, select, button { padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #434C5E; background-color: #4C566A; color: #ECEFF4; }
        button { background-color: #5E81AC; cursor: pointer; border: none; font-weight: bold; padding: 10px 20px;}
        button:hover { background-color: #81A1C1; color: #2E3440;}
    </style>
</head>
<body>
    <nav>
        <div class="nav-links">
            <a href="/inventory-app/public/dashboard.php">Dashboard</a>
            <a href="/inventory-app/public/products/index.php">Data Pakaian</a>
            <a href="/inventory-app/public/stock/out.php">Barang Keluar</a>
        </div>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/inventory-app/public/login.php?action=logout" class="logout-btn">
                Logout (<?= htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') ?>)
            </a>
        <?php endif; ?>
    </nav>
    <div class="container"> <!-- Container pembungkus isi konten -->