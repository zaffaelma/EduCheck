<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}
include '../database.php';

$id = $_GET['id'];
// Ambil data siswa
$siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE Id_Siswa = '$id'"));
// Ambil data kelas & jurusan untuk dropdown
$kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
$jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");

if (isset($_POST['submit'])) {
  $nis = $_POST['nis'];
  $nama = $_POST['nama'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $id_kelas = $_POST['id_kelas'];
  $id_jurusan = $_POST['id_jurusan'];
  $email = $_POST['email'];
  $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $siswa['password'];

  $query = "UPDATE siswa SET 
              nis='$nis', 
              nama='$nama', 
              jenis_kelamin='$jenis_kelamin', 
              Id_Kelas='$id_kelas', 
              Id_Jurusan='$id_jurusan', 
              email='$email', 
              password='$password'
            WHERE Id_Siswa='$id'";
  if (mysqli_query($koneksi, $query)) {
    header("Location: data-siswa.php?msg=edit-sukses");
    exit;
  } else {
    $error = "Gagal mengedit siswa: " . mysqli_error($koneksi);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Siswa</title>
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
        <h1 class="m-0">Edit Siswa</h1>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Data Siswa</h3>
          </div>
          <form method="POST">
            <div class="card-body">
              <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
              <div class="form-group">
                <label for="nis">NIS</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?= htmlspecialchars($siswa['nis']) ?>" required>
              </div>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required>
              </div>
              <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                  <option value="Laki-laki" <?= $siswa['jenis_kelamin']=='Laki-laki'?'selected':''; ?>>Laki-laki</option>
                  <option value="Perempuan" <?= $siswa['jenis_kelamin']=='Perempuan'?'selected':''; ?>>Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label>Kelas</label>
                <select name="id_kelas" class="form-control" required>
                  <?php
                  // Ambil data kelas beserta jurusan
                  $kelas = mysqli_query($koneksi, "SELECT kelas.*, jurusan.nama_jurusan FROM kelas JOIN jurusan ON kelas.Id_Jurusan = jurusan.Id_Jurusan");
                  while ($k = mysqli_fetch_assoc($kelas)) { ?>
                    <option value="<?= $k['Id_Kelas'] ?>" <?= $k['Id_Kelas']==$siswa['Id_Kelas']?'selected':''; ?>>
                      <?= $k['tingkat'].' '.$k['nama_jurusan'].' '.$k['nomor_kelas'] ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Jurusan</label>
                <select name="id_jurusan" class="form-control" required>
                  <?php while ($j = mysqli_fetch_assoc($jurusan)) { ?>
                    <option value="<?= $j['Id_Jurusan'] ?>" <?= $j['Id_Jurusan']==$siswa['Id_Jurusan']?'selected':''; ?>>
                      <?= $j['nama_jurusan'] ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($siswa['email']) ?>" required>
              </div>
              <div class="form-group">
                <label for="password">Password (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password baru">
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
              <a href="data-siswa.php" class="btn btn-secondary float-right">Batal</a>
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