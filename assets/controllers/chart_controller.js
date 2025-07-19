import { Controller } from '@hotwired/stimulus';
import { Chart } from 'chart.js';

export default class extends Controller {
    static values = { data: Object }
    static targets = ["canvas", "filterForm"]  // Both targets declared

    connect() {
        this.initializeChart();
        this.setupEventListeners();
    }

    initializeChart() {
        this.chart = new Chart(this.canvasTarget, {
            type: 'bar',
            data: this.dataValue,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => 'R$ ' + context.raw.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => 'R$ ' + value.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                        }
                    }
                }
            }
        });
    }

    setupEventListeners() {
        if (this.hasFilterFormTarget) {
            this.filterFormTarget.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', this.debouncedUpdate.bind(this));
            });
        }
    }

    debouncedUpdate = this.debounce(() => this.updateChart(), 100);

    debounce(func, timeout) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), timeout);
        };
    }

    async updateChart() {
        if (!this.hasFilterFormTarget) return;

        const formData = new FormData(this.filterFormTarget);
        const params = new URLSearchParams(formData).toString();

        try {
            const response = await fetch(`${window.location.pathname}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            
            this.chart.data = data.chartData;
            this.chart.update();
        } catch (error) {
            console.error('Chart update failed:', error);
        }
    }

    disconnect() {
        if (this.chart) {
            this.chart.destroy();
        }
    }
}