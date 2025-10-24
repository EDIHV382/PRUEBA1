// assets/js/layout-controller.js

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const sidebar = document.getElementById('sidebar');
    const pageContent = document.getElementById('page-content');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeIcon = document.getElementById('darkModeIcon');

    if (sidebarToggle && sidebar && pageContent) {
        const toggleSidebar = () => {
            sidebar.classList.toggle('collapsed');
            pageContent.classList.toggle('sidebar-hidden');
        };
        sidebarToggle.addEventListener('click', toggleSidebar);

        const checkWindowSize = () => {
            if (window.innerWidth < 992 && !sidebar.classList.contains('collapsed')) {
                toggleSidebar();
            }
        };
        checkWindowSize();
        window.addEventListener('resize', checkWindowSize);
    }
    
    if (darkModeToggle && darkModeIcon) {
        const applyTheme = (isDark) => {
            if (isDark) {
                body.classList.add('dark-mode');
                darkModeIcon.classList.remove('mdi-weather-night');
                darkModeIcon.classList.add('mdi-white-balance-sunny');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                body.classList.remove('dark-mode');
                darkModeIcon.classList.remove('mdi-white-balance-sunny');
                darkModeIcon.classList.add('mdi-weather-night');
                localStorage.setItem('darkMode', 'disabled');
            }
        };

        const toggleDarkMode = () => {
            const isCurrentlyDark = body.classList.contains('dark-mode');
            applyTheme(!isCurrentlyDark);
        };
        darkModeToggle.addEventListener('click', toggleDarkMode);
        
        const savedMode = localStorage.getItem('darkMode');
        applyTheme(savedMode === 'enabled');
    }
});