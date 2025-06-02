<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

include '../database.php';

// Ambil daftar kelas untuk dropdown
$kelas_query = "SELECT Id_Kelas, tingkat, nomor_kelas, nama_jurusan FROM kelas JOIN jurusan ON kelas.Id_Jurusan = jurusan.Id_Jurusan";
$kelas_result = mysqli_query($koneksi, $kelas_query);

// Filter kelas
$id_kelas = isset($_GET['kelas']) ? intval($_GET['kelas']) : 0;

// Query untuk mengambil data siswa berdasarkan kelas
$query = "
  SELECT siswa.*, kelas.tingkat, kelas.nomor_kelas, jurusan.nama_jurusan 
  FROM siswa 
  JOIN kelas ON siswa.Id_Kelas = kelas.Id_Kelas 
  JOIN jurusan ON siswa.Id_Jurusan = jurusan.Id_Jurusan
";
if ($id_kelas > 0) {
  $query .= " WHERE siswa.Id_Kelas = $id_kelas";
}
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Siswa</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../theme/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../theme/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include '../components/navbar.php' ?>
    <?php include '../components/sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Data Siswa</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <td>
                  <a href="../admin/tambah-siswa.php" class="btn btn-primary">Tambah</a>
                </td>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Siswa</h3>
              <div class="card-tools">
                <!-- Dropdown untuk memilih kelas -->
                <form method="GET" action="data-siswa.php">
                  <select name="kelas" class="form-control" onchange="this.form.submit()">
                    <option value="0">Semua Kelas</option>
                    <?php while ($kelas = mysqli_fetch_assoc($kelas_result)) { ?>
                      <option value="<?= $kelas['Id_Kelas'] ?>" <?= $id_kelas == $kelas['Id_Kelas'] ? 'selected' : '' ?>>
                        <?= $kelas['tingkat'] . ' ' . $kelas['nama_jurusan'] . ' ' . $kelas['nomor_kelas'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </form>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Email</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $row['nis']; ?></td>
                      <td><?= $row['nama']; ?></td>
                      <td><?= $row['tingkat'] . ' ' . $row['nama_jurusan'] . ' ' . $row['nomor_kelas']; ?></td>
                      <td><?= $row['nama_jurusan']; ?></td>
                      <td><?= $row['email']; ?></td>
                      <td>
                        <a href="edit-siswa.php?id=<?= $row['Id_Siswa']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?id=<?= $row['Id_Siswa']; ?>&type=siswa" class="btn btn-danger btn-sm"
                          onclick="return confirm('Yakin ingin menghapus siswa ini?')">Hapus</a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include '../components/footer.php' ?>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <script src="../theme/plugins/jquery/jquery.min.js"></script>
  <script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../theme/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../theme/dist/js/adminlte.min.js"></script>
</body>

</html>