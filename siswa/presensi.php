<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'siswa') {
  header("Location: login.php");
  exit;
}
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
  <title>Dashboard</title>

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
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

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
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <!-- <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
              </ol> -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
        <h4 class="mb-4">Absensi Siswa</h4>

        <!-- Button Hadir -->
        <div class="mb-3">
            <button class="btn btn-success btn-lg btn-block" onclick="showHadir()">Hadir</button>
            <div id="hadir-container" class="mt-3" style="display: none;">
                <form action="proses-presensi.php" method="post">
                <input type="hidden" name="status" value="hadir">
                <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                </form>
            </div>
        </div>

        <!-- Button Sakit -->
        <div class="mb-3">
            <button class="btn btn-danger btn-lg btn-block" onclick="showSakit()">Sakit</button>
            <div id="sakit-container" class="mt-3" style="display: none;">
                <form action="proses-presensi.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="status" value="sakit">
                <div class="form-group">
                    <label for="sakit-file">Upload Surat Keterangan Sakit:</label>
                    <input type="file" class="form-control" id="sakit-file" name="file" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                </form>
            </div>
        </div>

        <!-- Button Izin -->
        <div class="mb-3">
            <button class="btn btn-warning btn-lg btn-block" onclick="showIzin()">Izin</button>
            <div id="izin-container" class="mt-3" style="display: none;">
                <form action="proses-presensi.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="status" value="izin">
                <div class="form-group">
                    <label for="izin-file">Upload Surat Izin:</label>
                    <input type="file" class="form-control" id="izin-file" name="file" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                </form>
            </div>
        </div>

        </div>
        <!-- /.container-fluid -->
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

  <!-- Status Presensi -->
  <script>
    function showHadir() {
        document.getElementById('hadir-container').style.display = 'block';
        document.getElementById('sakit-container').style.display = 'none';
        document.getElementById('izin-container').style.display = 'none';
    }

    function showSakit() {
        document.getElementById('hadir-container').style.display = 'none';
        document.getElementById('sakit-container').style.display = 'block';
        document.getElementById('izin-container').style.display = 'none';
    }

    function showIzin() {
        document.getElementById('hadir-container').style.display = 'none';
        document.getElementById('sakit-container').style.display = 'none';
        document.getElementById('izin-container').style.display = 'block';
    }
</script>
</body>

</html>