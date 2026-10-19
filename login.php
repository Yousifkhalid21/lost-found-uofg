<?php
require_once 'includes/db.php';
if (isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
$title = 'تسجيل الدخول';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('SELECT u.*, f.name AS faculty_name, f.slug AS faculty_slug
                           FROM users u LEFT JOIN faculties f ON f.id = u.faculty_id
                           WHERE u.email = ?');
    $stmt->execute([trim($_POST['email'] ?? '')]);
    $u = $stmt->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['name'] = $u['name'];
        $_SESSION['email'] = $u['email'];
        $_SESSION['faculty_name'] = $u['faculty_name'];
        $_SESSION['faculty_slug'] = $u['faculty_slug'];
        header('Location: index.php');
        exit;
    }
    $error = 'البريد الإلكتروني أو كلمة المرور غير صحيحة.';
}
require 'includes/header.php';
?>
<div class="form-box">
  <h3 class="mb-3">تسجيل الدخول</h3>
  <?php if (isset($_GET['need'])): ?><div class="alert alert-info">سجّل دخولك أولًا للاستفادة من خدمات الموقع.</div><?php endif; ?>
  <?php if (isset($_GET['ok'])): ?><div class="alert alert-success">تم إنشاء حسابك، سجّل دخولك الآن.</div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <form method="post">
    <label class="form-label">البريد الإلكتروني</label>
    <input type="email" name="email" class="form-control mb-3" required>
    <label class="form-label">كلمة المرور</label>
    <input type="password" name="password" class="form-control mb-3" required>
    <button class="btn btn-accent w-100">دخول</button>
  </form>
  <p class="text-center mt-3 mb-0">ليس لديك حساب؟ <a href="register.php">أنشئ حسابًا</a></p>
</div>
<?php require 'includes/footer.php'; ?>
