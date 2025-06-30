// assets/controllers/sidebar_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['content', 'toggleIcon'];
    static classes = ['collapsed'];
    
    connect() {
        this.collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        this.updateState();
    }
    
    toggle() {
        this.collapsed = !this.collapsed;
        localStorage.setItem('sidebarCollapsed', this.collapsed);
        this.updateState();
    }
    
    toggleMobile() {
        this.element.classList.toggle('active');
        document.body.style.overflow = this.element.classList.contains('active') ? 'hidden' : '';
    }
    
    updateState() {
        // Toggle collapsed class on both sidebar and content
        this.element.classList.toggle(this.collapsedClass, this.collapsed);
        this.contentTarget.classList.toggle(this.collapsedClass, this.collapsed);
        
        // Update toggle icon
        if (this.hasToggleIconTarget) {
            this.toggleIconTarget.classList.toggle('bi-chevron-left', !this.collapsed);
            this.toggleIconTarget.classList.toggle('bi-chevron-right', this.collapsed);
        }
    }
}