<div>
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-3xl font-bold text-slate-800">Calendario de Consultas</h2>
        <a href="{{ route('consultation.new') }}" class="btn-primary flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            Nueva Consulta
        </a>
    </div>

    <div
        class="calendar-card overflow-hidden rounded-2xl border border-white/30 bg-white/50 p-6 shadow-xl backdrop-blur-md">
        <div id="calendar" wire:ignore></div>
    </div>

    @push('styles')
        <style>
            .fc {
                --fc-border-color: rgba(0, 0, 0, 0.05);
                --fc-daygrid-event-dot-width: 10px;
                --fc-today-bg-color: rgba(99, 102, 241, 0.05);
                font-family: 'Inter', sans-serif;
                background: transparent;
                min-height: 700px;
            }

            .fc .fc-toolbar-title {
                font-family: 'Outfit', sans-serif;
                font-size: 1.5rem;
                font-weight: 700;
                color: #1e293b;
            }

            .fc .fc-button-primary {
                background-color: white;
                border-color: #e2e8f0;
                color: #475569;
                font-weight: 600;
                text-transform: capitalize;
                border-radius: 10px;
                padding: 0.5rem 1rem;
                transition: all 0.2s;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            }

            .fc .fc-button-primary:hover {
                background-color: #f8fafc;
                border-color: #cbd5e1;
                color: #6366f1;
            }

            .fc .fc-button-primary:not(:disabled):active,
            .fc .fc-button-primary:not(:disabled).fc-button-active {
                background-color: #6366f1;
                border-color: #6366f1;
                color: white;
                box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
            }

            .fc-event {
                padding: 4px 8px;
                border-radius: 6px;
                font-size: 0.85rem;
                font-weight: 500;
                cursor: pointer;
                transition: transform 0.1s;
            }

            .fc-event:hover {
                transform: scale(1.02);
                filter: brightness(1.1);
            }

            .fc-theme-standard td,
            .fc-theme-standard th {
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            .fc-col-header-cell {
                padding: 12px 0 !important;
                background: rgba(248, 250, 252, 0.5);
                font-weight: 600;
                color: #64748b;
            }
        </style>
    @endpush

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Día'
                    },
                    events: @json($events),
                    eventClick: function (info) {
                        if (info.event.url) {
                            window.location.href = info.event.url;
                            info.jsEvent.preventDefault();
                        }
                    },
                    height: 'auto',
                    firstDay: 1, // Start week on Monday
                });
                calendar.render();
            });
        </script>
    @endpush
</div>