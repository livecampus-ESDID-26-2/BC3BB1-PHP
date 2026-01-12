document.addEventListener('DOMContentLoaded', () => {
  // Petit clin d’œil: effet sur le bouton
  const btn = document.querySelector('.btn-primary');
  if (btn) {
    btn.addEventListener('click', () => {
      btn.style.transform = 'scale(0.98)';
      setTimeout(() => (btn.style.transform = 'scale(1)'), 120);
    });
  }
});
