<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $author = $_POST['author'];
    $tanggal_posting = $_POST['tanggal_posting'];

    // Cek apakah author sudah ada di tabel biodata_author (misalnya untuk memvalidasi author terdaftar)
    $cek_author = "SELECT * FROM biodata_author WHERE author_name = '$author'";
    $result = $conn->query($cek_author);

    if ($result->num_rows > 0) {
        // Cek apakah kombinasi judul dan kategori sudah ada di tabel uas
        $cek_uas = "SELECT * FROM uas WHERE judul = '$judul' AND kategori = '$kategori'";
        $result_uas = $conn->query($cek_uas);

        if ($result_uas->num_rows == 0) {
            // Proses upload gambar
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["images"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Cek apakah file benar-benar gambar
            $check = getimagesize($_FILES["images"]["tmp_name"]);
            if ($check === false) {
                echo "File bukan gambar.";
                exit;
            }

            // Cek ukuran file
            if ($_FILES["images"]["size"] > 2000000) {
                echo "Ukuran file terlalu besar.";
                exit;
            }

            // Cek format gambar
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Hanya JPG, JPEG, PNG & GIF yang diperbolehkan.";
                exit;
            }

            // Pindahkan file yang diupload ke folder
            if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
                $images = $target_file;

                // Query untuk menyimpan data ke tabel uas
                $sql = "INSERT INTO uas (judul, isi, kategori, author, tanggal_posting, images) 
                        VALUES ('$judul', '$isi', '$kategori', '$author', '$tanggal_posting', '$images')";

                if ($conn->query($sql) === TRUE) {
                    echo "Data berhasil ditambahkan.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Terjadi kesalahan saat mengupload file.";
            }
        } else {
            echo "Data dengan judul dan kategori yang sama sudah ada.";
        }
    } else {
        echo "Author tidak ditemukan di biodata_author. Silakan masukkan author yang sudah terdaftar.";
    }
}

// Tutup koneksi
$conn->close();
