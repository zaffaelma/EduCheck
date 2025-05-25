<?php
// filepath: c:\xampp1\htdocs\EduCheck\admin\edit-kelas.php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}
include '../database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kelas WHERE Id_Kelas = '$id'"));
$jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");

if (isset($_POST['submit'])) {
  $tingkat = $_POST['tingkat'];
  $id_jurusan = $_POST['id_jurusan'];
  $nomor_kelas = $_POST['nomor_kelas'];

  $query = "UPDATE kelas SET tingkat='$tingkat', Id_Jurusan='$id_jurusan', nomor_kelas='$nomor_kelas' WHERE Id_Kelas='$id'";
  if (mysqli_query($koneksi, $query)) {
    header("Location: data-kelas.php?msg=edit-sukses");
    exit;
  } else {
    $error = "Gagal mengedit kelas: " . mysqli_error($koneksi);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Kelas</title>
  <link rel="stylesheet" href="../theme/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include '../components/sidebar.php'; ?>
  <div class="content-wrapper">
    <section class="content pt-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Kelas</h3>
              </div>
              <form method="POST">
                <div class="card-body">
                  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                  <div class="form-group">
                    <label>Tingkat</label>
                    <input type="text" name="tingkat" class="form-control" value="<?= htmlspecialchars($data['tingkat']) ?>" required>
                  </div>
                  <div class="form-group">
                    <label>Jurusan</label>
                    <select name="id_jurusan" class="form-control" required>
                      <option value="">Pilih Jurusan</option>
                      <?php while ($j = mysqli_fetch_assoc($jurusan)) : ?>
                        <option value="<?= $j['Id_Jurusan'] ?>" <?= $j['Id_Jurusan']==$data['Id_Jurusan']?'selected':''; ?>>
                          <?= $j['nama_jurusan'] ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Nomor Kelas</label>
                    <input type="number" name="nomor_kelas" class="form-control" value="<?= htmlspecialchars($data['nomor_kelas']) ?>" required>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                  <a href="data-kelas.php" class="btn btn-secondary">Batal</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<script src="../theme/plugins/jquery/jquery.min.js"></script>
<script src="../theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../theme/dist/js/adminlte.min.js"></script>
</body>
</html>