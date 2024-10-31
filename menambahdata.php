<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_uas = $_POST['id_uas'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $author = $_POST['author'];
    $tanggal_posting = $_POST['tanggal_posting'];

    $target_file = '';
    if ($_FILES["images"]["name"]) {
        // File upload logic as before
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["images"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Image validation as before
        $check = getimagesize($_FILES["images"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit;
        }
        if ($_FILES["images"]["size"] > 2000000) {
            echo "File size is too large.";
            exit;
        }
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }
        move_uploaded_file($_FILES["images"]["tmp_name"], $target_file);
    }

    if ($id_uas) {
        // Update existing record
        $sql = "UPDATE uas SET judul='$judul', isi='$isi', kategori='$kategori', author='$author', tanggal_posting='$tanggal_posting'";
        if ($target_file) $sql .= ", images='$target_file'";
        $sql .= " WHERE id_uas='$id_uas'";
    } else {
        // Insert new record
        $sql = "INSERT INTO uas (judul, isi, kategori, author, tanggal_posting, images) VALUES ('$judul', '$isi', '$kategori', '$author', '$tanggal_posting', '$target_file')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
