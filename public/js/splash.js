window.addEventListener('load', () => {
  const splash = document.getElementById('splash');
  const mainContent = document.getElementById('main-content');

  setTimeout(() => {
    splash.style.display = 'none';
    mainContent.style.display = 'block';
    setTimeout(() => {
      mainContent.style.opacity = 1;
    }, 50);
  }, 4000); // 4 secondes
});