<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}
include '../database.php';

// Ambil data jurusan untuk dropdown
$jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");

if (isset($_POST['submit'])) {
  $tingkat = $_POST['tingkat'];
  $id_jurusan = $_POST['id_jurusan'];
  $nomor_kelas = $_POST['nomor_kelas'];

  $query = "INSERT INTO kelas (tingkat, Id_Jurusan, nomor_kelas) VALUES ('$tingkat', '$id_jurusan', '$nomor_kelas')";
  if (mysqli_query($koneksi, $query)) {
    header("Location: data-kelas.php?msg=sukses");
    exit;
  } else {
    $error = "Gagal menambah kelas: " . mysqli_error($koneksi);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Kelas</title>
  <link rel="stylesheet" href="../theme/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../theme/plugins/fontawesome-free/css/all.min.css">
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
              <h1 class="m-0">Tambah Kelas</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Tambah Kelas</h3>
            </div>
            <form method="post">
              <div class="card-body">
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <div class="form-group">
                  <label for="tingkat">Tingkat</label>
                  <select class="form-control" id="tingkat" name="tingkat" required>
                    <option value="">-- Pilih Tingkat --</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="id_jurusan">Pilih Jurusan</label>
                  <select class="form-control" id="id_jurusan" name="id_jurusan" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <?php while ($row = mysqli_fetch_assoc($jurusan)) { ?>
                    <option value="<?= $row['Id_Jurusan']; ?>"><?= $row['nama_jurusan']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="nomor_kelas">Nomor Kelas</label>
                  <select class="form-control" id="nomor_kelas" name="nomor_kelas" required>
                    <option value="">-- Pilih Nomor --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                <a href="data-kelas.php" class="btn btn-secondary float-right">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include '../components/footer.php' ?>
  </div>
  <script src="../theme/plugins/jquery/jquery.min.js"></script>
  <script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../theme/dist/js/adminlte.min.js"></script>
</body>

</html>