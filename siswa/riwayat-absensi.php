<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'siswa') {
  header("Location: login.php");
  exit;
}
include '../database.php';
$id_siswa = $_SESSION['id_siswa'];

// Query untuk mengambil data absensi siswa
$query = "
  SELECT tanggal_absensi, status_absensi
  FROM absensi
  WHERE id_siswa = '$id_siswa'
  ORDER BY tanggal_absensi DESC
";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Absensi</title>

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
              <h1 class="m-0">Riwayat Absensi</h1>
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
              <h3 class="card-title">Riwayat Absensi Anda</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="riwayat-absensi" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$no}</td>";
                    echo "<td>{$row['tanggal_absensi']}</td>";
                    echo "<td>" . ucfirst($row['status_absensi']) . "</td>";
                    echo "</tr>";
                    $no++;
                  }
                  ?>
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
  <!-- jQuery -->
  <script src="../theme/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../theme/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../theme/dist/js/adminlte.min.js"></script>

  <script>
    $(function () {
      $("#riwayat-absensi").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": false // Menonaktifkan fitur search
      });
    });
  </script>
</body>

</html>