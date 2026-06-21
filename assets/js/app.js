(() => {
  const body = document.body;
  const toggle = document.getElementById('accessibilityToggle');
  const panel = document.getElementById('accessibilityPanel');
  const savedMode = localStorage.getItem('domsfera-accessibility') === 'on';
  const savedSize = Number(localStorage.getItem('domsfera-font-size') || 16);
  const savedSpacing = localStorage.getItem('domsfera-spacing') === 'wide';
  function applyMode(enabled) {
    body.classList.toggle('accessibility-mode', enabled);
    if (toggle) {
      toggle.setAttribute('aria-pressed', enabled ? 'true' : 'false');
      toggle.textContent = enabled ? 'Обычная версия' : 'Версия для слабовидящих';
    }
    if (panel) panel.hidden = !enabled;
  }
  document.documentElement.style.setProperty('--base-font', `${Math.min(22, Math.max(14, savedSize))}px`);
  body.classList.toggle('wide-spacing', savedSpacing);
  applyMode(savedMode);
  toggle?.addEventListener('click', () => {
    const enabled = !body.classList.contains('accessibility-mode');
    localStorage.setItem('domsfera-accessibility', enabled ? 'on' : 'off');
    applyMode(enabled);
  });
  document.querySelectorAll('[data-font]').forEach(btn => btn.addEventListener('click', () => {
    let size = parseInt(getComputedStyle(document.documentElement).fontSize, 10);
    if (btn.dataset.font === 'increase') size += 2;
    if (btn.dataset.font === 'decrease') size -= 2;
    if (btn.dataset.font === 'reset') size = 16;
    size = Math.min(22, Math.max(14, size));
    document.documentElement.style.setProperty('--base-font', `${size}px`);
    localStorage.setItem('domsfera-font-size', String(size));
  }));
  document.querySelector('[data-spacing="toggle"]')?.addEventListener('click', () => {
    body.classList.toggle('wide-spacing');
    localStorage.setItem('domsfera-spacing', body.classList.contains('wide-spacing') ? 'wide' : 'normal');
  });
})();
