<?php
require '../config/database.php';
session_start();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy(); header("Location: login.php"); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $user['id'], 'username' => $user['username'], 'role' => $user['role']];
        header('Location: dashboard.php'); exit;
    }
    $error = "Login Gagal! Username atau password salah.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory Pakaian</title>
    <style>
        body {
            background-color: #2E3440;
            color: #ECEFF4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #3B4252;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        .login-container h2 {
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: 600;
            color: #88C0D0;
            letter-spacing: 1px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group input {
            width: 100%;
            padding: 14px;
            background-color: #4C566A;
            border: 1px solid #434C5E;
            color: #ECEFF4;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #88C0D0;
            box-shadow: 0 0 5px rgba(136, 192, 208, 0.5);
        }
        .form-group input::placeholder {
            color: #D8DEE9;
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: #5E81AC;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
            margin-top: 10px;
        }
        button:hover {
            background-color: #81A1C1;
        }
        .error {
            color: #BF616A;
            background-color: #4C566A;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #BF616A;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login Sistem</h2>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Masuk</button>
    </form>
</div>

</body>
</html>