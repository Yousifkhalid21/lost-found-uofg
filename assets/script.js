// 1) التحقق من تطابق كلمتي المرور في صفحة إنشاء الحساب
const regForm = document.getElementById('registerForm');
if (regForm) {
  regForm.addEventListener('submit', (e) => {
    const p1 = document.getElementById('password').value;
    const p2 = document.getElementById('password2').value;
    if (p1 !== p2) { e.preventDefault(); alert('كلمتا المرور غير متطابقتين'); }
  });
}
// 2) إخفاء رسائل التنبيه تلقائيًا بعد 5 ثوانٍ
setTimeout(() => document.querySelectorAll('.alert').forEach(a => a.remove()), 5000);
// 3) إغلاق القائمة المنسدلة عند الضغط خارجها (في الجوال)
document.addEventListener('click', (e) => {
  const menu = document.getElementById('menu');
  if (menu && menu.classList.contains('show') && !e.target.closest('.navbar')) {
    bootstrap.Collapse.getOrCreateInstance(menu).hide();
  }
});
