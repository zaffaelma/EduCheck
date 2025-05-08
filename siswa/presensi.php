
<?php
session_start();
$email = $_SESSION['email'];
if (!isset($email)) {
  header("Location: login.php");
  exit;
}
$current_page = 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Google Font & Icons -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../theme/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../theme/dist/css/adminlte.min.css">

  <style>
    .form-buttons {
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-top: 20px;
    }
    .btn-lg {
      width: 50%;
    }
    .upload-container {
      display: none;
      margin-top: 10px;
      width: 50%;
    }
    .upload-container input[type="file"] {
      margin-bottom: 10px;
      width: 100%;
    }
    .kirim-container {
      display: none;
      margin-top: 10px;
      width: 50%;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include '../components/navbar.php'; ?>
    <?php include '../components/sidebar.php'; ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mt-5">
            <div class="col-md-4 offset-md-1 px-5 padding-top: 20px">
              <h3 class="mb-4">Presensi Hari Ini</h3>

              <div class="form-buttons">

                <!-- HADIR -->
                <form action="proses_presensi.php" method="post" id="hadir-form">
                  <input type="hidden" name="status" value="hadir">
                  <button type="button"
                          class="btn btn-success btn-lg"
                          onclick="showKirimHadir()">
                    Hadir
                  </button>
                  <div id="hadir-kirim" class="kirim-container">
                    <button type="submit" class="btn btn-primary btn-lg">Kirim</button>
                  </div>
                </form>

                <!-- IZIN -->
                <form action="proses_presensi.php" method="post" enctype="multipart/form-data" id="izin-form">
                  <input type="hidden" name="status" value="ijin">
                  <button type="button"
                          class="btn btn-warning btn-lg"
                          onclick="toggleUpload('izin')">
                    Izin
                  </button>
                  <div class="upload-container" id="upload-izin">
                    <input type="file" id="file-izin" name="bukti" class="form-control" required>
                    <button type="submit" id="btn-kirim-izin" class="btn btn-primary btn-lg" disabled>
                      Kirim
                    </button>
                  </div>
                </form>

                <!-- SAKIT -->
                <form action="proses_presensi.php" method="post" enctype="multipart/form-data" id="sakit-form">
                  <input type="hidden" name="status" value="sakit">
                  <button type="button"
                          class="btn btn-danger btn-lg"
                          onclick="toggleUpload('sakit')">
                    Sakit
                  </button>
                  <div class="upload-container" id="upload-sakit">
                    <input type="file" id="file-sakit" name="bukti" class="form-control" required>
                    <button type="submit" id="btn-kirim-sakit" class="btn btn-primary btn-lg" disabled>
                      Kirim
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include '../components/footer.php'; ?>
  </div>

  <!-- SCRIPTS -->
  <script src="../theme/plugins/jquery/jquery.min.js"></script>
  <script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../theme/dist/js/adminlte.min.js"></script>
  <script>
    function showKirimHadir() {
      // sembunyikan semua upload
      document.getElementById('upload-izin').style.display = 'none';
      document.getElementById('upload-sakit').style.display = 'none';
      // tampilkan tombol Kirim Hadir
      document.getElementById('hadir-kirim').style.display = 'block';
    }

    function toggleUpload(type) {
      // sembunyikan tombol Kirim Hadir
      document.getElementById('hadir-kirim').style.display = 'none';
      // sembunyikan semua upload
      document.getElementById('upload-izin').style.display = 'none';
      document.getElementById('upload-sakit').style.display = 'none';
      // tampilkan yang sesuai
      if (type === 'izin') {
        document.getElementById('upload-izin').style.display = 'block';
      } else {
        document.getElementById('upload-sakit').style.display = 'block';
      }
    }

    // Aktifkan tombol Kirim hanya setelah file dipilih
    document.addEventListener('DOMContentLoaded', function() {
      var fileIzin   = document.getElementById('file-izin');
      var btnIzin    = document.getElementById('btn-kirim-izin');
      fileIzin.addEventListener('change', function() {
        btnIzin.disabled = this.files.length === 0;
      });

      var fileSakit  = document.getElementById('file-sakit');
      var btnSakit   = document.getElementById('btn-kirim-sakit');
      fileSakit.addEventListener('change', function() {
        btnSakit.disabled = this.files.length === 0;
      });
    });
  </script>
</body>
</html>
