<?php
include('../includes/db.php');  // Memasukkan koneksi database

// Menyimpan saran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $saran = $_POST['saran'];

    // Cek apakah nama sudah mengirimkan saran sebelumnya
    $cek_sql = "SELECT * FROM saran WHERE nama = '$nama'";
    $cek_result = $conn->query($cek_sql);

    if ($cek_result->num_rows > 0) {
        // Redirect dengan pesan error jika duplikasi ditemukan
        header("Location: index.php?error=1");
        exit();
    } else {
        $sql = "INSERT INTO saran (nama, saran) VALUES ('$nama', '$saran')";
        if ($conn->query($sql) === TRUE) {
            // Redirect setelah saran berhasil ditambahkan
            header("Location: index.php?success=1");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Menampilkan saran
$sql = "SELECT * FROM saran ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kotak Saran OSIS</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>
<body>
  <div class="container">
    <h1>Kotak Saran OSIS</h1>

    <!-- Form untuk menambah saran -->
    <form action="index.php" method="POST">
      <div class="form-group">
        <input type="text" name="nama" placeholder="Nama" required>
      </div>
      <div class="form-group">
        <textarea name="saran" rows="4" placeholder="Tulis saran Anda..." required></textarea>
      </div>
      <div class="form-group">
        <input type="submit" value="Kirim Saran">
      </div>
    </form>

    <!-- Menampilkan saran yang sudah ada -->
    <h2>Saran yang Masuk</h2>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="saran">
        <p><strong><?php echo $row['nama']; ?></strong> (<?php echo $row['tanggal']; ?>)</p>
        <p><?php echo nl2br($row['saran']); ?></p>
      </div>
    <?php } ?>
  </div>

  <!-- Script untuk SweetAlert -->
  <script>
    // Deteksi jika parameter success ada di URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
      Swal.fire({
        icon: 'success',
        title: 'Terima Kasih!',
        text: 'Saran Anda berhasil dikirim.',
        confirmButtonText: 'OK'
      }).then(() => {
        // Menghapus parameter dari URL agar tidak muncul lagi
        window.history.replaceState({}, document.title, window.location.pathname);
      });
    } else if (urlParams.has('error')) {
      Swal.fire({
        icon: 'error',
        title: 'Duplikasi Saran',
        text: 'Anda sudah mengirimkan saran sebelumnya.',
        confirmButtonText: 'OK'
      }).then(() => {
        window.history.replaceState({}, document.title, window.location.pathname);
      });
    }
  </script>
</body>
</html>
