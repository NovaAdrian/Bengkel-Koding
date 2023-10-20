<?php
$mysqli = mysqli_connect("localhost", "root", "", "poliklinik");
if (!$mysqli) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    crossorigin="anonymous">
    <title>pasien</title>
</head>

<body>

    <div class="container">

        <!-- Form Input Data pasien -->
        <form class="mt-3" method="POST" action="proses_pasien.php">
            <?php
            $id = '';
            $nama = '';
            $alamat = '';
            $no_hp = '';

            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM pasien WHERE id='" . $_GET['id'] . "'");
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
                <label for="inputNama" class="fw-bold">Nama pasien</label>
                <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama pasien" value="<?php echo $nama ?>">
            </div>

            <div class="form-group">
                <label for="inputAlamat" class="fw-bold">Alamat pasien</label>
                <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat pasien" value="<?php echo $alamat ?>">
            </div>

            <div class="form-group">
                <label for="inputNoHP" class="fw-bold">Nomor HP</label>
                <input type="text" class="form-control" name="no_hp" id="inputNoHP" placeholder="Nomor HP" value="<?php echo $no_hp ?>">
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
            </div>
        </form>

        <!-- Tabel Daftar pasien -->
        <table class="table mt-4">
            <thead>
                <tr>
                <th>#</th>
                    <th>Nama Pasien</th>
                    <th>Alamat Pasien</th>
                    <th>Nomor HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($mysqli, "SELECT * FROM pasien");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $data['nama'] ?></td>
                        <td><?php echo $data['alamat'] ?></td>
                        <td><?php echo $data['no_hp'] ?></td>
                        <td>
                            <a class="btn btn-success rounded-pill px-3" href="pasien.php?id=<?php echo $data['id'] ?>">Ubah</a>
                            <a class="btn btn-danger rounded-pill px-3" href="proses_pasien.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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
