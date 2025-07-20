import { Controller } from '@hotwired/stimulus';
import { Chart } from 'chart.js';

export default class extends Controller {
    static values = { data: Object }
    static targets = ["canvas", "filterForm"]

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
                    legend: { display: false },
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
                select.addEventListener('change', () => this.debouncedUpdate());
            });
        }
    }

    debouncedUpdate = this.debounce(() => this.updateChart(), 300);

    debounce(func, timeout) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), timeout);
        };
    }

    async updateChart() {
        try {
            const formData = new FormData(this.filterFormTarget);
            const params = new URLSearchParams(formData);
            
            const response = await fetch(`?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new TypeError("Response wasn't JSON");
            }
            
            const data = await response.json();
            
            if (data.chartData) {
                this.chart.data = data.chartData;
                this.chart.update();
            }
        } catch (error) {
            console.error('Chart update error:', error);
        }
    }

    disconnect() {
        if (this.chart) {
            this.chart.destroy();
        }
    }
}