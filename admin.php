<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/admin.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <title>Halaman Admin</title>
</head>

<body>
    <nav>
        <span class="logo_name">Blog</span>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="index.html"><i class="uil uil-estate"></i><span class="link-name">Karya</span></a></li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top"></div>

        <div class="dash-content">
            <h3>Data</h3>
            <table id="dataTable">
                <thead>
                    <tr>
                        <th>id_uas</th>
                        <th>judul</th>
                        <th>isi</th>
                        <th>kategori</th>
                        <th>author</th>
                        <th>tanggal posting</th>
                        <th>images</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'koneksi.php';
                    $sql = "SELECT * FROM uas";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                <td>" . $row["id_uas"] . "</td>
                <td>" . $row["judul"] . "</td>
                <td>" . $row["isi"] . "</td>
                <td>" . $row["kategori"] . "</td>
                <td>" . $row["author"] . "</td>
                <td>" . $row["tanggal_posting"] . "</td>
                <td><img src='./" . $row["images"] . "' alt='Gambar' class='profile-img'></td>
                <td>    
                  <div class='button-group'>
                    <a href='#' class='edit-btn' 
                       data-id_uas='" . $row["id_uas"] . "' 
                       data-judul='" . $row["judul"] . "' 
                       data-isi='" . $row["isi"] . "' 
                       data-kategori='" . $row["kategori"] . "' 
                       data-author='" . $row["author"] . "' 
                       data-tanggal='" . $row["tanggal_posting"] . "' 
                       data-images='" . $row["images"] . "' 
                       onclick='populateForm(event, this)'>
                      <i class='uil uil-edit'></i>
                    </a>
                    <a href='hapus.php?id_uas=" . $row["id_uas"] . "' class='delete-btn' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                      <i class='uil uil-trash-alt'></i>
                    </a>
                  </div>
                </td>
              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada data ditemukan</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>

            <!-- Form untuk tambah/edit data -->
            <div class="project-form" id="editFormSection">
                <h2>Tambah/Edit Data</h2>
                <form id="projectForm" action="menambahdata.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id_uas" name="id_uas" /> <!-- Hidden field for id_uas -->

                    <label for="judul">Judul:</label>
                    <input type="text" id="judul" name="judul" required />

                    <label for="isi">Isi:</label>
                    <textarea id="isi" name="isi" required></textarea>

                    <label for="kategori">Kategori:</label>
                    <select id="kategori" name="kategori" required>
                        <?php
                        include 'koneksi.php';
                        $sql_enum = "SHOW COLUMNS FROM uas LIKE 'kategori'";
                        $result_enum = $conn->query($sql_enum);
                        $row_enum = $result_enum->fetch_assoc();

                        // Extract ENUM values and display as dropdown options
                        $enum_values = explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", "\\2", $row_enum['Type']));
                        foreach ($enum_values as $value) {
                            echo "<option value='$value'>$value</option>";
                        }
                        ?>
                    </select>

                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" required />

                    <label for="tanggal">Tanggal Posting:</label>
                    <input type="date" id="tanggal" name="tanggal_posting" required />

                    <label for="image">Gambar:</label>
                    <input type="file" id="image" name="images" accept="image/*" />



                    <button type="submit" name="submit">Simpan Data</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        function populateForm(event, editButton) {
            event.preventDefault();

            // Get data attributes and populate the form
            const id_uas = editButton.getAttribute("data-id_uas");
            document.getElementById("id_uas").value = id_uas; // Set the id for editing
            document.getElementById("judul").value = editButton.getAttribute("data-judul");
            document.getElementById("isi").value = editButton.getAttribute("data-isi");
            document.getElementById("kategori").value = editButton.getAttribute("data-kategori");
            document.getElementById("author").value = editButton.getAttribute("data-author");
            document.getElementById("tanggal").value = editButton.getAttribute("data-tanggal");

            const images = editButton.getAttribute("data-images");
            const imagePreview = document.getElementById("image-preview");
            imagePreview.innerHTML = ""; // Clear previous preview if any

            if (images) {
                const img = document.createElement("img");
                img.src = `./${images}`;
                img.alt = "Gambar";
                img.classList.add("profile-preview");
                imagePreview.appendChild(img);
            }

            // Scroll to the form for editing
            document.getElementById("editFormSection").scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    </script>

</body>

</html>