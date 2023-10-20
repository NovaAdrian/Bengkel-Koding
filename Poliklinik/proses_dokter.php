<?php
$_GET['page'] = 'dokter';
include 'index.php';
?>



<?php
// Koneksi ke database (gunakan koneksi Anda)
$mysqli = mysqli_connect("localhost", "root", "", "poliklinik");

// Fungsi untuk membersihkan input
function cleanInput($input)
{
    global $mysqli;
    return mysqli_real_escape_string($mysqli, $input);
}

if (isset($_POST['simpan'])) {
    // Proses simpan atau update data dokter
    $id = cleanInput($_POST['id']);
    $nama = cleanInput($_POST['nama']);
    $alamat = cleanInput($_POST['alamat']);
    $no_hp = cleanInput($_POST['no_hp']);

    if ($id == '') {
        // Jika ID kosong, maka ini adalah operasi INSERT
        $query = "INSERT INTO dokter (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')";
    } else {
        // Jika ID tidak kosong, maka ini adalah operasi UPDATE
        $query = "UPDATE dokter SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id='$id'";
    }

    if (mysqli_query($mysqli, $query)) {
        // Operasi berhasil
        header("Location: dokter.php");
    } else {
        // Operasi gagal
        echo "Error: " . mysqli_error($mysqli);
    }
} elseif (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    // Proses hapus data dokter
    $id = cleanInput($_GET['id']);
    $query = "DELETE FROM dokter WHERE id='$id'";

    if (mysqli_query($mysqli, $query)) {
        // Operasi berhasil
        header("Location: dokter.php");
    } else {
        // Operasi gagal
        echo "Error: " . mysqli_error($mysqli);
    }
} else {
    // Operasi tidak valid
    echo "Operasi tidak valid.";
}

// Tutup koneksi ke database
mysqli_close($mysqli);
?>
