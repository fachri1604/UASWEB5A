<?php
$servername = "localhost";  // Server yang digunakan, biasanya "localhost"
$username = "root";         // Username MySQL Anda (default untuk XAMPP adalah "root")
$password = "";             // Password MySQL Anda (kosong jika tidak diatur, default untuk XAMPP)
$dbname = "uas";       // Nama database yang ingin Anda gunakan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
