<?php
include 'config.php';

if (!isset($_GET['id_obat'])) {
    die("ID Obat tidak ditemukan.");
}

$id_obat = $_GET['id_obat'];

// Ambil data obat
$result = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat='$id_obat'");
if (!$result || mysqli_num_rows($result) == 0) {
    die("Data obat tidak ditemukan.");
}
$obat = mysqli_fetch_assoc($result);

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_obat = $_POST['nama_obat'];
    $jenis = $_POST['jenis'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $update = mysqli_query($conn, "UPDATE obat 
        SET nama_obat='$nama_obat', jenis='$jenis', stok='$stok', harga='$harga' 
        WHERE id_obat='$id_obat'");

    if ($update) {
        echo "<script>alert('Data obat berhasil diperbarui'); window.location='obat.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Obat Interaktif</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e0f2f1, #b2dfdb);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 12px 28px rgba(0,0,0,0.15);
      padding: 30px;
      width: 100%;
      max-width: 520px;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 36px rgba(0,0,0,0.25);
    }
    .header-card {
      background: linear-gradient(135deg, #26a69a, #00796b);
      color: #fff;
      text-align: center;
      padding: 20px;
      border-radius: 15px 15px 0 0;
      margin: -30px -30px 20px -30px;
      font-size: 1.6rem;
      font-weight: bold;
      box-shadow: inset 0 -2px 5px rgba(0,0,0,0.1);
    }
    .form-control:focus {
      border-color: #00796b;
      box-shadow: 0 0 6px rgba(0,121,107,0.5);
    }
    .btn-primary {
      background: #00796b;
      border: none;
      transition: 0.3s;
    }
    .btn-primary:hover {
      background: #004d40;
    }
    .btn-secondary {
      transition: 0.3s;
    }
    .btn-secondary:hover {
      background: #80cbc4;
      color: #fff;
    }
    .stok-alert {
      font-weight: 600;
      margin-top: 5px;
      color: #c62828;
    }
    .preview-card {
      background: #b2dfdb;
      color: #004d40;
      font-weight: bold;
      padding: 10px 15px;
      border-radius: 12px;
      text-align: center;
      margin-top: 10px;
      transition: all 0.3s ease;
      opacity: 0;
    }
    .preview-card.show {
      opacity: 1;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="header-card">✏️ Edit Data Obat Interaktif</div>
    <form method="POST" id="editObatForm">
      <div class="mb-3">
        <label class="form-label">Nama Obat</label>
        <input type="text" name="nama_obat" class="form-control" value="<?= $obat['nama_obat']; ?>" placeholder="Masukkan nama obat" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Jenis</label>
        <select name="jenis" class="form-control" required>
          <?php
          $jenis_options = ['Tablet','Kapsul','Sirup','Salep','Lainnya'];
          foreach($jenis_options as $j){
              $selected = ($obat['jenis']==$j)?'selected':'';
              echo "<option value='$j' $selected>$j</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Stok</label>
        <input type="number" name="stok" id="stok" class="form-control" value="<?= $obat['stok']; ?>" placeholder="Jumlah stok tersedia" required>
        <div id="stokAlert" class="stok-alert" style="display:none;">⚠️ Stok hampir habis!</div>
      </div>
      <div class="mb-3">
        <label class="form-label">Harga (Rp)</label>
        <input type="number" name="harga" id="harga" class="form-control" value="<?= $obat['harga']; ?>" placeholder="Masukkan harga obat" required>
      </div>
      <div id="previewHarga" class="preview-card"></div>
      <button type="submit" class="btn btn-primary w-100 mt-3">Simpan Perubahan</button>
      <a href="obat.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
    </form>
  </div>

  <script>
    const stokInput = document.getElementById('stok');
    const hargaInput = document.getElementById('harga');
    const previewCard = document.getElementById('previewHarga');
    const stokAlert = document.getElementById('stokAlert');

    function updatePreview() {
      const stok = parseInt(stokInput.value) || 0;
      const harga = parseInt(hargaInput.value) || 0;
      const total = stok * harga;

      previewCard.textContent = "💰 Total Harga Stok: Rp" + total.toLocaleString('id-ID');
      previewCard.classList.add('show');

      stokAlert.style.display = (stok <= 5) ? 'block' : 'none';
    }

    stokInput.addEventListener('input', updatePreview);
    hargaInput.addEventListener('input', updatePreview);

    // Tampilkan preview saat halaman pertama load
    window.addEventListener('DOMContentLoaded', updatePreview);
  </script>
</body>
</html>
