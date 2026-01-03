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

    <div style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                    <th style="padding: 1rem;">ID</th>
                    <th style="padding: 1rem;">Paciente</th>
                    <th style="padding: 1rem;">Fecha</th>
                    <th style="padding: 1rem;">Total</th>
                    <th style="padding: 1rem; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultations as $consultation)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 1rem; color: var(--text-muted); font-family: monospace;">#{{ str_pad($consultation->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 1rem;">
                            <span style="font-weight: 600;">{{ $consultation->patient->name }} {{ $consultation->patient->last_name }}</span>
                        </td>
                        <td style="padding: 1rem;">{{ $consultation->consultation_date->format('d/m/Y') }}</td>
                        <td style="padding: 1rem; font-weight: 700; color: var(--primary);">${{ number_format($consultation->total, 2) }}</td>
                        <td style="padding: 1rem; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                <a href="{{ route('consultation.edit', $consultation->id) }}" style="background: #e0e7ff; color: #4338ca; padding: 0.5rem; border-radius: 8px; text-decoration: none; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#c7d2fe'" onmouseout="this.style.background='#e0e7ff'">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $consultation->id }})" wire:confirm="¿Estás seguro de eliminar esta consulta?" style="background: #fee2e2; color: #b91c1c; border: none; padding: 0.5rem; border-radius: 8px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <div style="margin-bottom: 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 3rem; height: 3rem; margin: 0 auto; opacity: 0.3;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            Parece que aún no hay consultas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 1.5rem;">
            {{ $consultations->links() }}
        </div>
    </div>
</div>
