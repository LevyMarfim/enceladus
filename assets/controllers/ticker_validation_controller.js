import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input', 'feedback'];

    connect() {
        this.validate();
    }

    validate() {
        const value = this.inputTarget.value;
        
        // Remove any non-alphanumeric characters
        let cleanValue = value.replace(/[^A-Za-z0-9]/g, '');
        
        // Separate letters and numbers
        let letters = cleanValue.match(/[A-Za-z]+/) ? cleanValue.match(/[A-Za-z]+/)[0] : '';
        let numbers = cleanValue.match(/\d+/) ? cleanValue.match(/\d+/)[0] : '';
        
        // Limit letters to 4 and numbers to 2
        letters = letters.substring(0, 4).toUpperCase();
        numbers = numbers.substring(0, 2);
        
        // Reconstruct the value
        this.inputTarget.value = letters + numbers;
        
        // Validate the format
        const isValid = /^[A-Z]{4}\d{1,2}$/.test(this.inputTarget.value);
        this.inputTarget.setCustomValidity(isValid ? '' : 'Invalid ticker format');
        
        // Show/hide feedback
        if (this.inputTarget.value.length > 0 && !isValid) {
            this.inputTarget.classList.add('is-invalid');
            this.feedbackTarget.style.display = 'block';
        } else {
            this.inputTarget.classList.remove('is-invalid');
            this.feedbackTarget.style.display = 'none';
        }
    }

    handleSubmit(event) {
        this.validate();
        if (!this.inputTarget.checkValidity()) {
            event.preventDefault();
            this.inputTarget.classList.add('is-invalid');
            this.feedbackTarget.style.display = 'block';
            this.inputTarget.focus();
        }
    }
}