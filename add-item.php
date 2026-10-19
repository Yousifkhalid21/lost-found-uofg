<?php
require_once 'includes/auth.php';

$title = 'إضافة غرض';
$error = '';
$faculties = $pdo->query('SELECT id, name FROM faculties ORDER BY id')->fetchAll();
$facultyIds = array_column($faculties, 'id');
$myFaculty = $pdo->prepare('SELECT faculty_id FROM users WHERE id = ?');
$myFaculty->execute([$_SESSION['user_id']]);
$myFaculty = (int)$myFaculty->fetchColumn();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t = $_POST['type'] ?? '';
    $name = trim($_POST['title'] ?? '');
    $place = trim($_POST['place'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $image = null;
    // "other" = خارج الكليات (مكتبة، ساحة، كافتيريا...) ويُحفظ في القاعدة كـ NULL
    $facRaw = $_POST['faculty_id'] ?? '';
    $fac = $facRaw === 'other' ? null : (int)$facRaw;

    if (!in_array($t, ['lost', 'found']) || $name === '' || $place === '' || $contact === '' || ($fac !== null && !in_array($fac, $facultyIds))) {
        $error = 'املأ الحقول المطلوبة كلها.';
    } elseif (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']) && $_FILES['image']['size'] <= 2 * 1024 * 1024) {
            $image = uniqid('i_') . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
        } else {
            $error = 'الصورة يجب أن تكون jpg أو png أو webp، وحجمها أقل من 2 ميغابايت.';
        }
    }
    if (!$error) {
        $stmt = $pdo->prepare('INSERT INTO items (user_id, faculty_id, title, type, place, description, contact, image) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([$_SESSION['user_id'], $fac, $name, $t, $place, $desc, $contact, $image]);
        header('Location: items.php');
        exit;
    }
}
require 'includes/header.php';
?>
<div class="form-box">
  <h3 class="mb-3">إضافة غرض</h3>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <label class="form-label">نوع الإعلان</label>
    <select name="type" class="form-select mb-3" required>
      <option value="lost">فقدت غرضًا</option>
      <option value="found">وجدت غرضًا</option>
    </select>
    <label class="form-label">الكلية</label>
    <select name="faculty_id" class="form-select mb-3" required>
      <?php foreach ($faculties as $f): ?>
        <option value="<?= $f['id'] ?>" <?= $f['id'] == $myFaculty ? 'selected' : '' ?>><?= htmlspecialchars($f['name']) ?></option>
      <?php endforeach; ?>
      <option value="other">مكان آخر</option>
    </select>
    <label class="form-label">اسم الغرض</label>
    <input name="title" class="form-control mb-3" placeholder="مثال: محفظة سوداء" required>
    <label class="form-label">المكان</label>
    <input name="place" id="placeInput" class="form-control mb-3" list="placeSuggestions" autocomplete="off" placeholder="مثال: المكتبة، قاعة 12" required>
    <!-- ترشيحات تظهر عند الكتابة في خانة المكان -->
    <datalist id="placeSuggestions">
      <option value="كافتيريا الضو">
      <option value="مكتبة الرازي">
      <option value="ملعب السلة">
    </datalist>
    <label class="form-label">وصف (اختياري)</label>
    <textarea name="description" class="form-control mb-3" rows="3"></textarea>
    <label class="form-label">رقم أو بريد للتواصل</label>
    <input name="contact" class="form-control mb-3" required>
    <label class="form-label">صورة (اختيارية)</label>
    <input type="file" name="image" class="form-control mb-3" accept="image/*">
    <button class="btn btn-accent w-100">نشر الإعلان</button>
  </form>
</div>
<script>
// تغيير المثال في خانة المكان عند اختيار "مكان آخر"
(function () {
  var fac = document.querySelector('select[name="faculty_id"]');
  var place = document.getElementById('placeInput');
  function update() {
    place.placeholder = fac.value === 'other' ? 'مثال: كافتيريا الضو، مكتبة الرازي' : 'مثال: المكتبة، قاعة 12';
  }
  fac.addEventListener('change', update);
  update();
})();
</script>
<?php require 'includes/footer.php'; ?>
