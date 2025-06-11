<?php
require_once "../index/koneksi.php";
$db = new Database();

if (isset($_GET['nisn'])) {
    $nisn = $_GET['nisn'];

    // Cek apakah NISN valid
    if ($db->hapus_siswa($nisn)) {
        echo "<script>
                alert('Data siswa berhasil dihapus!');
                window.location.href = '../index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data.');
                window.location.href = '../index.php';
              </script>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
