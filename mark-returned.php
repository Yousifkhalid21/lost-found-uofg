<?php
// تعليم الغرض كـ "تم تسليمه لصاحبه" — يسمح فقط لصاحب المنشور
require_once 'includes/auth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $pdo->prepare("UPDATE items SET status = 'returned', returned_at = NOW() WHERE id = ? AND user_id = ? AND status = 'open'");
    $stmt->execute([$id, $_SESSION['user_id']]);
}
header('Location: returned.php');
exit;
