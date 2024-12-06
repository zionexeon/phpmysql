<?php
// Menyertakan file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Mengambil parameter 'nim' dari URL untuk digunakan sebagai referensi data mahasiswa yang akan diedit
$nim = $_GET['nim'];

// Melakukan query ke database untuk mengambil data mahasiswa berdasarkan NIM yang diterima
$result = mysqli_query($koneksi, "SELECT * FROM tbmahasiswa WHERE nim = '$nim'");

// Mengambil hasil query sebagai array asosiatif
$row = mysqli_fetch_assoc($result);

// Mengecek apakah form telah disubmit melalui metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data yang dikirimkan melalui form
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggallahir = $_POST['tanggallahir'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $email = $_POST['email'];
    $prodi = $_POST['prodi'];

    // Memeriksa apakah ada foto baru yang diupload
    if ($_FILES['foto']['name']) {
        // Menyimpan nama foto baru dan file sementara
        $foto = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        // Memindahkan foto yang diupload ke folder "uploads"
        move_uploaded_file($tmp_name, "uploads/" . $foto);
    } else {
        // Jika tidak ada foto baru, gunakan foto lama yang ada di database
        $foto = $row['foto'];
    }

    // Membuat prepared statement untuk memperbarui data mahasiswa
    $query = "UPDATE tbmahasiswa SET nama = ?, alamat = ?, tanggallahir = ?, jeniskelamin = ?, email = ?, prodi = ?, foto = ? WHERE nim = ?";
    if ($stmt = mysqli_prepare($koneksi, $query)) {
        // Menyusun parameter untuk prepared statement
        mysqli_stmt_bind_param($stmt, "ssssssss", $nama, $alamat, $tanggallahir, $jeniskelamin, $email, $prodi, $foto, $nim);

        // Mengeksekusi query dan memeriksa apakah berhasil
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, arahkan ke halaman index.php
            header('Location: index.php');
        } else {
            // Jika gagal, tampilkan pesan error
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "Error in preparing statement: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Mengatur karakter encoding halaman menjadi UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
    <title>Edit Data</title>

    <!-- Menambahkan link ke file CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Data Mahasiswa</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Input untuk Nama mahasiswa dengan nilai default sesuai data lama -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama'] ?>" required>
            </div>

            <!-- Input untuk Alamat mahasiswa dengan nilai default sesuai data lama -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required><?= $row['alamat'] ?></textarea>
            </div>

            <!-- Input untuk Tanggal Lahir dengan nilai default sesuai data lama -->
            <div class="mb-3">
                <label for="tanggallahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" value="<?= $row['tanggallahir'] ?>" required>
            </div>

            <!-- Input untuk Jenis Kelamin dengan pilihan yang disesuaikan dengan data lama -->
            <div class="mb-3">
                <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jeniskelamin" name="jeniskelamin" required>
                    <option value="L" <?= ($row['jeniskelamin'] == 'L' ? 'selected' : '') ?>>Laki-laki</option>
                    <option value="P" <?= ($row['jeniskelamin'] == 'P' ? 'selected' : '') ?>>Perempuan</option>
                </select>
            </div>

            <!-- Input untuk Email mahasiswa dengan nilai default sesuai data lama -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $row['email'] ?>" required>
            </div>

            <!-- Input untuk Program Studi mahasiswa dengan nilai default sesuai data lama -->
            <div class="mb-3">
                <label for="prodi" class="form-label">Prodi</label>
                <input type="text" class="form-control" id="prodi" name="prodi" value="<?= $row['prodi'] ?>" required>
            </div>

            <!-- Input untuk Foto mahasiswa, jika foto baru diupload -->
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>

            <!-- Tombol untuk menyimpan perubahan -->
            <button type="submit" class="btn btn-primary">Ubah</button>
        </form>
    </div>

    <!-- Menambahkan script JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
