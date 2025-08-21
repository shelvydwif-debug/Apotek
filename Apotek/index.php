<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Apotek</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      font-family: 'Segoe UI', sans-serif;
    }
    .header {
      background: linear-gradient(135deg, #2e7d32, #43a047);
      padding: 70px 20px;
      color: #fff;
      border-radius: 0 0 40px 40px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.25);
      text-align: center;
    }
    .header h1 {
      font-size: 3.2rem;
      font-weight: bold;
      margin-bottom: 12px;
      letter-spacing: 1px;
    }
    .header p {
      font-size: 1.2rem;
      opacity: 0.95;
    }
    .card {
      border-radius: 18px;
      transition: all 0.3s ease;
      background: #fff;
      border: none;
      box-shadow: 0 5px 14px rgba(0,0,0,0.08);
    }
    .card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }
    .dashboard-icon {
      font-size: 3rem;
      margin-bottom: 12px;
      color: #388e3c;
    }
    .card h4 {
      color: #2e7d32;
      font-weight: 700;
      margin-bottom: 6px;
    }
    .card p {
      font-size: 0.95rem;
    }
    .info-card {
      background: #f1f8e9;
    }
    .info-card h5 {
      color: #2e7d32;
      font-weight: 600;
      margin-bottom: 12px;
    }
    footer {
      margin-top: auto;
      padding: 15px 0;
      background: #2e7d32;
      color: #fff;
      text-align: center;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      box-shadow: 0 -4px 12px rgba(0,0,0,0.15);
      font-size: 0.95rem;
    }
    a.text-decoration-none {
      text-decoration: none !important;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <div class="header">
    <h1>💊 Sistem Admin Apotek</h1>
    <p>Kelola obat, transaksi, & laporan penjualan dengan mudah dan efisien</p>
  </div>

  <!-- Dashboard -->
  <div class="container py-5">
    <div class="row g-4">
      <div class="col-md-4">
        <a href="obat.php" class="text-decoration-none">
          <div class="card text-center p-4 h-100">
            <div class="dashboard-icon">📦</div>
            <h4>Data Obat</h4>
            <p class="text-muted">Kelola stok & informasi obat</p>
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="transaksi.php" class="text-decoration-none">
          <div class="card text-center p-4 h-100">
            <div class="dashboard-icon">🛒</div>
            <h4>Transaksi</h4>
            <p class="text-muted">Catat transaksi pembelian obat</p>
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="penjualan.php" class="text-decoration-none">
          <div class="card text-center p-4 h-100">
            <div class="dashboard-icon">📊</div>
            <h4>Rekap Penjualan</h4>
            <p class="text-muted">Lihat laporan & grafik penjualan</p>
          </div>
        </a>
      </div>
    </div>

    <!-- Grafik Penjualan -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="card p-4">
          <h5 class="text-center mb-4">📈 Grafik Penjualan Mingguan</h5>
          <canvas id="salesChart" height="120"></canvas>
        </div>
      </div>
    </div>

    <!-- Info Panel -->
    <div class="row mt-5 g-4">
      <div class="col-md-6">
        <div class="card info-card p-4 h-100">
          <h5>ℹ️ Informasi</h5>
          <p class="text-muted mb-0">Sistem ini dibuat untuk mempermudah pengelolaan data apotek agar lebih efisien, rapi, dan akurat.</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card info-card p-4 h-100">
          <h5>📌 Tips Penggunaan</h5>
          <ul class="text-muted mb-0">
            <li>Update data stok obat secara berkala.</li>
            <li>Catat setiap transaksi penjualan.</li>
            <li>Cek laporan penjualan rutin setiap minggu/bulan.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p class="mb-0">© 2025 Sistem Admin Apotek | Dibuat dengan ❤️ untuk apotek Anda</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Contoh data dummy, bisa diganti dengan data dari database
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        datasets: [{
          label: 'Penjualan (Rp)',
          data: [50000, 75000, 60000, 90000, 120000, 100000, 80000],
          borderColor: '#2e7d32',
          backgroundColor: 'rgba(76,175,80,0.2)',
          borderWidth: 3,
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
