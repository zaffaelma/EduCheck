<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'guru') {
  header("Location: login.php");
  exit;
}

if (isset($_SESSION['message'])) {
  echo '<div class="alert alert-info" style="margin:10px;">' . $_SESSION['message'] . '</div>';
  unset($_SESSION['message']);
}

include '../test-koneksi.php';

$query = "SELECT 
            a.id_absensi,
            s.nama_siswa,
            k.nama_kelas,
            a.keterangan_absensi,
            a.bukti_absensi,
            a.status_absensi
          FROM absensi a
          JOIN siswa s ON a.id_siswa = s.id
          JOIN kelas k ON s.kelas_id = k.id
          WHERE a.keterangan_absensi IN ('Izin', 'Sakit')
          ORDER BY a.id_absensi DESC";

$result = mysqli_query($conn, $query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Persetujuan Izin</title>

  <!-- Styles -->
  <link rel="stylesheet" href="../theme/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../theme/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include '../components/navbar.php' ?>
    <?php include '../components/sidebar.php' ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Persetujuan Izin</h1>
            </div>
          </div>
        </div>
      </div>

      <div class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Persetujuan Izin</h3>
                    <div class="card-tools">
                      <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>Nama</th>
                          <th>Kelas</th>
                          <th>Status</th>
                          <th>Bukti</th>
                          <th>Persetujuan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                            <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                            <td><?= htmlspecialchars($row['keterangan_absensi']) ?></td>
                            <td>
                              <?php if ($row['bukti_absensi']) { ?>
                                <a href="../uploads/<?= $row['bukti_absensi'] ?>" target="_blank">Lihat Bukti</a>
                              <?php } else { ?>
                                Tidak Ada
                              <?php } ?>
                            </td>
                            <td>
                              <?php if ($row['status_absensi'] == 'Pending') { ?>
                                <form method="post" action="setujui.php" style="display:inline;">
                                  <input type="hidden" name="id" value="<?= $row['id_absensi'] ?>">
                                  <input type="hidden" name="aksi" value="setuju">
                                  <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                    <i class="fas fa-check"></i>
                                  </button>
                                </form>

                                <form method="post" action="setujui.php" style="display:inline;">
                                  <input type="hidden" name="id" value="<?= $row['id_absensi'] ?>">
                                  <input type="hidden" name="aksi" value="tolak">
                                  <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                    <i class="fas fa-times"></i>
                                  </button>
                                </form>
                              <?php } else { ?>
                                <?= htmlspecialchars($row['status_absensi']) ?>
                              <?php } ?>
                            </td>

                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include '../components/footer.php' ?>
  </div>

  <!-- Scripts -->
  <script src="../theme/plugins/jquery/jquery.min.js"></script>
  <script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../theme/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../theme/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../theme/dist/js/adminlte.min.js"></script>
</body>

</html>