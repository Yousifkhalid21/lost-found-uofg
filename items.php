<?php
require_once 'includes/auth.php';
$title = 'المفقودات';
$q = trim($_GET['q'] ?? '');
$type = $_GET['type'] ?? '';
$facRaw = $_GET['faculty'] ?? '';
$fac = (int)$facRaw;
$faculties = $pdo->query('SELECT id, name FROM faculties ORDER BY id')->fetchAll();

$sql = 'SELECT i.*, f.name AS faculty_name FROM items i LEFT JOIN faculties f ON f.id = i.faculty_id WHERE i.status = \'open\'';
$params = [];
if ($q !== '') { $sql .= ' AND (i.title LIKE ? OR i.place LIKE ? OR i.description LIKE ?)'; array_push($params, "%$q%", "%$q%", "%$q%"); }
if (in_array($type, ['lost', 'found'])) { $sql .= ' AND i.type = ?'; $params[] = $type; }
if ($facRaw === 'other') { $sql .= ' AND i.faculty_id IS NULL'; }
elseif ($fac > 0) { $sql .= ' AND i.faculty_id = ?'; $params[] = $fac; }
$stmt = $pdo->prepare($sql . ' ORDER BY i.id DESC');
$stmt->execute($params);
$items = $stmt->fetchAll();
require 'includes/header.php';
?>
<h2 class="mb-3">الأغراض المنشورة</h2>
<form method="get" class="row g-2 mb-4">
  <div class="col-12 col-md-6"><input type="text" name="q" value="<?= htmlspecialchars($q) ?>" class="form-control" placeholder="ابحث بالاسم أو المكان"></div>
  <div class="col-12 col-md-4">
    <select name="faculty" class="form-select">
      <option value="">كل الكليات</option>
      <?php foreach ($faculties as $f): ?>
        <option value="<?= $f['id'] ?>" <?= $fac == $f['id'] ? 'selected' : '' ?>><?= htmlspecialchars($f['name']) ?></option>
      <?php endforeach; ?>
      <option value="other" <?= $facRaw === 'other' ? 'selected' : '' ?>>مكان آخر</option>
    </select>
  </div>
  <div class="col-12 col-md-2"><button class="btn btn-accent w-100">بحث</button></div>
</form>
<div class="row g-3">
  <?php foreach ($items as $it) include 'includes/card.php'; ?>
  <?php if (!$items): ?><p class="text-muted">لا توجد نتائج مطابقة. جرّب كلمة أخرى.</p><?php endif; ?>
</div>
<?php require 'includes/footer.php'; ?>
