<div>
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #e0e7ff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-glass: rgba(255, 255, 255, 0.4);
        }

        .fi-section {
            background: var(--bg-glass) !important;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 24px !important;
            box-shadow: 0 10px 40px -10px rgba(31, 38, 135, 0.08) !important;
            margin-bottom: 2rem !important;
            overflow: visible !important;
        }

        .fi-section-header {
            padding: 1.5rem 2rem 1rem !important;
            border-bottom: none !important;
        }

        .fi-section-header-title {
            font-family: 'Outfit', sans-serif !important;
            font-weight: 700 !important;
            color: var(--text-main) !important;
            font-size: 1.25rem !important;
        }

        /* Input Styling */
        .fi-input-wrp {
            border-radius: 14px !important;
            border: 1px solid #e2e8f0 !important;
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
            transition: all 0.2s ease !important;
            height: 48px !important;
        }

        .fi-input-wrp:focus-within {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px var(--primary-light) !important;
        }

        /* Repeater Table-like styling */
        .products-repeater-table {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin-top: -1rem !important;
        }

        .products-repeater-table .fi-fo-repeater-items {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .products-repeater-table .fi-fo-repeater-item {
            background: transparent !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-radius: 0 !important;
            padding: 0.5rem 0 !important;
            box-shadow: none !important;
            margin-bottom: 0 !important;
            position: relative !important;
            transition: background-color 0.2s ease !important;
        }

        .products-repeater-table .fi-fo-repeater-item:hover {
            transform: none !important;
            background-color: rgba(248, 250, 252, 0.5) !important;
            box-shadow: none !important;
        }

        /* Hide standard repeater headers and labels inside the table */
        .products-repeater-table .fi-fo-repeater-item-header {
            display: none !important;
        }

        .products-repeater-table .fi-fo-repeater-item-content .fi-fo-field-wrp-label {
            display: none !important;
        }

        /* Remove Action (The X) */
        .products-repeater-table .fi-fo-repeater-item-remove-action {
            position: absolute !important;
            right: -10px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            background: #fee2e2 !important;
            color: #ef4444 !important;
            width: 24px !important;
            height: 24px !important;
            border-radius: 50% !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: 1px solid #fecaca !important;
            font-size: 14px !important;
            opacity: 0;
            transition: all 0.2s ease !important;
            z-index: 20;
        }

        .products-repeater-table .fi-fo-repeater-item:hover .fi-fo-repeater-item-remove-action {
            opacity: 1;
            right: -12px !important;
        }

        /* Add Action Button Styling */
        .fi-fo-repeater-add-action {
            background: #6366f1 !important;
            color: white !important;
            border-radius: 12px !important;
            padding: 0.6rem 1.2rem !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important;
            border: none !important;
            transition: all 0.2s ease !important;
            margin-top: 1.5rem !important;
        }

        .fi-fo-repeater-add-action:hover {
            background: #4f46e5 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4) !important;
        }

        /* Section Header Action override */
        .fi-section-header-actions .fi-ac-action {
            background: #6366f1 !important;
            color: white !important;
            border-radius: 10px !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.85rem !important;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.2) !important;
        }

        /* Placeholder / Row Total Display */
        .row-total-display {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            font-weight: 700 !important;
            color: var(--text-main) !important;
            font-size: 1.1rem !important;
            height: 48px !important;
            padding-right: 1rem !important;
        }

        /* General Grid Fixes */
        .eye-values-grid > div {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 1rem !important;
        }

        /* Custom Label for eyes */
        .eye-values-grid [style*="font-weight: 700"] {
            grid-column: span 4 !important;
            margin-bottom: 0.5rem !important;
        }

        /* Mobile specific */
        @media (max-width: 768px) {
            .eye-values-grid > div {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .products-repeater-table .fi-fo-repeater-item-content > div {
                grid-template-columns: 1fr !important;
            }
        }

        /* Form Footer Buttons */
        .btn-primary {
            border-radius: 14px !important;
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
            height: 52px !important;
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
    <x-filament-actions::modals />
</div>