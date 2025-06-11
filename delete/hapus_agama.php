<?php
include "koneksi.php";
$db = new Database();
$koneksi = $db->getKoneksi();

if (isset($_GET['kodeagama'])) {
    $kodeAgama = $_GET['kodeagama'];

    // Pastikan kode agama ada sebelum menghapus
    $cekQuery = "SELECT * FROM agama WHERE kodeagama = '$kodeAgama'";
    $cekResult = mysqli_query($koneksi, $cekQuery);

    if (mysqli_num_rows($cekResult) > 0) {
        $deleteQuery = "DELETE FROM agama WHERE kodeagama = '$kodeAgama'";
        if (mysqli_query($koneksi, $deleteQuery)) {
            header("Location: data_agama.php"); // Kembali ke halaman data agama setelah hapus
            exit();
        } else {
            echo "Gagal menghapus agama: " . mysqli_error($koneksi);
        }
    } else {
        echo "Agama tidak ditemukan!";
    }
} else {
    echo "Kode agama tidak diberikan!";
}
?>
