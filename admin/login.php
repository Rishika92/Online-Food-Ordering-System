<?php include('../configure/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Food Order System</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
    background: linear-gradient(135deg, #ff9a9e, #fad0c4); /* peach to soft pink */
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-box {
      background: rgba(0, 0, 0, 0.8);
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.4);
      display: flex;
      overflow: hidden;
      max-width: 900px;
      width: 100%;
    }

    .image-side {
      width: 50%;
      background: url('https://img.freepik.com/premium-photo/beautiful-table-italian-pasta-pizza-burger-drinks-selective-soft-focus-generative-ai_874904-1967.jpg') no-repeat center center;
      background-size: contain;
      background-color: #000;
    }

    .form-side {
      padding: 40px;
      width: 50%;
      color: #fff;
    }

    .form-side h2 {
      font-weight: bold;
      margin-bottom: 20px;
    }
    .form-control {
  background: #222;
  border: none;
  color: #fff; /* 👈 This makes the input text white */
}

.form-control::placeholder {
  color: #aaa; /* Optional: lighter placeholder for better UX */
}

   

    .btn-login {
      background: #ff5722;
      border: none;
    }

    .btn-login:hover {
      background: #e64a19;
    }

    .form-text a {
      color: #bbb;
    }

    .social-login img {
      height: 35px;
      margin: 0 5px;
      cursor: pointer;
    }

  </style>
</head>
<body>

<div class="login-box">
  <div class="image-side d-none d-md-block"></div>

  <div class="form-side">
    <h2>Login</h2>

    <?php 
    if(isset($_SESSION['login-page'])){
        echo $_SESSION['login-page'];
        unset($_SESSION['login-page']);
    } 
    if(isset($_SESSION['no-login-message'])){
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
    } 
    ?>

    <form action="" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Email</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="example@xyz.com" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

           <button type="submit" name="submit" class="btn btn-login w-100 mb-3">Sign In</button>

      
  </form>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
// Keep PHP logic unchanged
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if($count == 1){
        $_SESSION['login-page'] = "<div class='alert alert-success text-center'>Login successful</div>";
        $_SESSION['user'] = $username;
        header('location:'.SITEURL.'admin/');
    } else {
        $_SESSION['login-page'] = "<div class='alert alert-danger text-center'>Username or password didn't match</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
}
?>
