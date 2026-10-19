<?php
// حماية الصفحات: لا يدخلها إلا المستخدم المسجّل
require_once __DIR__ . '/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?need=1');
    exit;
}
