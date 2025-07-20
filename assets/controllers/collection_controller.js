// assets/controllers/collection_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['template', 'item'];

    connect() {
        this.index = this.itemTargets.length;
    }

    addItem(event) {
        event.preventDefault();
        
        const content = this.templateTarget.innerHTML
            .replace(/__name__/g, this.index);
        
        this.element.insertAdjacentHTML('beforeend', content);
        this.index++;
    }

    removeItem(event) {
        event.preventDefault();
        const item = event.target.closest('.fee-item');
        item.remove();
    }
}