import { Controller } from '@hotwired/stimulus';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

export default class extends Controller {
    static values = {
        altFormat: { type: String, default: 'Y-m-d' },
        altInput: { type: Boolean, default: false },
        dateFormat: { type: String, default: 'Y-m-d' },
        // minDate: { type: String, default: null },
        // maxDate: { type: String, default: null },
    }

    connect() {
        flatpickr(this.element, {
            dateFormat: this.dateFormatValue,
            altFormat: this.altFormatValue,
            altInput: this.altInputValue,
            // minDate: this.minDateValue,
            // maxDate: this.maxDateValue,
            allowInput: true,
            locale: {
                firstDayOfWeek: 0,
                weekdays: {
                    shorthand: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    longhand: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
                },
                months: {
                    shorthand: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dec'],
                    longhand: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                },
            }
        });
    }

    disconnect() {
        if (this.picker) {
            this.picker.destroy();
        }
    }
}