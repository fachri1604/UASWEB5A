<?php
// Include file koneksi ke database
include 'koneksi.php';

// Mendapatkan id_uas dari URL
if (isset($_GET['id_uas'])) {
    $id = $_GET['id_uas'];

    // Query untuk menghapus data berdasarkan id_uas
    $sql = "DELETE FROM uas WHERE id_uas='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
        header('Location: admin.php'); // Redirect ke halaman admin setelah penghapusan
        exit(); // Menghentikan eksekusi setelah redirect
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Data tidak ditemukan.";
}

// Menutup koneksi
$conn->close();
