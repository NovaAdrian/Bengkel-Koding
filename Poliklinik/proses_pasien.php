<?php
$mysqli = mysqli_connect("localhost", "root", "", "poliklinik");
if (!$mysqli) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // Cek apakah ini operasi tambah data atau edit data berdasarkan apakah ada nilai ID yang dikirim
    if (empty($id)) {
        // Jika ID kosong, maka ini operasi tambah data
        $query = "INSERT INTO pasien (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')";
    } else {
        // Jika ID ada, maka ini operasi edit data
        $query = "UPDATE pasien SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id='$id'";
    }

    $result = mysqli_query($mysqli, $query);

    if ($result) {
        header("Location: pasien.php"); // Redirect ke halaman pasien setelah berhasil
        exit();
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pasien WHERE id='$id'";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        header("Location: pasien.php"); // Redirect ke halaman pasien setelah berhasil menghapus data
        exit();
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}

mysqli_close($mysqli);
?>
