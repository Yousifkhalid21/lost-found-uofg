<?php require_once __DIR__ . '/db.php';
$page = basename($_SERVER['PHP_SELF']);
$links = [
  'index.php'    => ['الرئيسية',   'bi-house'],
  'items.php'    => ['المفقودات',  'bi-search'],
  'add-item.php' => ['إضافة غرض',  'bi-plus-circle'],
  'returned.php' => ['تم تسليمها',  'bi-check2-circle'],
  'contact.php'  => ['تواصل معنا', 'bi-chat-dots'],
];
$logged = isset($_SESSION['user_id']);
if (!$logged) { $links = array_intersect_key($links, array_flip(['index.php', 'contact.php'])); }
$uname  = $logged ? $_SESSION['name'] : '';
$initial = $logged ? mb_substr($uname, 0, 1, 'UTF-8') : '';
// الشعار: شعار جامعة الجزيرة للزائر، وشعار الكلية بعد تسجيل الدخول
$siteLogo = 'assets/logo.png';
$logoAlt  = 'شعار جامعة الجزيرة';
$subTitle = 'جامعة الجزيرة';
$slug = $_SESSION['faculty_slug'] ?? '';
if ($logged && $slug && preg_match('/^[a-z]+$/', $slug) && file_exists(__DIR__ . "/../assets/faculties/$slug.png")) {
    $siteLogo = "assets/faculties/$slug.png";
    $logoAlt  = 'شعار ' . $_SESSION['faculty_name'];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'الرئيسية') ?> | مفقوداتي الجامعية</title>
  <link rel="icon" href="assets/logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/style.css?v=11">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark site-nav">
  <div class="container position-relative">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <span class="brand-logo"><img src="<?= $siteLogo ?>" alt="<?= htmlspecialchars($logoAlt) ?>"></span>
      <span class="brand-text">مفقوداتي الجامعية<small><?= htmlspecialchars($subTitle) ?></small></span>
    </a>
    <button class="menu-toggle d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="القائمة">
      <span></span><span></span><span></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <div class="menu-card">
        <?php if ($logged): ?>
          <div class="menu-user d-lg-none">
            <span class="menu-avatar"><?= htmlspecialchars($initial) ?></span>
            <div class="menu-user-info">
              <strong><?= htmlspecialchars($uname) ?></strong>
              <?php if (!empty($_SESSION['email'])): ?><small><?= htmlspecialchars($_SESSION['email']) ?></small><?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
        <ul class="navbar-nav me-auto">
          <?php foreach ($links as $file => [$label, $icon]): ?>
            <li class="nav-item">
              <a class="nav-link<?= $page === $file ? ' active' : '' ?>" href="<?= $file ?>"<?= $page === $file ? ' aria-current="page"' : '' ?>>
                <i class="bi <?= $icon ?>"></i><span><?= $label ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="menu-actions">
          <?php if ($logged): ?>
            <span class="nav-hello d-none d-xl-inline">أهلًا، <?= htmlspecialchars($uname) ?></span>
            <a class="btn btn-outline-light btn-sm menu-logout" href="logout.php"><i class="bi bi-box-arrow-left"></i><span>تسجيل الخروج</span></a>
          <?php else: ?>
            <a class="btn btn-accent btn-sm menu-login" href="login.php"><i class="bi bi-box-arrow-in-left"></i><span>تسجيل الدخول</span></a>
            <a class="menu-register d-lg-none" href="register.php"><i class="bi bi-person-plus"></i><span>إنشاء حساب جديد</span></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</nav>
<main class="container py-4">
