<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

include '../database.php'; 
$kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
$jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
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
              <h1 class="m-0">Tambah Siswa</h1>
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

            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Siswa</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="proses-tambah-siswa.php" method="POST">
                <div class="card-body">
                    <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukkan NIS" required>
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" required>
                  </div>
                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="custom-select" required>
                    <option value=""></option>
                      <option value="Laki-laki">Laki-laki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kelas</label>
                    <select name="id_kelas" class="custom-select" required>
                      <option value="">Pilih Kelas</option>
                      <?php
                      $kelas = mysqli_query($koneksi, "SELECT kelas.*, jurusan.nama_jurusan FROM kelas JOIN jurusan ON kelas.Id_Jurusan = jurusan.Id_Jurusan");
                      while ($k = mysqli_fetch_assoc($kelas)) { ?>
                        <option value="<?= $k['Id_Kelas'] ?>">
                          <?= $k['tingkat'].' '.$k['nama_jurusan'].' '.$k['nomor_kelas'] ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Jurusan</label>
                    <select name="id_jurusan" class="custom-select" required>
                      <option value="">Pilih Jurusan</option>
                      <?php while ($j = mysqli_fetch_assoc($jurusan)) { ?>
                        <option value="<?=$j['Id_Jurusan'] ?>"><?=$j['nama_jurusan']?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="data-siswa.php" class="btn btn-default float-right">Cancel</a>
                  </div>
              </form>
            </div>
            <!-- /.card -->
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
</body>

</html>