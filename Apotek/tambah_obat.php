<?php
include 'config.php';

// Proses simpan obat baru
if (isset($_POST['simpan'])) {
    $nama_obat = $_POST['nama_obat'];
    $jenis = $_POST['jenis'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO obat (nama_obat, jenis, stok, harga) 
              VALUES ('$nama_obat', '$jenis', '$stok', '$harga')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Obat berhasil ditambahkan!');window.location='obat.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Obat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow p-4">
      <h2 class="text-success mb-4">➕ Tambah Obat Baru</h2>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Nama Obat</label>
          <input type="text" name="nama_obat" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Jenis</label>
          <input type="text" name="jenis" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Stok</label>
          <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Harga</label>
          <input type="number" name="harga" class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="obat.php" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</body>
</html>
