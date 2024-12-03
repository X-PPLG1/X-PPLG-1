<?php
include('../includes/db.php');
include('../includes/auth.php'); // cek admin

// Hapus saran berdasarkan ID
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM saran WHERE id=$id";
    $conn->query($sql);
    header("Location: admin.php?deleted=1");
    exit;
}

// Ambil semua saran dari database
$sql = "SELECT * FROM saran ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin: 50px auto;
      background: #fff;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
    }
    h1, h2 {
      text-align: center;
      color: #333;
    }
    a {
      text-decoration: none;
      color: #007bff;
    }
    a:hover {
      text-decoration: underline;
    }
    .logout-btn {
      display: inline-block;
      background: #ff4d4d;
      color: #fff;
      padding: 10px 15px;
      border-radius: 5px;
      text-align: center;
      margin: 10px auto;
      display: block;
      width: max-content;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table th, table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    table th {
      background-color: #f4f4f4;
    }
    .delete-btn {
      color: #ff4d4d;
      cursor: pointer;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Dashboard Admin</h1>
    <a href="logout.php" class="logout-btn">Logout</a>
    <h2>Daftar Saran</h2>
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Saran</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['nama']; ?></td>
          <td><?php echo $row['saran']; ?></td>
          <td><?php echo $row['tanggal']; ?></td>
          <td>
            <button class="delete-btn" onclick="confirmDelete(<?php echo $row['id']; ?>)">Hapus</button>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script>
    // SweetAlert untuk konfirmasi hapus
    function confirmDelete(id) {
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang sudah dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `?delete=${id}`;
        }
      });
    }

    // SweetAlert untuk notifikasi setelah berhasil menghapus
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('deleted')) {
      Swal.fire({
        icon: 'success',
        title: 'Terhapus!',
        text: 'Saran berhasil dihapus.',
        confirmButtonText: 'OK'
      }).then(() => {
        // Menghapus parameter dari URL
        window.history.replaceState({}, document.title, window.location.pathname);
      });
    }
  </script>
</body>
</html>
