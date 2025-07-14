<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $instansi = $_POST['instansi'];
    $keperluan = $_POST['keperluan'];
    $waktu = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO tamu (nama, instansi, keperluan, waktu) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $instansi, $keperluan, $waktu);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal menyimpan data tamu.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2 class="mb-4">Form Tambah Tamu</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Instansi / Perusahaan</label>
            <input type="text" name="instansi" class="form-control">
        </div>
        <div class="mb-3">
            <label>Keperluan</label>
            <input type="text" name="keperluan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
