<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}
?>
<?php
include '../database.php';
$query = "SELECT 
            kelas.Id_Kelas, 
            kelas.tingkat, 
            kelas.nomor_kelas, 
            jurusan.nama_jurusan,
            (SELECT COUNT(*) FROM siswa WHERE siswa.Id_Kelas = kelas.Id_Kelas) AS jumlah_siswa
          FROM kelas
          JOIN jurusan ON kelas.Id_Jurusan = jurusan.Id_Jurusan";

$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
$no = 1;
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
  <title>Data Kelas</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../theme/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
              <h1 class="m-0">Data Kelas</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <td>
                  <a href="../admin/tambah-kelas.php" class="btn btn-primary">Tambah</a>
                </td>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">

          <div class="card">
            <!-- /.card-header -->
            <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Kelas</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>NO</th>
                      <th>Nama Kelas</th>
                      <th>Jurusan</th>
                      <th>Jumlah Siswa</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
include '../database.php';
$query = "SELECT 
            kelas.Id_Kelas, 
            kelas.tingkat, 
            kelas.nomor_kelas, 
            jurusan.nama_jurusan,
            (SELECT COUNT(*) FROM siswa WHERE siswa.Id_Kelas = kelas.Id_Kelas) AS jumlah_siswa
          FROM kelas
          JOIN jurusan ON kelas.Id_Jurusan = jurusan.Id_Jurusan";

$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
  <td><?= $no++; ?></td>
  <td><?= $row['tingkat'] . ' ' . $row['nama_jurusan'] . ' ' . $row['nomor_kelas']; ?></td>
  <td><?= $row['nama_jurusan']; ?></td>
  <td><?= $row['jumlah_siswa']; ?></td>
  <td>
    <a href="edit-kelas.php?id=<?= $row['Id_Kelas']; ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="hapus.php?id=<?= $row['Id_Kelas']; ?>&type=kelas" class="btn btn-danger btn-sm"
     onclick="return confirm('Yakin ingin menghapus kelas ini?')">Hapus</a>
  </td>
</tr>
<?php } ?>
</tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
            <!-- /.card-body -->
          </div>

          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include '../components/footer.php' ?>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="../theme/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../theme/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../theme/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../theme/plugins/jszip/jszip.min.js"></script>
  <script src="../theme/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../theme/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../theme/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../theme/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../theme/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../theme/dist/js/adminlte.min.js"></script>

  <script>
    $(function () {
      $("#example100").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>

</html>