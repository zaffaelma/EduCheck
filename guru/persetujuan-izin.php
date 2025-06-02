<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'guru') {
  header("Location: login.php");
  exit;
}
include '../database.php';
$id_gurubk = $_SESSION['id_gurubk'];

// Ambil data izin/sakit yang belum disetujui dari kelas yang dikelola guru ini
$query = "
  SELECT 
      a.Id_Absensi, s.nama, k.tingkat, j.nama_jurusan, k.nomor_kelas, 
      a.status_absensi, a.bukti_absensi, a.keterangan_absensi
  FROM absensi a
  JOIN siswa s ON a.id_siswa = s.Id_Siswa
  JOIN kelas k ON s.Id_Kelas = k.Id_Kelas
  JOIN jurusan j ON k.Id_Jurusan = j.Id_Jurusan
  JOIN guru_kelas gk ON k.Id_Kelas = gk.Id_Kelas
  WHERE gk.Id_GuruBK = '$id_gurubk'
    AND (a.status_absensi = 'izin' OR a.status_absensi = 'sakit')
    AND a.persetujuan = 'belum'
  ORDER BY a.tanggal_absensi DESC
";

$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

// Proses persetujuan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_absensi'], $_POST['aksi'])) {
    $id_absensi = intval($_POST['id_absensi']);
    $aksi = $_POST['aksi'];
    if ($aksi == 'setuju') {
        // Setujui, status absensi tetap sesuai input siswa, persetujuan = 'disetujui'
        mysqli_query($koneksi, "UPDATE absensi SET persetujuan='disetujui' WHERE Id_Absensi='$id_absensi'");
    } else if ($aksi == 'tolak') {
        // Tolak, update status_absensi jadi 'Alfa', persetujuan = 'ditolak'
        mysqli_query($koneksi, "UPDATE absensi SET status_absensi='Alfa', persetujuan='ditolak' WHERE Id_Absensi='$id_absensi'");
    }
    header("Location: persetujuan-izin.php");
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
  <title>Persetujuan Izin</title>

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
              <h1 class="m-0">Persetujuan Izin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <!-- <ol class="breadcrumb float-sm-right">
                <td>
                  <a href="../admin/tambah-jurusan.php" class="btn btn-primary">Persetujuan Izin</a>
                </td>
              </ol> -->
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
                <h3 class="card-title">Persetujuan Izin</h3>

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
                      <th>Nama</th>
                      <th>Kelas</th>
                      <th>Status</th>
                      <th>Bukti</th>
                      <th>Keterangan</th>
                      <th>Persetujuan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                      $kelas = $row['tingkat'] . ' ' . $row['nama_jurusan'] . ' ' . $row['nomor_kelas'];
                      echo "<tr>";
                      echo "<td>{$no}</td>";
                      echo "<td>{$row['nama']}</td>";
                      echo "<td>{$kelas}</td>";
                      echo "<td>" . ucfirst($row['status_absensi']) . "</td>";
                      echo "<td>";
                      if ($row['bukti_absensi']) {
                        echo "<a href='../siswa/uploads/{$row['bukti_absensi']}' target='_blank'>Lihat Bukti</a>";
                      } else {
                        echo "-";
                      }
                      echo "</td>";
                      echo "<td>{$row['keterangan_absensi']}</td>";
                      echo "<td>
                        <form method='post' style='display:inline'>
                          <input type='hidden' name='id_absensi' value='{$row['Id_Absensi']}'>
                          <button type='submit' name='aksi' value='setuju' class='btn btn-success btn-sm'>Setujui</button>
                          <button type='submit' name='aksi' value='tolak' class='btn btn-danger btn-sm'>Tolak</button>
                        </form>
                      </td>";
                      echo "</tr>";
                      $no++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <strong>Copyright &copy; 2020-2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../theme/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../theme/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 4 -->
  <script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../theme/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../theme/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../theme/dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true,
        "searching": true,
        "pageLength": 10,
        "language": {
          "emptyTable": "Tidak ada data yang tersedia di tabel",
          "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
          "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
          "infoFiltered": "(disaring dari _MAX_ total entri)",
          "lengthMenu": "Tampilkan _MENU_ entri",
          "loadingRecords": "Sedang memuat...",
          "processing": "Sedang diproses...",
          "search": "Cari:",
          "zeroRecords": "Tidak ada entri yang cocok ditemukan",
          "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Selanjutnya",
            "previous": "Sebelumnya"
          }
        }
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>

</html>