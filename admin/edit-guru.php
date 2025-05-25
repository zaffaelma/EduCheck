<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}
include '../database.php';

// Ambil data guru berdasarkan id
$id = $_GET['id'];
$query = "SELECT * FROM gurubk WHERE Id_GuruBK = '$id'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data guru tidak ditemukan.");
}

// Proses update jika form disubmit
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $update = mysqli_query($koneksi, "UPDATE gurubk SET 
        nama='$nama', 
        email='$email', 
        jenis_kelamin='$jenis_kelamin'
        WHERE Id_GuruBK='$id'
    ");

    if ($update) {
        header("Location: data-guru.php?msg=update-success");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Update gagal: " . mysqli_error($koneksi) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Guru</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="../theme/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../theme/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include '../components/sidebar.php'; ?>
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid pt-4">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Data Guru</h3>
              </div>
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($data['email']) ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                      <option value="Laki-laki" <?= $data['jenis_kelamin']=='Laki-laki'?'selected':''; ?>>Laki-laki</option>
                      <option value="Perempuan" <?= $data['jenis_kelamin']=='Perempuan'?'selected':''; ?>>Perempuan</option>
                    </select>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                  <a href="data-guru.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<!-- AdminLTE JS -->
<script src="../theme/plugins/jquery/jquery.min.js"></script>
<script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../theme/dist/js/adminlte.min.js"></script>
</body>
</html>