document.addEventListener('DOMContentLoaded', () => {
    // Theme Management
    const themeManager = {
        currentTheme: localStorage.getItem('selectedTheme') || 'default',
        themes: ['default', 'children', 'youth', 'adults', 'night'],

        init() {
            this.applyTheme(this.currentTheme);
            this.setupThemeTogglers();
        },

        applyTheme(theme) {
            // Remove all theme classes
            this.themes.forEach(t => {
                document.body.classList.remove(`theme-${t}`);
            });

            // Add selected theme if not default
            if (theme !== 'default') {
                document.body.classList.add(`theme-${theme}`);
            }

            // Save to local storage
            localStorage.setItem('selectedTheme', theme);
            this.currentTheme = theme;
        },

        setupThemeTogglers() {
            const themeTogglers = document.querySelectorAll('[data-theme]');
            themeTogglers.forEach(toggler => {
                toggler.addEventListener('click', (e) => {
                    e.preventDefault();
                    const theme = toggler.getAttribute('data-theme');
                    this.applyTheme(theme);
                });
            });
        }
    };

    // Sidebar Management
    const sidebarManager = {
        sidebar: document.querySelector('.sidebar'),
        toggleBtn: document.querySelector('.toggle-btn'),

        init() {
            this.setupToggleListener();
            this.restoreSidebarState();
        },

        setupToggleListener() {
            this.toggleBtn.addEventListener('click', () => {
                this.sidebar.classList.toggle('collapsed');
                this.saveSidebarState();
            });
        },

        saveSidebarState() {
            localStorage.setItem('sidebarCollapsed',
                this.sidebar.classList.contains('collapsed')
            );
        },

        restoreSidebarState() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                this.sidebar.classList.add('collapsed');
            }
        }
    };

    // User Interaction Tracking (optional, can be removed if not needed)
    const userInteractionTracker = {
        init() {
            this.trackMenuItemClicks();
            this.trackThemeChanges();
        },

        trackMenuItemClicks() {
            const menuItems = document.querySelectorAll('.sidebar .nav-link');
            menuItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    const itemText = item.querySelector('span')?.textContent || 'Unknown';
                    console.log(`Navigated to: ${itemText}`);
                    // You could send this to an analytics service
                });
            });
        },

        trackThemeChanges() {
            const originalTheme = localStorage.getItem('selectedTheme') || 'default';
            window.addEventListener('beforeunload', () => {
                const currentTheme = localStorage.getItem('selectedTheme') || 'default';
                if (currentTheme !== originalTheme) {
                    console.log(`Theme changed from ${originalTheme} to ${currentTheme}`);
                    // You could send this to an analytics service
                }
            });
        }
    };

    // Initialize all managers
    themeManager.init();
    sidebarManager.init();
    userInteractionTracker.init();
});
