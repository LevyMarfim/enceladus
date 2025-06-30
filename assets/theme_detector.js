(function() {
    const savedTheme = localStorage.getItem('theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme) {
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
    } else {
        document.documentElement.setAttribute('data-bs-theme', systemDark ? 'dark' : 'light');
    }
})();