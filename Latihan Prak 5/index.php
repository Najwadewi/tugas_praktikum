<?php
session_start();
ob_start();

// Mengecek session
if (empty($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu');</script>";
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header>
        <div>Dashboard</div>
        <div class="username">
            <?php
                $username = $_SESSION['username'];
                echo "<h2>Hi, $username</h2>";
            ?>
        </div>
    </header>

    <div class="container">
        <aside>
            <ul class="menu">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="tabel-makanan.php">Makanan Khas</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </aside>

        <section class="main">
            <?php
            echo "<center>";
            echo "<h3>Anda telah berhasil login</h3>";
            echo "</center>";
            ?>
        </section>
    </div>

    <footer>
        Copyright &copy; 2024
    </footer>
</body>

</html>