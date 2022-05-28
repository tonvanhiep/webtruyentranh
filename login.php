<?php
    session_start();
    if(isset($_SESSION['user_id'])) {
        header("Location: ./");
        die();
    }
?>

<!DOCTYPE html>
<html lang="vi" class>
<head>
  <meta charset="utf-8">
  <title>Đọc truyện tranh Manga, Manhua, Manhwa, Comic Online</title>
  <meta name="keyword" content="doc truyen tranh, manga, manhua, manhwa, comic">
  <meta name="description" content="Đọc truyện tranh Manga, Manhua, Manhwa, Comic online hay và cập nhật thường xuyên tại PhieuTruyen.Com">
  <meta property="og:site_name" content="PhieuTruyen.Com">
  <meta name="Author" content="PhieuTruyen.Com">
  <meta name="viewport" content="width=device-width, inital-scale=1.0">
  <link rel="stylesheet" href="./css/formDK-DN.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./Bootstrap/js/bootstrap.js">
  <link rel="stylesheet" href="./Bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
</head>
<body>
   <div class="container-xxl contain">
    <div class="logo">
      <img src="./img/image.png" alt="logo">
      <h2>PhieuTruyen.com</h2>
    </div>
    
    <form action="./action_login.php" method="POST">
      <h2>ĐĂNG NHẬP TÀI KHOẢN</h2><br>

      <div class="form-group">
        <input class="form-control" type="username" name="username" placeholder="Tên đăng nhập" required>
      </div> 
      <div class="form-group">
        <input class="form-control" type="password" name="password" placeholder="Mật khẩu" minlength="6">
      </div>
        <input class="input1" type="submit" value="Đăng nhập">
  
        <p><b>Bạn đã quên mật khẩu? <a href="./forgotpassword.php">Lấy lại mật khẩu</a></b></p>
        
        <p><b>Bạn chưa có tài khoản? <a href="./register.php">Đăng kí</a></b></p>
    </form>
   </div>
</body>
</html>
