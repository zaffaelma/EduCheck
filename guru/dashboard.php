<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'guru') {
  header("Location: login.php");
  exit;
}
if (!isset($_SESSION['id_gurubk'])) {
    die("Session id_gurubk belum di-set. Silakan login ulang.");
}
$id_gurubk = $_SESSION['id_gurubk'];
include '../database.php'; 

// Query absensi (kotak statistik)
$query = "
    SELECT 
        SUM(CASE WHEN a.status_absensi = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN a.status_absensi = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN a.status_absensi = 'Izin' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN a.status_absensi = 'Alfa' THEN 1 ELSE 0 END) AS alfa
    FROM absensi a
    JOIN siswa s ON a.id_siswa = s.Id_Siswa
    JOIN kelas k ON s.Id_Kelas = k.Id_Kelas
    JOIN guru_kelas gk ON k.Id_Kelas = gk.Id_Kelas
    WHERE gk.Id_GuruBK = '$id_gurubk'
";
$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
$data = mysqli_fetch_assoc($result);
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

          <!-- Small boxes (Stat box) -->
          <div class="row">
            <?php
            $id_guru = $_SESSION['id_gurubk']; // Pastikan session id_guru sudah di-set saat login
            $query = "
                SELECT 
                    SUM(CASE WHEN a.status_absensi = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
                    SUM(CASE WHEN a.status_absensi = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
                    SUM(CASE WHEN a.status_absensi = 'Izin' THEN 1 ELSE 0 END) AS izin,
                    SUM(CASE WHEN a.status_absensi = 'Alfa' THEN 1 ELSE 0 END) AS alfa
                FROM absensi a
                JOIN siswa s ON a.id_siswa = s.Id_Siswa
                JOIN kelas k ON s.Id_Kelas = k.Id_Kelas
                JOIN guru_kelas gk ON k.Id_Kelas = gk.Id_Kelas
                WHERE gk.Id_GuruBK = '$id_gurubk'
            ";
            $result = mysqli_query($koneksi, $query);
            if (!$result) {
                die("Query error: " . mysqli_error($koneksi));
            }
            $data = mysqli_fetch_assoc($result);
            ?>

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3><?= $data['hadir'] ?? 0; ?></h3>

                  <p>Hadir</p>
                </div>

                <div class="icon">
                  <i class="fas fa-school"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?= $data['sakit'] ?? 0; ?></h3>

                  <p>Sakit</p>
                </div>
                <div class="icon">
                  <i class="fas fa-stethoscope"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $data['izin'] ?? 0; ?></h3>

                  <p>Izin</p>
                </div>
                <div class="icon">
                  <i class="fas fa-envelope"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?= $data['alfa'] ?? 0; ?></h3>

                  <p>Alfa</p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-minus"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->

          <!-- Form untuk memilih kelas dan tanggal -->
          <form method="GET" action="">
            <div class="row mb-4">
              <div class="col-md-4">
                <label for="kelas">Pilih Kelas:</label>
                <select class="form-control" id="kelas" name="kelas" required>
                  <option value="">-- Pilih Kelas --</option>
                  <?php
                  $kelasQ = mysqli_query($koneksi, "
                      SELECT k.Id_Kelas, k.tingkat, j.nama_jurusan, k.nomor_kelas 
                      FROM guru_kelas gk
                      JOIN kelas k ON gk.Id_Kelas = k.Id_Kelas
                      JOIN jurusan j ON k.Id_Jurusan = j.Id_Jurusan
                      WHERE gk.Id_GuruBK = '$id_gurubk'
                      ORDER BY k.tingkat, j.nama_jurusan, k.nomor_kelas
                  ");
                  while ($k = mysqli_fetch_assoc($kelasQ)) {
                      $label = $k['tingkat'].' '.$k['nama_jurusan'].' '.$k['nomor_kelas'];
                      $selected = (isset($_GET['kelas']) && $_GET['kelas'] == $k['Id_Kelas']) ? 'selected' : '';
                      echo "<option value='{$k['Id_Kelas']}' $selected>$label</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="tanggal">Pilih Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>" required>
              </div>
              <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
              </div>
            </div>
          </form>
          <!-- Form -->

            <!-- Tabel Riwayat Absensi -->
            <?php if (isset($_GET['kelas']) && isset($_GET['tanggal'])): ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Absensi Kelas <?php echo htmlspecialchars($_GET['kelas']); ?> - Tanggal <?php echo htmlspecialchars($_GET['tanggal']); ?></h3>
              </div>
              <div class="card-body">
                <table id="riwayat-absensi" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Kelas</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_GET['kelas']) && isset($_GET['tanggal'])) {
                      $id_kelas = $_GET['kelas'];
                      $tanggal = $_GET['tanggal'];
                      $query = "SELECT a.id_absensi, s.nama, k.tingkat, j.nama_jurusan, k.nomor_kelas, a.status_absensi
                                FROM absensi a
                                JOIN siswa s ON a.id_siswa = s.Id_Siswa
                                JOIN kelas k ON s.Id_Kelas = k.Id_Kelas
                                JOIN jurusan j ON k.Id_Jurusan = j.Id_Jurusan
                                WHERE k.Id_Kelas = '$id_kelas' AND a.tanggal_absensi = '$tanggal'
                                ORDER BY s.nama";
                      $result = mysqli_query($koneksi, $query);
                      $no = 1;
                      while ($row = mysqli_fetch_assoc($result)) {
                        $kelasLengkap = $row['tingkat'].' '.$row['nama_jurusan'].' '.$row['nomor_kelas'];
                        echo "<tr>
                                <td>$no</td>
                                <td>{$row['nama']}</td>
                                <td>{$kelasLengkap}</td>
                                <td>{$tanggal}</td>
                                <td>{$row['status_absensi']}</td>
                                <td>-</td>
                              </tr>";
                        $no++;
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?php endif; ?>
            
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