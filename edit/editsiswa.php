<?php
require_once "../index/koneksi.php";
$db = new Database();
$koneksi = $db->getKoneksi();

// Check if ID is provided
if (!isset($_GET['nisn'])) {
    header("Location: ../data/datasiswa.php");
    exit();
}

$nisn = $_GET['nisn'];
$siswa_data = $db->get_siswa_by_nisn($nisn);

// If data not found, redirect back to the list
if (!$siswa_data) {
    header("Location: ../data/datasiswa.php");
    exit();
}

// Get list of jurusan for dropdown
$query_jurusan = "SELECT * FROM jurusan";
$result_jurusan = mysqli_query($koneksi, $query_jurusan);
$jurusan_list = [];
while ($row = mysqli_fetch_assoc($result_jurusan)) {
    $jurusan_list[] = $row;
}

// Get list of agama from database
$query_agama = "SELECT * FROM agama";
$result_agama = mysqli_query($koneksi, $query_agama);
$agama_list = [];
while ($row = mysqli_fetch_assoc($result_agama)) {
    $agama_list[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $kodejurusan = $_POST['kodejurusan'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $nohp = $_POST['nohp'];

    if ($db->update_siswa($nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp)) {
        // Redirect to student data page after successful update
        header("Location: ../data/datasiswa.php");
        exit();
    } else {
        $error_message = "Gagal memperbarui data siswa!";
    }
}
?>

<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Edit siswa</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Edit siswa" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
        integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../dist/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
                </ul>
                <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!-- Navbar links omitted for brevity -->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <?php include '../navbar/sidebar.php'; ?>
        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Edit siswa</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="../data/datasiswa.php">Data siswa</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit siswa</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Form Card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Form Edit siswa</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php if (isset($error_message)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= htmlspecialchars($error_message); ?>
                                        </div>
                                    <?php endif; ?>

                                    <form action="editsiswa.php?nisn=<?= htmlspecialchars($nisn); ?>" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nisn" class="form-label">NISN</label>
                                                    <input type="text" class="form-control" id="nisn" name="nisn"
                                                        value="<?= htmlspecialchars($siswa_data['nisn']); ?>"
                                                        placeholder="Masukkan NISN" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama" class="mb-2">Nama</label>
                                                    <input type="text" class="form-control" id="nama" name="nama"
                                                        value="<?= htmlspecialchars($siswa_data['nama']); ?>"
                                                        placeholder="Masukkan Nama" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jeniskelamin" class="mb-2">Jenis Kelamin</label>
                                                    <select class="form-select" id="jeniskelamin" name="jeniskelamin"
                                                        required>
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="L" <?= ($siswa_data['jeniskelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                                        <option value="P" <?= ($siswa_data['jeniskelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kodejurusan" class="mb-2">Jurusan</label>
                                                    <select class="form-select" id="kodejurusan" name="kodejurusan"
                                                        required>
                                                        <option value="">Pilih Jurusan</option>
                                                        <?php foreach ($jurusan_list as $jurusan): ?>
                                                            <option
                                                                value="<?= htmlspecialchars($jurusan['kodejurusan']); ?>"
                                                                <?= ($siswa_data['kodejurusan'] == $jurusan['kodejurusan']) ? 'selected' : ''; ?>>
                                                                <?= htmlspecialchars($jurusan['namajurusan']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="kelas" class="form-label">Kelas</label>
                                                    <input type="text" class="form-control" id="kelas" name="kelas"
                                                        value="<?= htmlspecialchars($siswa_data['kelas']); ?>"
                                                        placeholder="Masukkan Kelas" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat" class="mb-2">Alamat</label>
                                                    <textarea class="form-control" id="alamat" name="alamat"
                                                        placeholder="Masukkan Alamat" required
                                                        rows="3"><?= htmlspecialchars($siswa_data['alamat']); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="agama" class="mb-2">Agama</label>
                                                    <select class="form-select" id="agama" name="agama" required>
                                                        <option value="">Pilih Agama</option>
                                                        <?php foreach ($agama_list as $agama): ?>
                                                            <option value="<?= htmlspecialchars($agama['kodeagama']); ?>"
                                                                <?= ($siswa_data['agama'] == $agama['kodeagama']) ? 'selected' : ''; ?>>
                                                                <?= htmlspecialchars($agama['agama']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nohp" class="mb-2">Nomor telepon</label>
                                                    <input type="text" class="form-control" id="nohp" name="nohp"
                                                        value="<?= htmlspecialchars($siswa_data['nohp']); ?>"
                                                        placeholder="Masukkan Nomor Telepon" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                <a href="../data/datasiswa.php" class="btn btn-secondary">Kembali</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        <footer class="app-footer">
        <!--begin::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2025&nbsp;
          <a href="#" class="text-decoration-none">SMK Negeri 6 Surakarta</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)-->

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
</body>
<!--end::Body-->

</html>