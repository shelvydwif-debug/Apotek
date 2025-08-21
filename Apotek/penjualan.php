<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Rekap Penjualan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h2 {
      font-weight: 700;
      color: #1b5e20;
    }
    .card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 30px rgba(0,0,0,0.15);
      margin-bottom: 30px;
    }
    .card-header {
      background: linear-gradient(135deg, #43a047, #1b5e20);
      font-size: 1.2rem;
      font-weight: 600;
      color: #fff;
      text-align: center;
      box-shadow: inset 0 -2px 5px rgba(0,0,0,0.1);
    }
    .table thead {
      background-color: #a5d6a7;
      color: #1b5e20;
    }
    .table tbody tr:hover {
      background-color: #e0f2f1;
      transition: 0.3s;
    }
    .badge-custom {
      background-color: #66bb6a;
      color: #fff;
      font-size: 0.9rem;
      padding: 0.4em 0.7em;
      border-radius: 12px;
      transition: 0.3s;
    }
    .badge-custom:hover {
      background-color: #388e3c;
      transform: scale(1.05);
    }
    .total-footer {
      font-size: 1.2rem;
      font-weight: 700;
      color: #1b5e20;
    }
    .btn-custom {
      background: linear-gradient(135deg, #43a047, #1b5e20);
      border: none;
      border-radius: 10px;
      color: white;
      font-weight: 600;
      padding: 10px 20px;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: linear-gradient(135deg, #2e7d32, #1b5e20);
      transform: scale(1.05);
    }
    .table-responsive {
      overflow-x: auto;
    }
    #chartContainer {
      margin-bottom: 30px;
      padding: 20px;
      background: #ffffffaa;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="text-center mb-4">
    <h2><i class="bi bi-bar-chart-line-fill"></i> Rekap Penjualan</h2>
    <p class="text-muted">Data transaksi penjualan obat pada apotek</p>
  </div>

  <!-- Daftar Transaksi -->
  <div class="card">
    <div class="card-header"><i class="bi bi-journal-check"></i> Daftar Transaksi</div>
    <div class="card-body p-0 table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th>Nama Obat</th>
            <th class="text-center">Jumlah</th>
            <th>Total</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $q = mysqli_query($conn, "SELECT t.id_transaksi, o.nama_obat, t.jumlah, t.total, t.tanggal
                                  FROM transaksi t
                                  JOIN obat o ON t.id_obat = o.id_obat
                                  ORDER BY t.id_transaksi DESC");
        $no = 1;
        $grandTotal = 0;
        $chartLabels = [];
        $chartData = [];
        while ($r = mysqli_fetch_assoc($q)) {
            $grandTotal += $r['total'];
            echo "<tr>
                    <td class='fw-bold text-center'>".$no++."</td>
                    <td><span class='badge-custom'>{$r['nama_obat']}</span></td>
                    <td class='text-center'><span class='badge bg-success'>{$r['jumlah']}</span></td>
                    <td class='text-success fw-semibold'>Rp".number_format($r['total'],0,',','.')."</td>
                    <td><span class='text-muted'>{$r['tanggal']}</span></td>
                  </tr>";
            // Persiapkan data untuk chart
            $chartLabels[] = date('d M H:i', strtotime($r['tanggal']));
            $chartData[] = $r['total'];
        }
        ?>
        </tbody>
        <tfoot>
          <tr class="table-light">
            <th colspan="3" class="text-end total-footer">Total Penjualan:</th>
            <th colspan="2" class="total-footer">Rp<?= number_format($grandTotal,0,',','.') ?> <i ></i></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- Grafik Penjualan -->
  <div id="chartContainer">
    <canvas id="salesChart"></canvas>
  </div>

  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-custom"><i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard</a>
  </div>
</div>

<script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: <?= json_encode(array_reverse($chartLabels)) ?>,
          datasets: [{
              label: 'Total Penjualan (Rp)',
              data: <?= json_encode(array_reverse($chartData)) ?>,
              backgroundColor: 'rgba(76, 175, 80, 0.2)',
              borderColor: 'rgba(76, 175, 80, 1)',
              borderWidth: 2,
              tension: 0.3,
              fill: true,
              pointRadius: 4,
              pointBackgroundColor: 'rgba(56, 142, 60, 1)'
          }]
      },
      options: {
          responsive: true,
          plugins: {
              legend: { display: true, position: 'top' },
              tooltip: {
                  mode: 'index',
                  intersect: false,
                  callbacks: {
                      label: function(context) {
                          return 'Rp' + context.raw.toLocaleString('id-ID');
                      }
                  }
              }
          },
          interaction: { mode: 'nearest', axis: 'x', intersect: false },
          scales: {
              x: { title: { display: true, text: 'Tanggal' }, ticks: { maxRotation: 90, minRotation: 45 } },
              y: { title: { display: true, text: 'Total Penjualan (Rp)' }, beginAtZero: true }
          }
      }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
