<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Transaksi Apotek</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      padding-top: 40px;
      padding-bottom: 40px;
    }
    h2 {
      font-weight: bold;
      color: #00796b;
      margin-bottom: 30px;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      overflow: hidden;
    }
    .card-header {
      font-weight: bold;
      font-size: 1.1rem;
    }
    .form-select, .form-control {
      border-radius: 12px;
    }
    .btn-success {
      background: #00796b;
      border: none;
      transition: 0.3s;
    }
    .btn-success:hover {
      background: #004d40;
    }
    .btn-secondary {
      transition: 0.3s;
    }
    .btn-secondary:hover {
      background: #80cbc4;
      color: #fff;
    }
    table tbody tr:hover {
      background: #b2dfdb;
      transition: 0.3s;
    }
    .alert {
      border-radius: 12px;
      font-weight: 500;
    }
    .preview-total {
      margin-top: 10px;
      padding: 10px;
      border-radius: 12px;
      background: #b2dfdb;
      font-weight: bold;
      color: #004d40;
      display: none;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>🛒 Transaksi</h2>
  
  <!-- Form Transaksi -->
  <div class="card p-4 mb-4">
    <form method="post" class="row g-3 align-items-end" id="transaksiForm">
      <div class="col-md-6">
        <label class="form-label">Pilih Obat</label>
        <select name="id_obat" id="id_obat" class="form-select" required>
          <option value="">-- Pilih Obat --</option>
          <?php
          $q = mysqli_query($conn, "SELECT * FROM obat");
          while ($r = mysqli_fetch_assoc($q)) {
              echo "<option value='{$r['id_obat']}' data-harga='{$r['harga']}'>{$r['nama_obat']} (Stok: {$r['stok']})</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" min="1" required>
      </div>
      <div class="col-md-3 d-grid">
        <button type="submit" name="beli" class="btn btn-success">Proses <i class="bi bi-currency-dollar"></i></button>
      </div>
      <div class="col-12">
        <div id="previewTotal" class="preview-total"></div>
      </div>
    </form>
  </div>

  <?php
  if (isset($_POST['beli'])) {
      $id = (int)$_POST['id_obat'];
      $jumlah = (int)$_POST['jumlah'];

      $oRes = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat=$id");
      $o = mysqli_fetch_assoc($oRes);

      if ($o) {
          $total = $o['harga'] * $jumlah;
          $tanggal = date("Y-m-d H:i:s");

          if ($o['stok'] >= $jumlah && $jumlah > 0) {
              $ins = mysqli_query($conn, "INSERT INTO transaksi (id_obat, jumlah, total, tanggal) 
                                          VALUES ($id, $jumlah, $total, '$tanggal')");
              $upd = mysqli_query($conn, "UPDATE obat SET stok = stok - $jumlah WHERE id_obat=$id");

              if ($ins && $upd) {
                  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                          <i class='bi bi-check-circle-fill'></i> Transaksi berhasil! Total: Rp".number_format($total,0,',','.')."
                          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
              } else {
                  echo "<div class='alert alert-danger'>Gagal menyimpan transaksi.</div>";
              }
          } else {
              echo "<div class='alert alert-danger'><i class='bi bi-exclamation-triangle-fill'></i> Stok tidak cukup atau jumlah tidak valid!</div>";
          }
      } else {
          echo "<div class='alert alert-danger'>Obat tidak ditemukan.</div>";
      }
  }
  ?>

  <!-- Daftar Transaksi -->
  <div class="card shadow-sm">
    <div class="card-header bg-success text-white">📑 Daftar Transaksi</div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead class="table-success">
          <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Total</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $q = mysqli_query($conn, "SELECT t.id_transaksi, t.jumlah, t.total, t.tanggal, o.nama_obat, o.harga 
                                  FROM transaksi t 
                                  JOIN obat o ON t.id_obat=o.id_obat 
                                  ORDER BY t.id_transaksi DESC");
        $no = 1;
        while ($r = mysqli_fetch_assoc($q)) {
            echo "<tr>
                    <td>".$no++."</td>
                    <td>{$r['nama_obat']}</td>
                    <td>{$r['jumlah']}</td>
                    <td>Rp".number_format($r['harga'],0,',','.')."</td>
                    <td>Rp".number_format($r['total'],0,',','.')."</td>
                    <td>{$r['tanggal']}</td>
                  </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>

  <a href="index.php" class="btn btn-secondary mt-3">⬅ Kembali</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const obatSelect = document.getElementById('id_obat');
  const jumlahInput = document.getElementById('jumlah');
  const previewTotal = document.getElementById('previewTotal');

  function updatePreview() {
    const harga = parseInt(obatSelect.selectedOptions[0]?.dataset.harga) || 0;
    const jumlah = parseInt(jumlahInput.value) || 0;
    if (harga && jumlah) {
      const total = harga * jumlah;
      previewTotal.textContent = `💰 Total Harga: Rp${total.toLocaleString('id-ID')}`;
      previewTotal.style.display = 'block';
    } else {
      previewTotal.style.display = 'none';
    }
  }

  obatSelect.addEventListener('change', updatePreview);
  jumlahInput.addEventListener('input', updatePreview);
</script>
</body>
</html>
