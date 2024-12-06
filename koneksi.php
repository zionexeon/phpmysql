<?php
// Mendefinisikan informasi koneksi ke database
$host = "localhost"; // Alamat host, 'localhost' berarti server database berada pada komputeryang sama
$user = "root"; // Username untuk mengakses database, biasanya 'root' pada XAMPP
$pass = ""; // Password untuk akses database, kosongkan jika tidak ada password
$db = "dbmahasiswa"; // Nama database yang akan digunakan
// Membuat koneksi ke database MySQL menggunakan fungsi mysqli_connect()
$koneksi = mysqli_connect($host, $user, $pass, $db);
// Mengecek apakah koneksi berhasil, jika gagal tampilkan pesan error dan hentikan proses
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>