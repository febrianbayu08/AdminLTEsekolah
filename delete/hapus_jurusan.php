<?php
require_once "../index/koneksi.php";

$db = new Database();
$koneksi = $db->getKoneksi();

if (isset($_GET['kodejurusan'])) {
    $kodeJurusan = $_GET['kodejurusan'];

    // Hapus jurusan berdasarkan kode
    $deleteQuery = "DELETE FROM jurusan WHERE kodejurusan = '$kodeJurusan'";
    if (mysqli_query($koneksi, $deleteQuery)) {
        // Cek apakah tabel kosong setelah penghapusan
        $cekQuery = "SELECT COUNT(*) as total FROM jurusan";
        $cekResult = mysqli_query($koneksi, $cekQuery);
        $row = mysqli_fetch_assoc($cekResult);

        if ($row['total'] == 0) {
            // Reset Auto Increment ke 1 jika tabel kosong
            mysqli_query($koneksi, "ALTER TABLE jurusan AUTO_INCREMENT = 1");
        }

        // Kembali ke halaman sebelumnya
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: ../data/data_jurusan.php"); // Jika referer tidak tersedia, kembali ke daftar jurusan
        }
        exit();
    } else {
        echo "Gagal menghapus jurusan: " . mysqli_error($koneksi);
    }
} else {
    echo "Kode jurusan tidak diberikan!";
}
?>
