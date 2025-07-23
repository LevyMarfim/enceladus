import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['template', 'container'];
    
    connect() {
        this.index = this.containerTarget.querySelectorAll('.fee-item').length;
        this.updateSelectOptions();
    }

    addItem(event) {
        event.preventDefault();
        
        // Check if there are any available tax types left
        const availableTypes = this.getAvailableTypes();
        if (availableTypes.length === 0) {
            alert('Todos os tipos de taxa já foram adicionados.');
            return;
        }
        
        const content = this.templateTarget.innerHTML.replace(/__name__/g, this.index);
        this.containerTarget.insertAdjacentHTML('beforeend', content);
        this.index++;
        this.updateSelectOptions();
    }

    removeItem(event) {
        event.preventDefault();
        const item = event.target.closest('.fee-item');
        item.remove();
        this.updateSelectOptions();
    }

    updateSelectOptions() {
        const selectedTypes = this.getSelectedTypes();
        
        this.containerTarget.querySelectorAll('select[id$="_type"]').forEach(select => {
            const currentValue = select.value;
            
            Array.from(select.options).forEach(option => {
                // Disable if selected elsewhere, but keep current value enabled
                option.disabled = selectedTypes.includes(option.value) && option.value !== currentValue;
                
                // Special handling for first option (empty/default)
                if (option.value === "" && currentValue !== "") {
                    option.disabled = true;
                }
            });
            
            // If current selection is invalid (duplicate), reset it
            if (currentValue && selectedTypes.filter(t => t === currentValue).length > 1) {
                select.value = "";
                select.dispatchEvent(new Event('change'));
            }
        });
    }

    getSelectedTypes() {
        return Array.from(
            this.containerTarget.querySelectorAll('select[id$="_type"]')
        ).map(select => select.value)
         .filter(value => value !== ""); // Exclude empty selections
    }

    getAvailableTypes() {
        const allTypes = ["Impostos", "Taxa liquidação", "Taxa operacional", "Taxa custódia"];
        const selectedTypes = this.getSelectedTypes();
        return allTypes.filter(type => !selectedTypes.includes(type));
    }

    validateAmount(event) {
        // Safely get the input element
        const input = event?.target;
        if (!input || !input.isConnected) return;  // Check if element still exists
        
        try {
            let value = input.value;
            const cursorPosition = input.selectionStart;
            
            // 1. Remove all non-digit and non-decimal characters
            value = value.replace(/[^\d.]/g, '');
            
            // 2. Handle leading decimal
            if (value.startsWith('.')) {
                value = '0' + value;
                if (cursorPosition === 1) {
                    setTimeout(() => input.setSelectionRange(2, 2), 0);
                }
            }
            
            // 3. Handle multiple decimals
            const decimalParts = value.split('.');
            if (decimalParts.length > 2) {
                value = decimalParts[0] + '.' + decimalParts.slice(1).join('');
            }
            
            // 4. Limit to 2 decimal places
            if (value.includes('.')) {
                const [whole, decimal] = value.split('.');
                value = whole + '.' + (decimal?.substring(0, 2) || '');
            }
            
            // Only update if value changed
            if (input.value !== value) {
                input.value = value;
                // Use setTimeout to ensure DOM is ready for selection
                setTimeout(() => {
                    if (input.isConnected) {
                        const newPos = Math.min(cursorPosition + (value.length - input.value.length), value.length);
                        input.setSelectionRange(newPos, newPos);
                    }
                }, 0);
            }
        } catch (error) {
            console.warn('Validation error:', error);
        }
    }
}