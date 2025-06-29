// assets/controllers/theme_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['icon'];
    
    initialize() {
        this.setupSystemThemeListener();
        this.updateIcon();
    }
    
    connect() {
        // Ensure theme is set
        if (!document.documentElement.hasAttribute('data-bs-theme')) {
            this.setTheme(this.getPreferredTheme());
        }
    }
    
    disconnect() {
        this.cleanupSystemThemeListener();
    }
    
    toggle() {
        const currentTheme = this.getCurrentTheme();
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
        localStorage.setItem('theme', newTheme);
    }
    
    setTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        this.updateIcon();
    }
    
    getCurrentTheme() {
        return document.documentElement.getAttribute('data-bs-theme');
    }
    
    getPreferredTheme() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) return savedTheme;
        
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    
    updateIcon() {
        if (!this.hasIconTarget) return;
        
        const theme = this.getCurrentTheme();
        this.iconTarget.classList.toggle('bi-sun', theme === 'dark');
        this.iconTarget.classList.toggle('bi-moon', theme === 'light');
    }
    
    setupSystemThemeListener() {
        // Only listen if no manual preference set
        if (localStorage.getItem('theme')) return;
        
        this.systemThemeListener = (e) => {
            this.setTheme(e.matches ? 'dark' : 'light');
        };
        
        window.matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', this.systemThemeListener);
    }
    
    cleanupSystemThemeListener() {
        if (this.systemThemeListener) {
            window.matchMedia('(prefers-color-scheme: dark)')
                .removeEventListener('change', this.systemThemeListener);
        }
    }
}