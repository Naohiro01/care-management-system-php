<?php
 session_start();
 require 'db.php';

 $error = '';
 if (isset($_GET['timeout'])) {
      $error = 'セッションがタイムアウトしました。再ログインしてください。';
 }

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ??'');
    $password = trim($_POST['password'] ??'');

    if ($username === '' || $password === '') {
      $error = 'IDとパスワードを入力してください。';
    } else {
         $stmt = $pdo -> prepare('SELECT*FROM admins WHERE username = ?');
         $stmt -> execute([$username]);
         $admin = $stmt -> fetch(PDO::FETCH_ASSOC);

         if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $admin['username'];
            $_SESSION['last_activity'] = time();
            header('Location:index.php');
            exit;
         } else {
            $error = 'IDまたはパスワードが正しくありません。';
         }
 }}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Philosopher&display=swap" rel="stylesheet">

    <!-- リセットcss -->
    <link rel="stylesheet" href="https://unpkg.com">
    <!-- css読込 -->
    <link rel="stylesheet" href="style.css">

</head>
<body class="login-page">
   <div class="login-wrap">
      <div class="login-box">
         <div class="login-logo">
            <h1>利用者管理システム</h1>
            <p>Care Management System</p>
         </div><!-- .login-logo -->
         <form method="post">
            <div class="form-group">
               <label for="username">ユーザーID</label>
               <input type="text" name="username" id="username">
            </div><!-- .form-group -->

            <div class="form-group">
               <label for="password">パスワード</label>
               <input type="password" name="password" id="password">      
            </div><!-- .form-group -->
            <p class="login-error"><?= htmlspecialchars($error) ?></p>
            <button type="submit" class="btn-login">ログイン</button>
         </form>
      </div><!-- .login-box -->
   </div><!-- .login-wrap -->
   
</body>
</html>