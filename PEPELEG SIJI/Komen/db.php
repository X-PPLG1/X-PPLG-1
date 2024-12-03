<?php
$servername = "localhost";
$username = "root";  // Default username di Laragon
$password = "rizkynolimit";      // Default password di Laragon (kosong)
$dbname = "kotak_saran";  // Nama database yang sudah dibuat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
