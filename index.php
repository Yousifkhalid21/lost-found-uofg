<?php
require_once 'includes/db.php';
$title = 'الرئيسية';
$logged = isset($_SESSION['user_id']);
$items = $logged ? $pdo->query('SELECT i.*, f.name AS faculty_name FROM items i LEFT JOIN faculties f ON f.id = i.faculty_id WHERE i.status = \'open\' ORDER BY i.id DESC LIMIT 6')->fetchAll() : [];
require 'includes/header.php';
?>
<?php if (!$logged): ?>
<!-- واجهة الزائر: تسجيل الدخول أولًا -->
<section class="hero hero-guest mb-4">
  <img src="assets/logo.png" alt="شعار جامعة الجزيرة" class="hero-logo">
  <h1>فقدت شيئًا في الجامعة؟ أو وجدت شيئًا؟</h1>
  <p class="lead">مفقوداتي الجامعية تجمع طلاب الجامعة في مكان واحد ليعود كل غرض إلى صاحبه.</p>
  <div class="guest-cta">
    <p class="guest-note"><i class="bi bi-lock"></i> سجّل دخولك للاستفادة من الخدمة</p>
    <div class="guest-buttons">
      <a href="login.php" class="btn btn-accent btn-lg"><i class="bi bi-box-arrow-in-left"></i> تسجيل الدخول</a>
      <a href="register.php" class="btn btn-glass btn-lg"><i class="bi bi-person-plus"></i> إنشاء حساب جديد</a>
    </div>
  </div>
</section>

<?php else: ?>
<!-- واجهة المستخدم بعد تسجيل الدخول -->
<section class="hero mb-5">
  <img src="<?= $siteLogo ?>" alt="<?= htmlspecialchars($logoAlt) ?>" class="hero-logo">
  <p class="hero-hello">أهلًا، <?= htmlspecialchars($_SESSION['name']) ?> 👋<?php if (!empty($_SESSION['faculty_name'])): ?><span class="hero-faculty"><?= htmlspecialchars($_SESSION['faculty_name']) ?></span><?php endif; ?></p>
  <h1>فقدت شيئًا في الجامعة؟ أو وجدت شيئًا؟</h1>
  <p class="lead">ابحث بين الأغراض المنشورة، أو انشر إعلانك ليصل إلى صاحبه.</p>
  <form action="items.php" method="get" class="row g-2 justify-content-center">
    <div class="col-12 col-md-6"><input type="text" name="q" class="form-control form-control-lg" placeholder="ابحث: محفظة، مفاتيح، هاتف..."></div>
    <div class="col-12 col-md-auto"><button class="btn btn-accent btn-lg w-100">بحث</button></div>
  </form>
  <div class="hero-quick">
    <a href="add-item.php" class="btn btn-glass"><i class="bi bi-plus-circle"></i> أضف غرضًا</a>
    <a href="items.php" class="btn btn-glass"><i class="bi bi-grid"></i> كل المفقودات</a>
  </div>
</section>

<h3 class="mb-3">آخر الأغراض</h3>
<div class="row g-3">
  <?php foreach ($items as $it) include 'includes/card.php'; ?>
  <?php if (!$items): ?><p class="text-muted">لا توجد أغراض منشورة بعد. <a href="add-item.php">كن أول من ينشر</a>.</p><?php endif; ?>
</div>
<?php if ($items): ?><div class="text-center mt-3"><a href="items.php" class="btn btn-outline-primary">عرض كل الأغراض</a></div><?php endif; ?>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
