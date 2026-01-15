<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; margin: 0; color: var(--primary);">Consultas</h1>
            <p style="color: var(--text-muted);">Listado de historiales optométricos</p>
        </div>
        <div>
            <a href="{{ route('consultation.new') }}" class="btn-primary" style="text-decoration: none; display: inline-block;">+ Nueva Consulta</a>
        </div>
    </div>

    @if (session()->has('message'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; animation: fadeIn 0.3s ease-out;">
            {{ session('message') }}
        </div>
    @endif

    <div class="fi-table-container">
        {{ $this->table }}
    </div>

    <x-filament-actions::modals />
</div>
