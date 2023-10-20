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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous">
    <title>Periksa</title>
</head>

<body>
    <div class="container">

        <!-- Form Input Data Periksa -->
        <form class="form" method="POST" action="proses_periksa.php">
            <?php
            $id = '';
            $id_dokter = '';
            $id_pasien = '';
            $tgl_periksa = '';
            $catatan = '';

            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $id = $row['id'];
                    $id_dokter = $row['id_dokter'];
                    $id_pasien = $row['id_pasien'];
                    $tgl_periksa = $row['tgl_periksa'];
                    $catatan = $row['catatan'];
                }
            }
            ?>

            <input type="hidden" name="id" value="<?php echo $id ?>">

            <div class="form-group">
                <label for="inputDokter" class="fw-bold">Dokter</label>
                <select class="form-control" name="id_dokter" id="inputDokter">
                    <?php
                    $dokter_result = mysqli_query($mysqli, "SELECT * FROM dokter");
                    while ($dokter_data = mysqli_fetch_array($dokter_result)) {
                        $selected = ($id_dokter == $dokter_data['id']) ? "selected" : "";
                        echo "<option value='" . $dokter_data['id'] . "' $selected>" . $dokter_data['nama'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="inputPasien" class="fw-bold">Pasien</label>
                <select class="form-control" name="id_pasien" id="inputPasien">
                    <?php
                    $pasien_result = mysqli_query($mysqli, "SELECT * FROM pasien");
                    while ($pasien_data = mysqli_fetch_array($pasien_result)) {
                        $selected = ($id_pasien == $pasien_data['id']) ? "selected" : "";
                        echo "<option value='" . $pasien_data['id'] . "' $selected>" . $pasien_data['nama'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="inputTglPeriksa" class="fw-bold">Tanggal Periksa</label>
                <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputTglPeriksa" value="<?php echo $tgl_periksa ?>">
            </div>

            <div class="form-group">
                <label for="inputCatatan" class="fw-bold">Catatan</label>
                <textarea class="form-control" name="catatan" id="inputCatatan" placeholder="Catatan"><?php echo $catatan ?></textarea>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
            </div>
        </form>

        <!-- Tabel Daftar Periksa -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pasien</th>
                    <th>Nama Dokter</th>
                    <th>Tanggal Periksa</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($mysqli, "SELECT periksa.id, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter, periksa.tgl_periksa, periksa.catatan FROM periksa LEFT JOIN pasien ON periksa.id_pasien = pasien.id LEFT JOIN dokter ON periksa.id_dokter = dokter.id");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $data['nama_pasien'] ?></td>
                        <td><?php echo $data['nama_dokter'] ?></td>
                        <td><?php echo $data['tgl_periksa'] ?></td>
                        <td><?php echo $data['catatan'] ?></td>
                        <td>
                            <a class="btn btn-success rounded-pill px-3" href="periksa.php?id=<?php echo $data['id'] ?>">Ubah</a>
                            <a class="btn btn-danger rounded-pill px-3" href="proses_periksa.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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
