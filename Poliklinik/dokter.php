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

    if (empty($id)) {
        // Jika ID kosong, maka ini adalah operasi INSERT
        $query = "INSERT INTO dokter (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')";
    } else {
        // Jika ID tidak kosong, maka ini adalah operasi UPDATE
        $query = "UPDATE dokter SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id='$id'";
    }

    if (mysqli_query($mysqli, $query)) {
        // Operasi berhasil, arahkan kembali ke halaman dokter.php
        header("Location: index.php?page=dokter");
    } else {
        // Operasi gagal
        echo "Error: " . mysqli_error($mysqli);
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM dokter WHERE id='$id'";

    if (mysqli_query($mysqli, $query)) {
        // Operasi berhasil, arahkan kembali ke halaman dokter.php
        header("Location: index.php?page=dokter");
    } else {
        // Operasi gagal
        echo "Error: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Dokter</title>
</head>
<body>

    <div class="container">

        <!-- Form Input Data Dokter -->
        <form class="mt-3" method="POST" action="">
            <?php
            $id = '';
            $nama = '';
            $alamat = '';
            $no_hp = '';

            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $id = $row['id'];
                    $nama = $row['nama'];
                    $alamat = $row['alamat'];
                    $no_hp = $row['no_hp'];
                }
            }
            ?>

            <input type="hidden" name="id" value="<?php echo $id ?>">

            <div class="form-group">
                <label for="inputNama" class="fw-bold">Nama Dokter</label>
                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama Dokter" value="<?php echo $nama ?>">
            </div>

            <div class="form-group">
                <label for "inputAlamat" class="fw-bold">Alamat Dokter</label>
                <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat Dokter" value="<?php echo $alamat ?>">
            </div>

            <div class="form-group">
                <label for="inputNoHP" class="fw-bold">Nomor HP</label>
                <input type="text" class="form-control" name="no_hp" id="inputNoHP" placeholder="Nomor HP" value="<?php echo $no_hp ?>">
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
            </div>
        </form>

        <!-- Tabel Daftar Dokter -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Dokter</th>
                    <th>Alamat Dokter</th>
                    <th>Nomor HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $data['nama'] ?></td>
                        <td><?php echo $data['alamat'] ?></td>
                        <td><?php echo $data['no_hp'] ?></td>
                        <td>
                            <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                            <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&aksi=hapus&id=<?php echo $data['id'] ?>">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
