<?php
include 'config.php';

if (!isset($_GET['id_obat'])) {
    die("ID Obat tidak ditemukan.");
}

$id_obat = $_GET['id_obat'];

// Hapus data obat
$delete = mysqli_query($conn, "DELETE FROM obat WHERE id_obat='$id_obat'");

if ($delete) {
    echo "<script>alert('Data obat berhasil dihapus'); window.location='obat.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
