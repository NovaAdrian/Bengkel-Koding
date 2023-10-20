<?php
$mysqli = mysqli_connect("localhost", "root", "", "poliklinik");
if (!$mysqli) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $id_dokter = $_POST['id_dokter'];
    $id_pasien = $_POST['id_pasien'];
    $tgl_periksa = $_POST['tgl_periksa'];
    $catatan = $_POST['catatan'];

    // Cek apakah ini operasi tambah data atau edit data berdasarkan apakah ada nilai ID yang dikirim
    if (empty($id)) {
        // Jika ID kosong, maka ini operasi tambah data
        $query = "INSERT INTO periksa (id_dokter, id_pasien, tgl_periksa, catatan) VALUES ('$id_dokter', '$id_pasien', '$tgl_periksa', '$catatan')";
    } else {
        // Jika ID ada, maka ini operasi edit data
        $query = "UPDATE periksa SET id_dokter='$id_dokter', id_pasien='$id_pasien', tgl_periksa='$tgl_periksa', catatan='$catatan' WHERE id='$id'";
    }

    $result = mysqli_query($mysqli, $query);

    if ($result) {
        header("Location: periksa.php"); // Redirect ke halaman periksa setelah berhasil
        exit();
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM periksa WHERE id='$id'";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        header("Location: periksa.php"); // Redirect ke halaman periksa setelah berhasil menghapus data
        exit();
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}
?>
