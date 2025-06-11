<!--begin::Sidebar-->
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
          <a href="../index/dashboard.php" class="nav-link active">
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