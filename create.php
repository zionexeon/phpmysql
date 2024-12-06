<?php
// Menghubungkan ke file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';

// Mengecek apakah request yang dikirim adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari formulir menggunakan metode POST
    $nim = $_POST['nim']; // NIM mahasiswa
    $nama = $_POST['nama']; // Nama mahasiswa
    $alamat = $_POST['alamat']; // Alamat mahasiswa
    $tanggallahir = $_POST['tanggallahir']; // Tanggal lahir mahasiswa
    $jeniskelamin = $_POST['jeniskelamin']; // Jenis kelamin mahasiswa
    $email = $_POST['email']; // Email mahasiswa
    $prodi = $_POST['prodi']; // Program studi mahasiswa

    // Mengambil informasi file foto yang diunggah
    $foto = $_FILES['foto']['name']; // Nama file foto
    $tmp_name = $_FILES['foto']['tmp_name']; // Lokasi sementara file di server
    move_uploaded_file($tmp_name, "uploads/" . $foto); // Memindahkan file ke folder 'uploads'

    // Menyiapkan prepared statement untuk menambahkan data mahasiswa
    $stmt = $koneksi->prepare("INSERT INTO tbmahasiswa (nim, nama, alamat, tanggallahir, jeniskelamin, email, prodi, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nim, $nama, $alamat, $tanggallahir, $jeniskelamin, $email, $prodi, $foto);

    // Menjalankan query
    if ($stmt->execute()) {
        // Jika query berhasil, pengguna akan diarahkan ke halaman index.php
        header('Location: index.php');
    } else {
        // Jika terjadi kesalahan, akan menampilkan pesan error
        echo "Error: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Mengatur karakter encoding halaman menjadi UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
    <title>Tambah Data</title> <!-- Judul halaman -->

    <!-- Menambahkan Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Tambah Data Mahasiswa</h1>

        <!-- Form untuk menambah data mahasiswa -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="tanggallahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" required>
            </div>

            <div class="mb-3">
                <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jeniskelamin" name="jeniskelamin" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="prodi" class="form-label">Program Studi</label>
                <input type="text" class="form-control" id="prodi" name="prodi" required>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <!-- Menambahkan Bootstrap JS dan Popper JS untuk beberapa komponen jika diperlukan -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>