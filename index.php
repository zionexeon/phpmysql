<?php
// Menyertakan file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Mengecek apakah ada parameter pencarian di URL
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Modifikasi query untuk melakukan pencarian jika ada input pencarian
$query = "SELECT * FROM tbmahasiswa";
if ($search != '') {
    $query .= " WHERE nama LIKE '%$search%'";
}

// Melakukan query ke database
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Mengatur karakter encoding halaman menjadi UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->

    <title>CRUD Mahasiswa</title> <!-- Judul halaman -->

    <!-- Menyertakan CDN Bootstrap untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Menyertakan custom stylesheet (opsional) -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Data Mahasiswa</h1> <!-- Menampilkan judul halaman -->

        <!-- Form untuk pencarian -->
        <form method="get" action="" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan Nama" value="<?= htmlspecialchars($search); ?>" />
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <!-- Tombol untuk menambahkan data baru -->
        <a href="create.php" class="btn btn-success mb-3">Tambah Data</a>

        <!-- Membuat tabel untuk menampilkan data mahasiswa dan menambahkan scroll horizontal -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Email</th>
                        <th>Prodi</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?> <!-- Looping untuk setiap baris data mahasiswa -->
                        <tr>
                            <td><?= $row['nim']; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                            <td><?= $row['tanggallahir']; ?></td>
                            <td><?= $row['jeniskelamin']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['prodi']; ?></td>
                            <td>
                                <img src="uploads/<?= $row['foto']; ?>" alt="Foto" class="img-thumbnail" width="150">
                            </td>
                            <td>
                                <a href="edit.php?nim=<?= $row['nim']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?nim=<?= $row['nim']; ?>" onclick="return confirm('Yakin ingin menghapus?');" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?> <!-- Akhir dari looping -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Menyertakan script JS dari Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
