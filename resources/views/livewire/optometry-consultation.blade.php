<div>
    <style>
        .fi-section {
            background: rgba(255, 255, 255, 0.4) !important;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 20px !important;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05) !important;
            margin-bottom: 1.5rem !important;
            position: relative !important;
            z-index: 10;
        }

        .fi-section:focus-within {
            z-index: 50 !important;
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
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
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
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
            border-bottom: none !important;
            padding-bottom: 0.5rem !important;
            margin-bottom: 1rem !important;
            background: transparent !important;
        }

        /* Target the title and the action list inside the header */
        .fi-fo-repeater-item-header>h4 {
            margin: 0 !important;
            padding: 0 !important;
            flex: 1 1 auto !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            display: block !important;
        }

        .fi-fo-repeater-item-header>ul {
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            flex: 0 0 auto !important;
            margin-left: auto !important;
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

        /* Fix Filament field scaling and alignment */
        .fi-fo-field-wrp-hint {
            display: flex !important;
            align-items: center !important;
            gap: 0.4rem !important;
            font-size: 0.7rem !important;
            color: var(--text-muted) !important;
        }

        .fi-fo-field-wrp-hint svg {
            width: 14px !important;
            height: 14px !important;
            flex-shrink: 0 !important;
            color: var(--primary) !important;
        }

        .fi-fo-field-wrp-label {
            margin-bottom: 0.25rem !important;
        }

        /* Custom Grid Fixes for Frontend */
        .custom-form-grid {
            display: block !important;
            width: 100% !important;
        }

        /* Ensure the main form and sections take full width of their containers */
        form,
        .fi-section {
            width: 100% !important;
        }

        /* Desktop/Tablet Layout (>768px) */
        @media (min-width: 768px) {

            /* Force main 12-column grid */
            .custom-form-grid>div {
                display: grid !important;
                grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
                gap: 1.5rem !important;
                width: 100% !important;
                align-items: start !important;
            }

            /* Target the section wrappers (the direct children of the grid) */
            .custom-form-grid>div>div:nth-child(1) {
                grid-column: span 5 / span 5 !important;
            }

            .custom-form-grid>div>div:nth-child(2) {
                grid-column: span 7 / span 7 !important;
            }

            /* Eye Values Grid (Force 4 horizontal columns) */
            .eye-values-grid>div {
                display: grid !important;
                grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
                gap: 1rem !important;
                width: 100% !important;
            }

            /* Force eye fields into 1/4 width */
            .eye-values-grid>div>div {
                grid-column: span 1 / span 1 !important;
            }

            /* The eye label (first item) takes the full row of 4 */
            .eye-values-grid>div>div:nth-child(1) {
                grid-column: span 4 / span 4 !important;
            }

            /* Products Repeater Fix (Forced horizontal grid) */
            .products-repeater .fi-fo-repeater-item-content>div {
                display: grid !important;
                grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
                gap: 1.5rem !important;
                width: 100% !important;
            }

            /* Proportional Spans (Product: 3/6, Quantity: 1/6, Price: 1/6, Total: 1/6) */
            .products-repeater .fi-fo-repeater-item-content>div>div:nth-child(1) {
                grid-column: span 3 / span 3 !important;
            }

            .products-repeater .fi-fo-repeater-item-content>div>div:nth-child(2) {
                grid-column: span 1 / span 1 !important;
            }

            .products-repeater .fi-fo-repeater-item-content>div>div:nth-child(3) {
                grid-column: span 1 / span 1 !important;
            }

            .products-repeater .fi-fo-repeater-item-content>div>div:nth-child(4) {
                grid-column: span 1 / span 1 !important;
            }
        }

        /* Mobile Layout (<768px) */
        @media (max-width: 767px) {
            .eye-values-grid>div {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 1rem !important;
            }
        }

        /* Essential Filament Fallbacks */
        .fi-grid-cols-12,
        .fi-grid-cols-4,
        .fi-grid-cols-2 {
            display: grid !important;
            gap: 1.5rem !important;
        }

        @media (min-width: 768px) {
            .fi-grid-cols-12 {
                grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
            }

            .fi-grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            }
        }

        /* Fix the "Create" action button in Select */
        .fi-ac-action {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: var(--primary) !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            margin-top: 0.5rem !important;
            margin-bottom: 0.5rem !important;
            border: none !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            width: fit-content !important;
            transition: all 0.2s !important;
        }

        .fi-ac-action:hover {
            opacity: 0.9 !important;
            transform: translateY(-1px) !important;
        }

        .fi-ac-action span {
            color: white !important;
            margin-left: 0.25rem !important;
        }

        .fi-ac-action svg {
            width: 16px !important;
            height: 16px !important;
            color: white !important;
        }

        /* Ensure spacing between fields */
        .fi-fo-field-wrp {
            margin-bottom: 1.5rem !important;
        }

        .fi-fo-field-wrp-label {
            margin-bottom: 0.5rem !important;
            font-weight: 600 !important;
        }

        /* Standardize input height */
        .fi-input-wrp {
            height: 48px !important;
            background: white !important;
        }

        /* Fix multiple chevrons and select icons */
        .fi-select-input-wrp svg {
            width: 16px !important;
            height: 16px !important;
            right: 0.75rem !important;
        }

        /* Hide extra chevrons if they repeat in the background or as multiple elements */
        .fi-select-input {
            appearance: none !important;
            background-image: none !important;
        }

        /* Fix Repeater List Styling (Remove bullets) */
        .fi-fo-repeater-items,
        .fi-fo-repeater-item {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        ul,
        li {
            list-style-type: none !important;
        }

        /* Re-style Remove Action Button */
        .fi-fo-repeater-item-remove-action {
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.25rem !important;
            background: #fee2e2 !important;
            color: #ef4444 !important;
            padding: 0.4rem 0.8rem !important;
            border-radius: 8px !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            border: 1px solid #fecaca !important;
            transition: all 0.2s !important;
            margin-bottom: 1rem !important;
        }

        .fi-fo-repeater-item-remove-action:hover {
            background: #fecaca !important;
            transform: translateY(-1px) !important;
        }

        .fi-fo-repeater-item-remove-action svg {
            width: 14px !important;
            height: 14px !important;
        }

        /* Improve repeater item layout */
        .fi-fo-repeater-item {
            background: white !important;
            border: 1px solid #e2e8f0 !important;
            padding: 2rem !important;
            margin-bottom: 2rem !important;
            position: relative !important;
        }

        /* Fix header items in repeater */
        .fi-fo-repeater-item-header {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            padding: 0 !important;
            margin-bottom: 1rem !important;
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