<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Guest';
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="../theme/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">EduCheck</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../theme/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $email ?></a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               
            <!-- Sidebar Admin -->
            <?php if ($role === 'admin'): ?>
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="../admin/dashboard.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../admin/data-guru.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Guru</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../admin/data-jurusan.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Jurusan</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../admin/data-kelas.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Kelas</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../admin/data-siswa.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Siswa</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../admin/profile.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Profile</p>
                    </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Sidebar Guru -->
            <?php if ($role === 'guru'): ?>
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="../guru/dashboard.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../guru/persetujuan-izin.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Persetujuan Izin</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../guru/riwayat-absensi.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Riwayat Absensi</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../guru/profile.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Profile</p>
                    </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Sidebar Siswa -->
            <?php if ($role === 'siswa'): ?>
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="../siswa/dashboard.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../siswa/riwayat-absensi.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Riwayat Absensi</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="../siswa/profile.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Profile</p>
                    </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <li class="nav-item">
              <a href="logout.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Logout Here
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->

      <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->
</aside>