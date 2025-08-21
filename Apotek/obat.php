<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Obat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f1f8e9;
      font-family: 'Segoe UI', sans-serif;
    }
    .header {
      background: linear-gradient(135deg, #2e7d32, #43a047);
      padding: 40px 20px;
      color: #fff;
      border-radius: 0 0 25px 25px;
      text-align: center;
      margin-bottom: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .header h2 {
      font-size: 2.5rem;
      font-weight: bold;
      margin: 0;
    }
    .header p {
      margin-top: 5px;
      font-size: 1.1rem;
      opacity: 0.9;
    }
    .table thead {
      background: #43a047;
      color: #fff;
    }
    .table tbody tr:hover {
      background: #e8f5e9;
      transition: 0.3s;
    }
    .btn-primary { background: #2e7d32; border: none; }
    .btn-primary:hover { background: #388e3c; }
    .btn-warning { background: #fbc02d; border: none; }
    .btn-warning:hover { background: #f9a825; }
    .btn-danger { background: #d32f2f; border: none; }
    .btn-danger:hover { background: #b71c1c; }
    footer {
      margin-top: 30px;
      padding: 15px 0;
      background: #2e7d32;
      color: #fff;
      text-align: center;
      border-radius: 15px 15px 0 0;
      box-shadow: 0 -3px 10px rgba(0,0,0,0.15);
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <div class="header">
    <h2>💊 Data Obat</h2>
    <p>Kelola stok dan informasi obat dengan mudah & aman</p>
  </div>

  <div class="container mb-5">
    <div class="d-flex justify-content-between mb-3">
      <a href="tambah_obat.php" class="btn btn-primary">+ Tambah Obat</a>
      <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari nama obat...">
    </div>

    <div class="table-responsive shadow-sm rounded">
      <table class="table table-striped align-middle" id="obatTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $q = mysqli_query($conn, "SELECT * FROM obat");
          $no = 1;
          while ($r = mysqli_fetch_assoc($q)) {
              echo "<tr>
                      <td>".$no++."</td>
                      <td>{$r['nama_obat']}</td>
                      <td>Rp".number_format($r['harga'],0,',','.')."</td>
                      <td>{$r['stok']}</td>
                      <td>
                        <a href='edit_obat.php?id_obat={$r['id_obat']}' class='btn btn-sm btn-warning' data-bs-toggle='tooltip' title='Edit Obat'>Edit</a>
                        <a href='hapus_obat.php?id_obat={$r['id_obat']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus?')\" data-bs-toggle='tooltip' title='Hapus Obat'>Hapus</a>
                      </td>
                    </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <a href="index.php" class="btn btn-secondary mt-3">⬅ Kembali ke Dashboard</a>
  </div>

  <footer>
    © 2025 Sistem Admin Apotek | Dibuat dengan ❤️
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Tooltip Bootstrap
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));

    // Pencarian tabel obat
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('obatTable').getElementsByTagName('tbody')[0];
    searchInput.addEventListener('keyup', function() {
      const filter = searchInput.value.toLowerCase();
      Array.from(table.getElementsByTagName('tr')).forEach(row => {
        const namaObat = row.getElementsByTagName('td')[1].textContent.toLowerCase();
        row.style.display = namaObat.includes(filter) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
