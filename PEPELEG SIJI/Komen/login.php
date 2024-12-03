<?php
include('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php?login_success=1");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 100%;
      max-width: 400px;
    }
    h1 {
      margin-bottom: 20px;
      color: #333;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .hidden {
      display: none;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
    .error {
      color: red;
      margin: 10px 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Login Admin</h1>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form action="login.php" method="POST">
      <input type="text" id="username" name="username" placeholder="Username" required>
      <input type="password" id="password" name="password" placeholder="Password" required>
      <input type="submit" id="loginButton" value="Login" class="hidden">
    </form>
  </div>

  <script>
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const loginButton = document.getElementById('loginButton');

    // Tampilkan tombol login hanya jika username dan password diisi
    function toggleLoginButton() {
      if (username.value.trim() && password.value.trim()) {
        loginButton.classList.remove('hidden');
      } else {
        loginButton.classList.add('hidden');
      }
    }

    // Pantau perubahan input
    username.addEventListener('input', toggleLoginButton);
    password.addEventListener('input', toggleLoginButton);

    // Tampilkan notifikasi berhasil login jika ada parameter di URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('login_success')) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil Login!',
        text: 'Selamat datang kembali, admin!',
        toast: true,
        position: 'top-right',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
      }).then(() => {
        window.history.replaceState({}, document.title, window.location.pathname);
      });
    }
  </script>
</body>
</html>
