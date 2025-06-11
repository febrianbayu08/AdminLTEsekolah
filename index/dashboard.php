<?php
// Assuming you have the Database class included
include_once 'koneksi.php'; // Adjust path as needed

session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';


// Create database instance
$db = new Database();

// Get counts for each data type
function getDataCounts($database)
{
  $counts = [];

  // Count students
  $query_siswa = "SELECT COUNT(*) as total FROM siswa";
  $result_siswa = $database->getKoneksi()->query($query_siswa);
  $counts['siswa'] = $result_siswa ? $result_siswa->fetch_assoc()['total'] : 0;

  // Count religions
  $query_agama = "SELECT COUNT(*) as total FROM agama";
  $result_agama = $database->getKoneksi()->query($query_agama);
  $counts['agama'] = $result_agama ? $result_agama->fetch_assoc()['total'] : 0;

  // Count departments
  $query_jurusan = "SELECT COUNT(*) as total FROM jurusan";
  $result_jurusan = $database->getKoneksi()->query($query_jurusan);
  $counts['jurusan'] = $result_jurusan ? $result_jurusan->fetch_assoc()['total'] : 0;

  // Count users
  $query_users = "SELECT COUNT(*) as total FROM users";
  $result_users = $database->getKoneksi()->query($query_users);
  $counts['users'] = $result_users ? $result_users->fetch_assoc()['total'] : 0;

  return $counts;
}

$counts = getDataCounts($db);

function getChartData($database)
{
  $chartData = [];

  // Get students by department
  $query_siswa_jurusan = "
        SELECT j.namajurusan, COUNT(s.nisn) as jumlah_siswa 
        FROM jurusan j 
        LEFT JOIN siswa s ON j.kodejurusan = s.kodejurusan 
        GROUP BY j.kodejurusan, j.namajurusan
        ORDER BY jumlah_siswa DESC
    ";
  $result_siswa_jurusan = $database->getKoneksi()->query($query_siswa_jurusan);
  $chartData['siswa_jurusan'] = [];
  if ($result_siswa_jurusan) {
    while ($row = $result_siswa_jurusan->fetch_assoc()) {
      $chartData['siswa_jurusan'][] = $row;
    }
  }

  // Get students by religion
  $query_siswa_agama = "
    SELECT a.agama, COUNT(s.nisn) as jumlah_siswa 
    FROM agama a 
    LEFT JOIN siswa s ON a.kodeagama = s.agama
    GROUP BY a.kodeagama, a.agama
    ORDER BY jumlah_siswa DESC
";
  $result_siswa_agama = $database->getKoneksi()->query($query_siswa_agama);
  $chartData['siswa_agama'] = [];
  if ($result_siswa_agama) {
    while ($row = $result_siswa_agama->fetch_assoc()) {
      $chartData['siswa_agama'][] = $row;
    }
  }

  // Get overview data for pie chart
  $overview_data = [
    ['label' => 'Siswa', 'value' => 0],
    ['label' => 'Jurusan', 'value' => 0],
    ['label' => 'Agama', 'value' => 0],
    ['label' => 'Users', 'value' => 0]
  ];

  // Count each category
  $queries = [
    'siswa' => "SELECT COUNT(*) as total FROM siswa",
    'jurusan' => "SELECT COUNT(*) as total FROM jurusan",
    'agama' => "SELECT COUNT(*) as total FROM agama",
    'users' => "SELECT COUNT(*) as total FROM users"
  ];

  $i = 0;
  foreach ($queries as $key => $query) {
    $result = $database->getKoneksi()->query($query);
    if ($result) {
      $overview_data[$i]['value'] = $result->fetch_assoc()['total'];
    }
    $i++;
  }

  $chartData['overview'] = $overview_data;

  return $chartData;
}

// Panggil fungsi ini setelah $counts = getDataCounts($db);
$chartData = getChartData($db);
?>

<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" type="image/x-icon" href="../dist/assets/img/logosmk6.png" />
  <title>SMK N 6 SKA | Dashboard</title>
  <!--begin::Primary Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="AdminLTE v4 | Dashboard" />
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
  <!-- apexcharts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
    integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />

  <!-- Custom CSS untuk responsive charts -->
  <style>
    /* Custom responsive chart styling */
    .chart-container {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
    }
    
    .chart-wrapper {
      width: 100%;
      max-width: 100%;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
      .chart-container {
        padding: 0 15px;
      }
      
      .card-body {
        padding: 1rem 0.5rem;
      }
      
      /* Center chart content on mobile */
      .apexcharts-canvas {
        margin: 0 auto !important;
      }
      
      .apexcharts-legend {
        justify-content: center !important;
      }
      
      /* Adjust chart size for mobile */
      .mobile-chart {
        height: 250px !important;
      }
    }
    
    @media (max-width: 576px) {
      .chart-container {
        padding: 0 10px;
      }
      
      .mobile-chart {
        height: 220px !important;
      }
      
      /* Make sure titles are centered */
      .apexcharts-title-text {
        text-anchor: middle !important;
      }
    }
  </style>

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
          <!--begin::Navbar Search-->
          <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
              <i class="bi bi-search"></i>
            </a>
          </li>
          <!--end::Navbar Search-->
          <!--begin::Messages Dropdown Menu-->
          <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
              <i class="bi bi-chat-text"></i>
              <span class="navbar-badge badge text-bg-danger">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img src="../dist/assets/img/user1-128x128.jpg" alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      Brad Diesel
                      <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                    </h3>
                    <p class="fs-7">Call me whenever you can...</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img src="../dist/assets/img/user8-128x128.jpg" alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      John Pierce
                      <span class="float-end fs-7 text-secondary">
                        <i class="bi bi-star-fill"></i>
                      </span>
                    </h3>
                    <p class="fs-7">I got your message bro</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <!--begin::Message-->
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <img src="../dist/assets/img/user3-128x128.jpg" alt="User Avatar"
                      class="img-size-50 rounded-circle me-3" />
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="dropdown-item-title">
                      Nora Silvester
                      <span class="float-end fs-7 text-warning">
                        <i class="bi bi-star-fill"></i>
                      </span>
                    </h3>
                    <p class="fs-7">The subject goes here</p>
                    <p class="fs-7 text-secondary">
                      <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                    </p>
                  </div>
                </div>
                <!--end::Message-->
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
          </li>
          <!--end::Messages Dropdown Menu-->
          <!--begin::Notifications Dropdown Menu-->
          <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#">
              <i class="bi bi-bell-fill"></i>
              <span class="navbar-badge badge text-bg-warning">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <span class="dropdown-item dropdown-header">15 Notifications</span>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-envelope me-2"></i> 4 new messages
                <span class="float-end text-secondary fs-7">3 mins</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-people-fill me-2"></i> 8 friend requests
                <span class="float-end text-secondary fs-7">12 hours</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                <span class="float-end text-secondary fs-7">2 days</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
            </div>
          </li>
          <!--end::Notifications Dropdown Menu-->
          <!--begin::Fullscreen Toggle-->
          <li class="nav-item">
            <a class="nav-link" href="#" data-lte-toggle="fullscreen">
              <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
              <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
            </a>
          </li>
          <!--end::Fullscreen Toggle-->
          <!--begin::User Menu Dropdown-->
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <img src="../dist/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow"
                alt="User Image" />
              <span class="d-none d-md-inline"><?= htmlspecialchars($username) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <!--begin::User Image-->
              <li class="user-header text-bg-primary">
                <img src="../dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image" />
                <p>
                  <?= htmlspecialchars($username) ?> - Web Developer
                  <small>Member since Nov. 2023</small>
                </p>

              </li>
              <!--end::User Image-->
              <!--begin::Menu Body-->
              <li class="user-body">
                <!--begin::Row-->
                <div class="row">
                  <div class="col-4 text-center"><a href="#">Followers</a></div>
                  <div class="col-4 text-center"><a href="#">Sales</a></div>
                  <div class="col-4 text-center"><a href="#">Friends</a></div>
                </div>
                <!--end::Row-->
              </li>
              <!--end::Menu Body-->
              <!--begin::Menu Footer-->
              <li class="user-footer">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
                <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
              </li>
              <!--end::Menu Footer-->
            </ul>
          </li>
          <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--  begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="../index/dashboard.php" class="brand-link">
          <!--begin::Brand Image-->
          <img src="../dist/assets/img/logosmk6.png" alt="Smkn 6 Logo" class="brand-image opacity-75 shadow" />
          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light">Smk Negeri 6 SKA</span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-table"></i>
                <p>
                  Data
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../data/datasiswa.php" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Data Siswa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../data/datajurusan.php" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Data Jurusan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../data/dataagama.php" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Data Agama</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-pencil-square"></i>
                <p>
                  Tambah Data
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../addData/tambahsiswa.php" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Tambah Siswa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../addData/tambahjurusan.php" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Tambah Jurusan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../addData/tambahagama.php" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Tambah Agama</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="../users/users.php" class="nav-link">
                <i class="nav-icon bi bi-box-arrow-in-right"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../profile/profile.php" class="nav-link">
                <i class="nav-icon bi bi-person-fill"></i>
                <p>
                  Profile
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../logout.php" class="nav-link">
                <i class="bi bi-box-arrow-left"></i>
                <p>Logout</p>
              </a>
            </li>
          </ul>
          <!--end::Sidebar Menu-->
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Dashboard</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
          <!--begin::Row-->
          <div class="row">
            <!--begin::Col-->
            <div class="col-lg-3 col-6">
              <!--begin::Small Box Widget 1-->
              <div class="small-box text-bg-primary">
                <div class="inner">
                  <h3><?php echo $counts['siswa']; ?></h3>
                  <p>Total Siswa</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true">
                  <path
                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122z">
                  </path>
                </svg>
                <a href="../data/datasiswa.php"
                  class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                  More info <i class="bi bi-link-45deg"></i>
                </a>
              </div>
              <!--end::Small Box Widget 1-->
            </div>
            <!--end::Col-->
            <div class="col-lg-3 col-6">
              <!--begin::Small Box Widget 2-->
              <div class="small-box text-bg-success">
                <div class="inner">
                  <h3><?php echo $counts['jurusan']; ?></h3>
                  <p>Total Jurusan</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true">
                  <path
                    d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 007.5 12.174v-.224c0-.131.067-.248.172-.311a54.614 54.614 0 014.653-2.52.75.75 0 00-.65-1.352 56.129 56.129 0 00-4.78 2.589 1.858 1.858 0 00-.859 1.228 49.803 49.803 0 00-4.634-1.527.75.75 0 01-.231-1.337A60.653 60.653 0 0111.7 2.805z">
                  </path>
                  <path
                    d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 016 13.18v1.27a1.5 1.5 0 00-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.661a6.729 6.729 0 00.551-1.608 1.5 1.5 0 00.14-2.67v-.645a48.549 48.549 0 013.44 1.668 2.25 2.25 0 002.12 0z">
                  </path>
                  <path
                    d="M4.462 19.462c.42-.419.753-.89 1-1.394.453.213.902.434 1.347.661a6.743 6.743 0 01-1.286 1.794.75.75 0 11-1.061-1.061z">
                  </path>
                </svg>
                <a href="../data/datajurusan.php"
                  class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                  More info <i class="bi bi-link-45deg"></i>
                </a>
              </div>
              <!--end::Small Box Widget 2-->
            </div>
            <!--end::Col-->
            <!--end::Col-->
            <div class="col-lg-3 col-6">
              <!--begin::Small Box Widget 2-->
              <div class="small-box text-bg-success">
                <div class="inner">
                  <h3><?php echo $counts['agama']; ?></h3>
                  <p>Total Agama</p>
                </div>

                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M12 2a10 10 0 1 0 0 20 5 5 0 0 1 0-10 5 5 0 0 0 0-10zm0 5a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0 10a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>


                <a href="../data/dataagama.php"
                  class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                  More info <i class="bi bi-link-45deg"></i>
                </a>
              </div>
              <!--end::Small Box Widget 2-->
            </div>

            <!--end::Col-->
            <div class="col-lg-3 col-6">
              <!--begin::Small Box Widget 3-->
              <div class="small-box text-bg-warning">
                <div class="inner">
                  <h3><?php echo $counts['users']; ?></h3>
                  <p>Total Users</p>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true">
                  <path
                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                  </path>
                </svg>
                <a href="../users/users.php"
                  class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                  More info <i class="bi bi-link-45deg"></i>
                </a>
              </div>
              <!--end::Small Box Widget 3-->
            </div>
          </div>
          <!--end::Row-->
          <!--begin::Row-->
          <!-- Charts Section - Tambahkan setelah row small-box yang sudah ada -->
          <div class="row mt-4">
            <!-- Bar Chart - Siswa per Jurusan -->
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="bi bi-bar-chart me-1"></i>
                    Siswa per Jurusan
                  </h3>
                </div>
                <div class="card-body">
                  <div id="siswa-jurusan-chart" style="height: 300px;"></div>
                </div>
              </div>
            </div>

            <!-- Pie Chart - Overview Data -->
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="bi bi-pie-chart me-1"></i>
                    Overview Data Sekolah
                  </h3>
                </div>
                <div class="card-body">
                  <div id="overview-chart" style="height: 300px;"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <!-- Donut Chart - Siswa per Agama -->
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="bi bi-pie-chart-fill me-1"></i>
                    Siswa per Agama
                  </h3>
                </div>
                <div class="card-body">
                  <div id="siswa-agama-chart" style="height: 300px;"></div>
                </div>
              </div>
            </div>

          </div>
          <!-- /.row (main row) -->
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
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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
  <!--end::OverlayScrollbars Configure-->
  <!-- OPTIONAL SCRIPTS -->
  <!-- sortablejs -->
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
    integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script>
  <!-- sortablejs -->
  <script>
    const connectedSortables = document.querySelectorAll('.connectedSortable');
    connectedSortables.forEach((connectedSortable) => {
      let sortable = new Sortable(connectedSortable, {
        group: 'shared',
        handle: '.card-header',
      });
    });

    const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
    cardHeaders.forEach((cardHeader) => {
      cardHeader.style.cursor = 'move';
    });
  </script>
  <!-- apexcharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
    integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
  <!-- ChartJS -->
  <script>
    // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
    // IT'S ALL JUST JUNK FOR DEMO
    // ++++++++++++++++++++++++++++++++++++++++++

    const sales_chart_options = {
      series: [
        {
          name: 'Digital Goods',
          data: [28, 48, 40, 19, 86, 27, 90],
        },
        {
          name: 'Electronics',
          data: [65, 59, 80, 81, 56, 55, 40],
        },
      ],
      chart: {
        height: 300,
        type: 'area',
        toolbar: {
          show: false,
        },
      },
      legend: {
        show: false,
      },
      colors: ['#0d6efd', '#20c997'],
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: 'smooth',
      },
      xaxis: {
        type: 'datetime',
        categories: [
          '2023-01-01',
          '2023-02-01',
          '2023-03-01',
          '2023-04-01',
          '2023-05-01',
          '2023-06-01',
          '2023-07-01',
        ],
      },
      tooltip: {
        x: {
          format: 'MMMM yyyy',
        },
      },
    };

    const sales_chart = new ApexCharts(
      document.querySelector('#revenue-chart'),
      sales_chart_options,
    );
    sales_chart.render();
  </script>
  <!-- jsvectormap -->
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
    integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
    integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>
  <!-- jsvectormap -->
  <script>
    // Data dari PHP
    const siswaJurusanData = <?php echo json_encode($chartData['siswa_jurusan']); ?>;
    const siswaAgamaData = <?php echo json_encode($chartData['siswa_agama']); ?>;
    const overviewData = <?php echo json_encode($chartData['overview']); ?>;

    // Debug: Tampilkan data di console
    console.log('Siswa Jurusan Data:', siswaJurusanData);
    console.log('Siswa Agama Data:', siswaAgamaData);
    console.log('Overview Data:', overviewData);

    // 1. Bar Chart - Siswa per Jurusan
    const siswaJurusanOptions = {
      series: [{
        name: 'Jumlah Siswa',
        data: siswaJurusanData.map(item => parseInt(item.jumlah_siswa))
      }],
      chart: {
        type: 'bar',
        height: 300,
        toolbar: {
          show: false
        }
      },
      colors: ['#0d6efd'],
      plotOptions: {
        bar: {
          borderRadius: 4,
          horizontal: false,
        }
      },
      dataLabels: {
        enabled: true,
      },
      xaxis: {
        categories: siswaJurusanData.map(item => item.namajurusan),
        labels: {
          rotate: -45
        }
      },
      yaxis: {
        title: {
          text: 'Jumlah Siswa'
        }
      },
      title: {
        text: 'Distribusi Siswa per Jurusan',
        align: 'center'
      }
    };

    const siswaJurusanChart = new ApexCharts(
      document.querySelector('#siswa-jurusan-chart'),
      siswaJurusanOptions
    );
    siswaJurusanChart.render();

    // 2. Pie Chart - Overview Data
    const overviewOptions = {
      series: overviewData.map(item => parseInt(item.value)),
      chart: {
        type: 'pie',
        height: 300
      },
      labels: overviewData.map(item => item.label),
      colors: ['#0d6efd', '#198754', '#ffc107', '#dc3545'],
      legend: {
        position: 'bottom'
      },
      title: {
        text: 'Overview Data Sekolah',
        align: 'center'
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    const overviewChart = new ApexCharts(
      document.querySelector('#overview-chart'),
      overviewOptions
    );
    overviewChart.render();

    // 3. Donut Chart - Siswa per Agama
    // PERBAIKAN: Cek apakah data ada dan tidak kosong
    if (siswaAgamaData && siswaAgamaData.length > 0) {
      const siswaAgamaOptions = {
        series: siswaAgamaData.map(item => parseInt(item.jumlah_siswa)),
        chart: {
          type: 'donut',
          height: 300
        },
        labels: siswaAgamaData.map(item => item.agama), // Sekarang menggunakan 'namaagama'
        colors: ['#20c997', '#fd7e14', '#6f42c1', '#e91e63', '#795548'],
        legend: {
          position: 'bottom'
        },
        title: {
          text: 'Distribusi Siswa per Agama',
          align: 'center'
        },
        plotOptions: {
          pie: {
            donut: {
              size: '50%'
            }
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
      };

      const siswaAgamaChart = new ApexCharts(
        document.querySelector('#siswa-agama-chart'),
        siswaAgamaOptions
      );
      siswaAgamaChart.render();
    } else {
      // Jika tidak ada data, tampilkan pesan
      document.querySelector('#siswa-agama-chart').innerHTML = '<p class="text-center">Data agama tidak tersedia</p>';
    }
  </script>
</body>

</html>