<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

include '../database.php';

// Query for counting the number of teachers
$query_guru = mysqli_query($koneksi, "SELECT COUNT(*) AS total_guru FROM gurubk");
$data_guru = mysqli_fetch_assoc($query_guru);

// Query for counting the number of departments
$query_jurusan = mysqli_query($koneksi, "SELECT COUNT(*) AS total_jurusan FROM jurusan");
$data_jurusan = mysqli_fetch_assoc($query_jurusan);

// Query for counting the number of classes
$query_kelas = mysqli_query($koneksi, "SELECT COUNT(*) AS total_kelas FROM kelas");
$data_kelas = mysqli_fetch_assoc($query_kelas);

// Query for counting the number of students
$query_siswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total_siswa FROM siswa");
$data_siswa = mysqli_fetch_assoc($query_siswa);

$tanggal_hari_ini = date('Y-m-d');

$query_hadir = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM absensi WHERE status_absensi = 'Hadir' AND tanggal_absensi = '$tanggal_hari_ini'");
$data_hadir = mysqli_fetch_assoc($query_hadir)['total'];

$query_izin = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM absensi WHERE status_absensi = 'Izin' AND tanggal_absensi = '$tanggal_hari_ini'");
$data_izin = mysqli_fetch_assoc($query_izin)['total'];

$query_sakit = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM absensi WHERE status_absensi = 'Sakit' AND tanggal_absensi = '$tanggal_hari_ini'");
$data_sakit = mysqli_fetch_assoc($query_sakit)['total'];

$query_alpha = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM absensi WHERE status_absensi = 'Alpha' AND tanggal_absensi = '$tanggal_hari_ini'");
$data_alpha = mysqli_fetch_assoc($query_alpha)['total'];
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

        <!-- box -->
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
              <div class="card-body d-flex align-items-center">
                <i class="fas fa-chalkboard-teacher fa-2x mr-3"></i>
                <div>
                  <div>Jumlah Guru</div>
                  <h4><?= $data_guru['total_guru']; ?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
              <div class="card-body d-flex align-items-center">
                <i class="fas fa-graduation-cap fa-2x mr-3"></i>
                <div>
                  <div>Jumlah Jurusan</div>
                  <h4><?= $data_jurusan['total_jurusan']; ?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
              <div class="card-body d-flex align-items-center">
                <i class="fas fa-door-open fa-2x mr-3"></i>
                <div>
                  <div>Jumlah Kelas</div>
                  <h4><?= $data_kelas['total_kelas']; ?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white">
              <div class="card-body d-flex align-items-center">
                <i class="fas fa-users fa-2x mr-3"></i>
                <div>
                  <div>Jumlah Siswa</div>
                  <h4><?= $data_siswa['total_siswa']; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- box -->

        <!-- Row untuk tabel dan pie chart -->
        <div class="row">
          <!-- Kolom untuk tabel -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Presensi Hari Ini</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">NO</th>
                      <th>Keterangan</th>
                      <th style="width: 40px">Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1.</td>
                      <td>Siswa Hadir</td>
                      <td><span class="badge bg-success"><?= $data_hadir ?></span></td>
                    </tr>
                    <tr>
                      <td>2.</td>
                      <td>Izin</td>
                      <td><span class="badge bg-primary"><?= $data_izin ?></span></td>
                    </tr>
                    <tr>
                      <td>3.</td>
                      <td>Sakit</td>
                      <td><span class="badge bg-warning"><?= $data_sakit ?></span></td>
                    </tr>
                    <tr>
                      <td>4.</td>
                      <td>Alfa</td>
                      <td><span class="badge bg-danger"><?= $data_alpha ?></span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->

          <!-- Kolom untuk pie chart -->
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pie Chart Kehadiran Siswa Hari Ini</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

          <!-- /.row -->
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    $(function () {
      $("#example100").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>

  <script>
  const pieChartCanvas = document.getElementById('pieChart').getContext('2d');
  new Chart(pieChartCanvas, {
    type: 'pie',
    data: {
      labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
      datasets: [{
        data: [<?= $data_hadir ?>, <?= $data_izin ?>, <?= $data_sakit ?>, <?= $data_alpha ?>],
        backgroundColor: ['#28a745', '#007bff', '#ffc107', '#dc3545']
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',
        }
      }
    }
  });
</script>

</body>

</html>