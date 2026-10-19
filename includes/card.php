<?php // بطاقة غرض واحد، تحتاج المتغير $it ?>
<div class="col-12 col-sm-6 col-lg-4">
  <div class="card h-100 item-card">
    <?php if ($it['image']): ?>
      <img src="uploads/<?= htmlspecialchars($it['image']) ?>" class="card-img-top item-img" alt="<?= htmlspecialchars($it['title']) ?>">
    <?php else: ?>
      <div class="item-img no-img">📦</div>
    <?php endif; ?>
    <div class="card-body">
      <?php if (($it['status'] ?? 'open') === 'returned'): ?>
        <span class="badge bg-success"><i class="bi bi-check2-circle"></i> تم التسليم لصاحبه</span>
      <?php else: ?>
        <span class="badge bg-danger">مفقود</span>
      <?php endif; ?>
      <span class="badge bg-light text-dark border"><?= htmlspecialchars(!empty($it['faculty_name']) ? $it['faculty_name'] : 'مكان آخر') ?></span>
      <h5 class="card-title mt-2"><?= htmlspecialchars($it['title']) ?></h5>
      <p class="card-text text-muted small"><?= htmlspecialchars($it['description']) ?></p>
      <p class="mb-1 small">📍 <?= htmlspecialchars($it['place']) ?></p>
      <p class="mb-0 small">📞 <?= htmlspecialchars($it['contact']) ?></p>
      <?php // زر خاص بصاحب المنشور فقط: يُنقل الغرض إلى صفحة "تم تسليمها" ولا يُحذف ?>
      <?php if (($it['status'] ?? 'open') === 'open' && isset($_SESSION['user_id']) && $it['user_id'] == $_SESSION['user_id']): ?>
        <form method="post" action="mark-returned.php" class="mt-3" onsubmit="return confirm('هل تأكدت أن الغرض وصل إلى صاحبه؟ سيُنقل إلى صفحة «تم تسليمها».');">
          <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
          <button class="btn btn-returned btn-sm w-100"><i class="bi bi-check2-circle"></i> تم التسليم لصاحبه</button>
        </form>
      <?php endif; ?>
    </div>
    <div class="card-footer small text-muted">
      <?php if (($it['status'] ?? 'open') === 'returned' && !empty($it['returned_at'])): ?>
        سُلّم في <?= date('Y/m/d', strtotime($it['returned_at'])) ?>
      <?php else: ?>
        <?= date('Y/m/d', strtotime($it['created_at'])) ?>
      <?php endif; ?>
    </div>
  </div>
</div>
