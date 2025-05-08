<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'guru') {
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

          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>1400</h3>

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
                  <h3>53</h3>

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
                  <h3>44</h3>

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
                  <h3>16</h3>

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
                  <option value="X" <?php echo (isset($_GET['kelas']) && $_GET['kelas'] == 'X') ? 'selected' : ''; ?>>X</option>
                  <option value="XI" <?php echo (isset($_GET['kelas']) && $_GET['kelas'] == 'XI') ? 'selected' : ''; ?>>XI</option>
                  <option value="XII" <?php echo (isset($_GET['kelas']) && $_GET['kelas'] == 'XII') ? 'selected' : ''; ?>>XII</option>
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
                    // Contoh data dummy (ganti dengan data dari database)
                    $riwayat = [
                      ['no' => 1, 'nama' => 'John Doe', 'kelas' => 'X', 'tanggal' => '2025-05-01', 'status' => 'Hadir'],
                      ['no' => 2, 'nama' => 'Jane Smith', 'kelas' => 'XI', 'tanggal' => '2025-05-02', 'status' => 'Sakit'],
                      ['no' => 3, 'nama' => 'Alice Johnson', 'kelas' => 'XII', 'tanggal' => '2025-05-03', 'status' => 'Izin'],
                    ];

                    foreach ($riwayat as $row) {
                      if ($row['kelas'] == $_GET['kelas'] && $row['tanggal'] == $_GET['tanggal']) {
                        echo "<tr>";
                        echo "<td>{$row['no']}</td>";
                        echo "<td>{$row['nama']}</td>";
                        echo "<td>{$row['kelas']}</td>";
                        echo "<td>{$row['tanggal']}</td>";
                        echo "<td>
                                <form method='POST' action='update-absensi.php'>
                                  <input type='hidden' name='id' value='{$row['no']}'>
                                  <select name='status' class='form-control'>
                                    <option value='Hadir' " . ($row['status'] == 'Hadir' ? 'selected' : '') . ">Hadir</option>
                                    <option value='Sakit' " . ($row['status'] == 'Sakit' ? 'selected' : '') . ">Sakit</option>
                                    <option value='Izin' " . ($row['status'] == 'Izin' ? 'selected' : '') . ">Izin</option>
                                    <option value='Alfa' " . ($row['status'] == 'Alfa' ? 'selected' : '') . ">Alfa</option>
                                  </select>
                              </td>";
                        echo "<td><button type='submit' class='btn btn-success btn-sm'>Simpan</button></form></td>";
                        echo "</tr>";
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