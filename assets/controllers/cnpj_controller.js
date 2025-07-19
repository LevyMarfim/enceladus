import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input']

    connect() {
        if (this.hasInputTarget) {
            this.inputTarget.addEventListener('input', this.maskCnpj.bind(this));
        }
    }

    maskCnpj(event) {
        let value = event.target.value.replace(/\D/g, '');
        
        if (value.length <= 2) {
            event.target.value = value;
        } else if (value.length <= 5) {
            event.target.value = value.substring(0, 2) + '.' + value.substring(2);
        } else if (value.length <= 8) {
            event.target.value = value.substring(0, 2) + '.' + value.substring(2, 5) + '.' + value.substring(5);
        } else if (value.length <= 12) {
            event.target.value = value.substring(0, 2) + '.' + value.substring(2, 5) + '.' + value.substring(5, 8) + '/' + value.substring(8);
        } else {
            event.target.value = value.substring(0, 2) + '.' + value.substring(2, 5) + '.' + value.substring(5, 8) + '/' + value.substring(8, 12) + '-' + value.substring(12, 14);
        }
    }
}