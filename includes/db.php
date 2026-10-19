<?php
// عدّل هذه القيم من لوحة InfinityFree (قسم MySQL Databases)
$host = 'sqlXXX.infinityfree.com';
$db   = 'if0_XXXXXXX_lostfound';
$user = 'if0_XXXXXXX';
$pass = 'ضع_كلمة_المرور_هنا';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('تعذر الاتصال بقاعدة البيانات، راجع ملف includes/db.php');
}
if (session_status() === PHP_SESSION_NONE) session_start();
