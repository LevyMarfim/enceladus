import { Controller } from '@hotwired/stimulus';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

export default class extends Controller {
    connect() {
        flatpickr(this.element, {
            dateFormat: 'd/M/Y',
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
}