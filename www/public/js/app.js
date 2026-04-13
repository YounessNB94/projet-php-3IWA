const applyTheme = (theme) => {
  document.body.classList.remove('theme-contrast', 'theme-dark');
  if (theme) {
    document.body.classList.add(theme);
  }
};

const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
  applyTheme(savedTheme);
}

document.addEventListener('click', (event) => {
  const toggle = event.target.closest('[data-toggle]');
  if (!toggle) {
    return;
  }

  const targetId = toggle.getAttribute('data-toggle');
  const target = document.getElementById(targetId);
  if (!target) {
    return;
  }

  target.classList.toggle('is-open');
});

const themeToggle = document.querySelector('[data-theme-toggle]');
if (themeToggle) {
  themeToggle.checked = savedTheme === 'theme-dark';
  themeToggle.addEventListener('change', (event) => {
    const theme = event.target.checked ? 'theme-dark' : 'theme-contrast';
    applyTheme(theme);
    localStorage.setItem('theme', theme);
  });
}

document.addEventListener('click', (event) => {
  const trigger = event.target.closest('[data-accordion]');
  if (!trigger) {
    return;
  }

  const targetId = trigger.getAttribute('data-accordion');
  const panel = document.getElementById(targetId);
  if (!panel) {
    return;
  }

  panel.classList.toggle('is-open');
});

document.addEventListener('click', (event) => {
  const toggle = event.target.closest('[data-nav-toggle]');
  if (!toggle) {
    return;
  }

  const panel = document.querySelector('[data-nav-panel]');
  if (!panel) {
    return;
  }

  panel.classList.toggle('is-open');
  const expanded = panel.classList.contains('is-open');
  toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
});
