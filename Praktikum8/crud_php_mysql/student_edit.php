<?php
session_start();
include("connection.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit; // Pastikan keluar dari script setelah melakukan redirect
}

if (isset($_POST["submit_edit"])) {
    // Tangani input form
    $nim = htmlentities(strip_tags(trim($_POST["nim"])));
    $name = htmlentities(strip_tags(trim($_POST["name"])));
    $birth_city = htmlentities(strip_tags(trim($_POST["birth_city"])));
    $birth_date = htmlentities(strip_tags(trim($_POST["birth_date"])));
    // $birth_month = htmlentities(strip_tags(trim($_POST["birth_month"])));
    // $birth_year = htmlentities(strip_tags(trim($_POST["birth_year"])));
    $faculty = htmlentities(strip_tags(trim($_POST["faculty"])));
    $department = htmlentities(strip_tags(trim($_POST["department"])));
    $gpa = htmlentities(strip_tags(trim($_POST["gpa"])));

    // Validasi input
    $error_message = "";

    // Lakukan validasi input di sini sesuai kebutuhan Anda

    if ($error_message === "") {
        // Query untuk mengupdate data mahasiswa
        $query = "UPDATE student SET 
                    name='$name', 
                    birth_city='$birth_city', 
                    birth_date='$birth_date', 
                   
                    faculty='$faculty', 
                    department='$department', 
                    gpa='$gpa' 
                  WHERE nim='$nim'";
        
        if (mysqli_query($connection, $query)) {
            echo "Data mahasiswa berhasil diperbarui.";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    } else {
        echo "<div class='error'>$error_message</div>";
    }
}

// Ambil data mahasiswa yang akan diedit
if (isset($_POST["search_name"])) {
    $search_name = htmlentities(strip_tags(trim($_POST["search_name"])));
    
    // Query untuk mencari data mahasiswa berdasarkan nama
    $query = "SELECT * FROM student WHERE name LIKE '%$search_name%'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Tampilkan data mahasiswa yang ditemukan dalam form
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $birth_city = $row["birth_city"];
        $birth_date = $row["birth_date"];
        // $birth_month = $row["birth_month"];
        // $birth_year = $row["birth_year"];
        $faculty = $row["faculty"];
        $department = $row["department"];
        $gpa = $row["gpa"];
        $nim = $row["nim"];

        
?>
        <!-- Form untuk menampilkan data mahasiswa dan melakukan edit -->
<form id="form_edit_mahasiswa" action="student_edit.php" method="post">
    <fieldset>
        <legend>Edit Data Mahasiswa</legend>
        <p>
            <label for="nim">NIM : </label>
            <input type="text" name="nim" id="nim" value="<?php echo $nim ?>" placeholder="Contoh: 12345678" readonly> (8 digit angka)
        </p>
        <p>
            <label for="name">Nama : </label>
            <input type="text" name="name" id="name" value="<?php echo $name ?>">
        </p>
        <p>
            <label for="birth_city">Tempat Lahir : </label>
            <input type="text" name="birth_city" id="birth_city" value="<?php echo $birth_city ?>">
        </p>
        <p>
            <label for="birth_date">Tanggal Lahir : </label>
            <input type="date" name="birth_date" id="birth_date" value="<?php echo $birth_date ?>">
        </p>
        <p>
            <label for="faculty">Fakultas : </label>
            <select name="faculty" id="faculty">
                <option value="FTIB" <?php if($faculty == 'FTIB') echo 'selected'; ?>>FTIB</option>
                <option value="FTEIC" <?php if($faculty == 'FTEIC') echo 'selected'; ?>>FTEIC</option>
            </select>
        </p>
        <p>
            <label for="department">Jurusan : </label>
            <input type="text" name="department" id="department" value="<?php echo $department ?>">
        </p>
        <p>
            <label for="gpa">IPK : </label>
            <input type="text" name="gpa" id="gpa" value="<?php echo $gpa ?>" placeholder="Contoh: 2.75">
        </p>
    </fieldset>
    <br>
    <!-- Tambahkan input hidden untuk menyimpan NIM -->
    <input type="hidden" name="nim_hidden" value="<?php echo $nim; ?>">
    <p>
        <input type="submit" name="submit_edit" value="Simpan Perubahan">
    </p>
</form>

<?php
    } else {
        echo "Data mahasiswa tidak ditemukan.";
    }
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div id="header">
        <h1 id="logo">Edit Data Mahasiswa</h1>
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
    <h2>Edit Data Mahasiswa</h2>
    
    <!-- Form untuk mencari data mahasiswa berdasarkan nama -->
    <form id="form_search_mahasiswa" action="student_edit.php" method="post">
        <fieldset>
            <legend>Cari Data Mahasiswa</legend>
            <p>
                <label for="search_name">Nama: </label>
                <input type="text" name="search_name" id="search_name">
            </p>
        </fieldset>
        <br>
        <p>
            <input type="submit" name="submit" value="Cari Mahasiswa">
        </p>
    </form>

    <?php
    // Sisipkan skrip PHP untuk mengambil data mahasiswa dari database
    // session_start();
    // include("connection.php");

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit; // Pastikan keluar dari script setelah melakukan redirect
    }

    // Inisialisasi variabel untuk data mahasiswa
    

    if (isset($_POST["submit"])) {
        // Tangani input form
        $search_name = htmlentities(strip_tags(trim($_POST["search_name"]))); // Ambil nama dari input form
        
        // Validasi input
        $error_message = "";

        if (empty($search_name)) {
            $error_message .= "- Nama belum diisi <br>";
        }

        if ($error_message === "") {
            // Query untuk mencari data mahasiswa berdasarkan nama
            // $query = "SELECT * FROM student WHERE name LIKE '%$search_name%'";
            // $result = mysqli_query($connection, $query);
            

            if (mysqli_num_rows($result) > 0) {
                // Tampilkan data mahasiswa yang ditemukan dalam form
                while ($row = mysqli_fetch_assoc($result)) {
                    // Assign data ke variabel untuk ditampilkan pada form
                    $name = $row["name"];
                    $birth_city = $row["birth_city"];
                    $birth_date = $row["birth_date"];
                    $faculty = $row["faculty"];
                    $department = $row["department"];
                    $gpa = $row["gpa"];
                    $nim = $row["nim"];
                    $select_ftib = "";
                    $select_fteic = "";
                    $arr_month = [
                        "1" => "Januari",
                        "2" => "Februari",
                        "3" => "Maret",
                        "4" => "April",
                        "5" => "Mei",
                        "6" => "Juni",
                        "7" => "Juli",
                        "8" => "Agustus",
                        "9" => "September",
                        "10" => "Oktober",
                        "11" => "Nopember",
                        "12" => "Desember"
                      ];
                  
                    switch ($faculty) {
                        case 'FTIB':
                          $select_ftib = "selected";
                          break;
                        case 'FTEIC':
                          $select_fteic = "selected";
                          break;
                      }
                    // Tampilkan form edit data mahasiswa
                    ?>
                    <!-- Form untuk menampilkan data mahasiswa dan melakukan edit -->
<form id="form_edit_mahasiswa" action="student_edit.php" method="post">
    <fieldset>
        <legend>Edit Data Mahasiswa</legend>
        <p>
            <label for="nim">NIM : </label>
            <input type="text" name="nim" id="nim" value="<?php echo $nim ?>" placeholder="Contoh: 12345678" readonly> (8 digit angka)
        </p>
        <p>
            <label for="name">Nama : </label>
            <input type="text" name="name" id="name" value="<?php echo $name ?>">
        </p>
        <p>
            <label for="birth_city">Tempat Lahir : </label>
            <input type="text" name="birth_city" id="birth_city" value="<?php echo $birth_city ?>">
        </p>
        <p>
            <label for="birth_date">Tanggal Lahir : </label>
            <input type="date" name="birth_date" id="birth_date" value="<?php echo $birth_date ?>">
        </p>
        <p>
            <label for="faculty">Fakultas : </label>
            <select name="faculty" id="faculty">
                <option value="FTIB" <?php if($faculty == 'FTIB') echo 'selected'; ?>>FTIB</option>
                <option value="FTEIC" <?php if($faculty == 'FTEIC') echo 'selected'; ?>>FTEIC</option>
            </select>
        </p>
        <p>
            <label for="department">Jurusan : </label>
            <input type="text" name="department" id="department" value="<?php echo $department ?>">
        </p>
        <p>
            <label for="gpa">IPK : </label>
            <input type="text" name="gpa" id="gpa" value="<?php echo $gpa ?>" placeholder="Contoh: 2.75">
        </p>
    </fieldset>
    <br>
    <!-- Tambahkan input hidden untuk menyimpan NIM -->
    <input type="hidden" name="nim_hidden" value="<?php echo $nim; ?>">
    <p>
        <input type="submit" name="submit_edit" value="Simpan Perubahan">
    </p>
</form>

                    <?php
                }
            } else {
                echo "Data mahasiswa tidak ditemukan.";
                exit; 
            }
        } else {
            echo "<div class='error'>$error_message</div>";
        }
    } // selesai

    
    ?>
</div>
</body>
</html>
