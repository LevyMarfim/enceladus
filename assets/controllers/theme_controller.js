// assets/controllers/theme_controller.js - Alternative approach
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['lightIcon', 'darkIcon'];
    
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
        if (!this.hasLightIconTarget || !this.hasDarkIconTarget) return;
        
        const theme = this.getCurrentTheme();
        
        if (theme === 'dark') {
            // Show light icon when in dark mode (to switch to light)
            this.lightIconTarget.classList.remove('d-none');
            this.darkIconTarget.classList.add('d-none');
        } else {
            // Show dark icon when in light mode (to switch to dark)
            this.lightIconTarget.classList.add('d-none');
            this.darkIconTarget.classList.remove('d-none');
        }
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