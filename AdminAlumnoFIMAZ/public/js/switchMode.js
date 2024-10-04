document.addEventListener('DOMContentLoaded', (event) => {
    const themeSwitcher = document.querySelector('.theme-controller');
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);
    document.body.classList.toggle('dark', currentTheme === 'dark');

    if (themeSwitcher) {
        themeSwitcher.checked = currentTheme === 'dark';

        themeSwitcher.addEventListener('change', () => {
            const newTheme = themeSwitcher.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            document.body.classList.toggle('dark', newTheme === 'dark');
            localStorage.setItem('theme', newTheme);
        });
    }
});
