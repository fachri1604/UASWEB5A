<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $author = $_POST['author'];
    $tanggal_posting = $_POST['tanggal_posting'];

    // File upload setup
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["images"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate that the uploaded file is an image
    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit;
    }

    // File size validation
    if ($_FILES["images"]["size"] > 2000000) {
        echo "File size is too large.";
        exit;
    }

    // Allow specific file formats
    if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        echo "Only JPG, JPEG, PNG & GIF files are allowed.";
        exit;
    }

    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
        $images = $target_file;

        // SQL query to insert data into `uas` table
        $sql = "INSERT INTO uas (judul, isi, kategori, author, tanggal_posting, images) 
                VALUES ('$judul', '$isi', '$kategori', '$author', '$tanggal_posting', '$images')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to admin.php after successful insertion
            header("Location: admin.php");
            exit; // Ensure no further code is executed after redirection
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "There was an error uploading the file.";
    }
}

$conn->close();
