<?php
session_start();
include("connection.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit; // Pastikan keluar dari script setelah melakukan redirect
}

// Proses hapus data mahasiswa jika nama dikirimkan melalui parameter URL
if (isset($_GET["name"])) {
    $name = $_GET["name"];

    // Query untuk menghapus data mahasiswa berdasarkan nama
    $query = "DELETE FROM student WHERE name='$name'";

    if (mysqli_query($connection, $query)) {
        echo "Data mahasiswa dengan nama $name berhasil dihapus.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    // Redirect kembali ke halaman tampil data mahasiswa
    header("Location: student_view.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Data Mahasiswa</title>
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div id="header">
        <h1 id="logo">Hapus Data Mahasiswa</h1>
    </div>
    <hr>
    <nav>
        <ul>
        <li><a href="student_view.php">Tampil</a></li>
        <li><a href="student_add.php">Tambah</a>
        <li><a href="student_edit.php">Edit</a>
        <li><a href="student_delete.php">Hapus</a>
        <li><a href="logout.php">Logout</a>
        </ul>
    </nav>
    <h2>Hapus Data Mahasiswa</h2>
    
    <?php
    // Pastikan user telah login sebelum memproses penghapusan data
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit;
    }
    ?>
    <!-- Form untuk memasukkan nama mahasiswa yang ingin dihapus -->
    <form action="student_delete.php" method="get">
        <fieldset>
            <legend>Masukkan Nama Mahasiswa yang Ingin Dihapus</legend>
            <p>
                <label for="name">Nama Mahasiswa : </label>
                <input type="text" name="name" id="name" required>
            </p>
        </fieldset>
        <br>
        <p>
            <input type="submit" name="submit_delete" value="Hapus">
            <a href="student_view.php">Batal</a>
        </p>
    </form>

    <?php
    // Tampilkan data mahasiswa yang akan dihapus
    if (isset($_GET["name"])) {
        $name = $_GET["name"];

        // Query untuk mencari data mahasiswa berdasarkan nama
        $query = "SELECT * FROM student WHERE name='$name'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
   
        } else {
            echo "Data mahasiswa tidak ditemukan.";
        }
    }
    ?>
</div>
</body>
</html>
