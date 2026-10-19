<?php
// صفحة الأغراض التي تم تسليمها لأصحابها (لا تُحذف من الموقع)
require_once 'includes/auth.php';
$title = 'تم تسليمها';
$items = $pdo->query("SELECT i.*, f.name AS faculty_name FROM items i LEFT JOIN faculties f ON f.id = i.faculty_id WHERE i.status = 'returned' ORDER BY i.returned_at DESC")->fetchAll();
require 'includes/header.php';
?>
<h2 class="mb-2">أغراض عادت إلى أصحابها</h2>
<p class="returned-intro mb-4">هنا الأغراض التي تم العثور عليها وتسليمها لأصحابها، شكرًا لكل من ساعد 💚 في ميزان حسناتكم إن شاء الله.</p>
<div class="row g-3">
  <?php foreach ($items as $it) include 'includes/card.php'; ?>
  <?php if (!$items): ?><p class="text-muted">لا توجد أغراض مسلّمة بعد.</p><?php endif; ?>
</div>
<?php require 'includes/footer.php'; ?>
