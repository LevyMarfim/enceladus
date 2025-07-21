import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['template', 'container'];
    
    connect() {
        this.index = this.containerTarget.querySelectorAll('.fee-item').length;
    }

    addItem(event) {
        event.preventDefault();
        
        // Get current tax types
        const existingTypes = Array.from(
            this.containerTarget.querySelectorAll('select[id$="_type"]')
        ).map(select => select.value);
        
        // Get prototype content
        const content = this.templateTarget.innerHTML
            .replace(/__name__/g, this.index);
        
        // Create temporary element to parse the new item
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = content;
        const newTypeSelect = tempDiv.querySelector('select[id$="_type"]');
        
        // Check if this type already exists
        // if (existingTypes.includes(newTypeSelect.value)) {
        //     alert('Este tipo de taxa já foi adicionado. Por favor escolha outro tipo.');
        //     return;
        // }
        
        // Add the new item
        this.containerTarget.insertAdjacentHTML('beforeend', content);
        this.index++;
    }

    removeItem(event) {
        event.preventDefault();
        const item = event.target.closest('.fee-item');
        item.remove();
    }

    checkDuplicate(event) {
        const select = event.target;
        const currentValue = select.value;
        const allSelects = this.containerTarget.querySelectorAll('select[id$="_type"]');
        
        let duplicates = 0;
        allSelects.forEach(s => {
            if (s !== select && s.value === currentValue) {
                duplicates++;
            }
        });

        if (duplicates > 0) {
            const errorDiv = document.getElementById('fee-errors');
            errorDiv.textContent = 'Este tipo de taxa já foi adicionado.';
            errorDiv.classList.remove('d-none');
            select.classList.add('is-invalid');
        } else {
            document.getElementById('fee-errors').classList.add('d-none');
            select.classList.remove('is-invalid');
        }
    }
}