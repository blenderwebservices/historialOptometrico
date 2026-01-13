<div>
    <style>
        .fi-section {
            background: rgba(255, 255, 255, 0.4) !important;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 20px !important;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05) !important;
            margin-bottom: 1.5rem !important;
        }

        .fi-section-header-title {
            font-family: 'Outfit', sans-serif !important;
            font-weight: 700 !important;
            color: var(--primary) !important;
            font-size: 1.1rem !important;
        }

        .fi-input-wrp {
            border-radius: 12px !important;
            border-color: #e2e8f0 !important;
            background: white !important;
            box-shadow: none !important;
        }

        .fi-input-wrp:focus-within {
            border-color: var(--primary) !important;
            ring: 2px var(--primary-light) !important;
        }

        /* Fix repeater item styling */
        .fi-fo-repeater-item {
            background: rgba(255, 255, 255, 0.3) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 16px !important;
            margin-bottom: 1rem !important;
            padding: 1rem !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        }

        /* Fix the delete button appearance and header */
        .fi-fo-repeater-item-header {
            border-bottom: none !important;
            padding-bottom: 0 !important;
            margin-bottom: 0.5rem !important;
            background: transparent !important;
        }

        .fi-fo-repeater-item-remove-action {
            color: #ef4444 !important;
        }

        /* Clean up select dropdowns and titles */
        .fi-select-input {
            font-family: 'Inter', sans-serif !important;
        }

        .fi-fo-repeater-empty-state {
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 16px !important;
            border: 2px dashed #e2e8f0 !important;
        }
    </style>

    <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; animation: fadeIn 0.8s ease-out;">
        <div>
            <h1 style="font-size: 2.8rem; margin: 0; color: var(--primary); letter-spacing: -0.02em;">
                {{ $consultation_id ? 'Editar Consulta' : 'Nueva Consulta' }}
            </h1>
            <p style="color: var(--text-muted); font-size: 1.1rem; margin-top: 0.25rem;">Registro clínico y facturación
                optométrica de alta precisión</p>
        </div>
        <div
            style="text-align: right; background: white; padding: 1rem 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <p style="font-weight: 700; margin: 0; color: var(--text-main);">Fecha: {{ date('d-m-Y') }}</p>
            <p style="color: var(--primary); font-size: 0.85rem; font-weight: 600; margin-top: 0.25rem;">
                FOLIO #{{ $consultation_id ? str_pad($consultation_id, 5, '0', STR_PAD_LEFT) : 'NEW-' . time() }}
            </p>
        </div>
    </div>

    @if (session()->has('message'))
        <div
            style="background: #ecfdf5; color: #065f46; padding: 1.25rem; border-radius: 16px; border: 1px solid #a7f3d0; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem; animation: fadeIn 0.5s ease-out;">
            <span style="font-size: 1.25rem;">✅</span> {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-8">
        {{ $this->form }}

        <div
            style="margin-top: 3rem; display: flex; justify-content: flex-end; gap: 1.5rem; padding-top: 2rem; border-top: 2px solid #f1f5f9;">
            <a href="{{ route('home') }}" class="btn-primary"
                style="background: #f1f5f9; color: #64748b; text-decoration: none; display: flex; align-items: center; border: 1px solid #cbd5e1; box-shadow: none;">
                Cancelar
            </a>
            <button type="submit" class="btn-primary"
                style="background: var(--primary); padding-left: 2rem; padding-right: 2rem;">
                Finalizar y Guardar Consulta
            </button>
        </div>
    </form>
</div>