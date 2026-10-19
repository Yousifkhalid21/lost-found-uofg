<?php
require_once 'includes/db.php';
$title = 'تواصل معنا';
$done = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $msg === '') {
        $error = 'املأ كل الحقول بشكل صحيح.';
    } else {
        $pdo->prepare('INSERT INTO messages (name, email, message) VALUES (?,?,?)')->execute([$name, $email, $msg]);
        $done = true;
    }
}
require 'includes/header.php';
?>
<div class="form-box">
  <h3 class="mb-3">تواصل معنا</h3>
  <?php if ($done): ?><div class="alert alert-success">وصلتنا رسالتك، شكرًا لك.</div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <form method="post">
    <label class="form-label">الاسم</label>
    <input name="name" class="form-control mb-3" required>
    <label class="form-label">البريد الإلكتروني</label>
    <input type="email" name="email" class="form-control mb-3" required>
    <label class="form-label">الرسالة</label>
    <textarea name="message" rows="4" class="form-control mb-3" required></textarea>
    <button class="btn btn-accent w-100">إرسال الرسالة</button>
  </form>
</div>
<?php require 'includes/footer.php'; ?>
