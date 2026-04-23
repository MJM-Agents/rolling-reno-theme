(() => {
  const root = document.documentElement;
  const body = document.body;
  const header = document.querySelector('.site-header');

  if (!header || !body) {
    return;
  }

  const adminBarHeight = () => {
    const adminBar = document.getElementById('wpadminbar');
    return adminBar ? adminBar.offsetHeight : 0;
  };

  const setHeaderOffset = () => {
    const headerHeight = header.offsetHeight;
    root.style.setProperty('--header-height', `${headerHeight}px`);
    root.style.setProperty('--admin-bar-height', `${adminBarHeight()}px`);
  };

  const updateScrollState = () => {
    header.classList.toggle('is-scrolled', window.scrollY > 12);
  };

  const updateHeaderLayout = () => {
    window.requestAnimationFrame(() => {
      setHeaderOffset();
      updateScrollState();
    });
  };

  updateHeaderLayout();
  window.addEventListener('load', updateHeaderLayout);
  window.addEventListener('resize', updateHeaderLayout);
  window.addEventListener('orientationchange', updateHeaderLayout);
  window.addEventListener('scroll', updateScrollState, { passive: true });
})();
