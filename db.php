<?php 
 $host = 'localhost';
 $dbname = 'care_system';
 $user = 'root';
 
//  隠しメモ(.env)読み込み設定
$env = parse_ini_file('.env');
$pass = $env['DB_PASSWORD'];

 try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4",$user,$pass);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
    die('データベース接続エラー:'.
     $e -> getMessage());
 }