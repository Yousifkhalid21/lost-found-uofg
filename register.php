<?php
require_once 'includes/db.php';
if (isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
$title = 'إنشاء حساب';
$error = '';
$faculties = $pdo->query('SELECT id, name FROM faculties ORDER BY id')->fetchAll();
$facultyIds = array_column($faculties, 'id');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $faculty = (int)($_POST['faculty_id'] ?? 0);
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
        $error = 'تأكد من الاسم والبريد، وكلمة المرور 6 أحرف على الأقل.';
    } elseif (!in_array($faculty, $facultyIds)) {
        $error = 'اختر كليتك من القائمة.';
    } else {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $check->execute([$email]);
        if ($check->fetch()) {
            $error = 'هذا البريد مسجّل مسبقًا.';
        } else {
            $pdo->prepare('INSERT INTO users (name, email, password, faculty_id) VALUES (?,?,?,?)')
                ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT), $faculty]);
            header('Location: login.php?ok=1');
            exit;
        }
    }
}
require 'includes/header.php';
?>
<div class="form-box">
  <h3 class="mb-3">إنشاء حساب</h3>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <form method="post" id="registerForm">
    <label class="form-label">الاسم</label>
    <input name="name" class="form-control mb-3" required>
    <label class="form-label">البريد الإلكتروني</label>
    <input type="email" name="email" class="form-control mb-3" required>
    <label class="form-label">الكلية</label>
    <select name="faculty_id" class="form-select mb-3" required>
      <option value="" selected disabled>اختر كليتك</option>
      <?php foreach ($faculties as $f): ?>
        <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['name']) ?></option>
      <?php endforeach; ?>
    </select>
    <label class="form-label">كلمة المرور</label>
    <input type="password" name="password" id="password" class="form-control mb-3" minlength="6" required>
    <label class="form-label">تأكيد كلمة المرور</label>
    <input type="password" id="password2" class="form-control mb-3" required>
    <button class="btn btn-accent w-100">إنشاء الحساب</button>
  </form>
</div>
<?php require 'includes/footer.php'; ?>
