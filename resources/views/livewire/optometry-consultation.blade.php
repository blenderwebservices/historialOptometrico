<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; margin: 0; color: var(--primary);">
                {{ $consultation_id ? 'Editar Consulta' : 'Nueva Consulta' }}</h1>
            <p style="color: var(--text-muted);">Registro clínico y facturación optométrica</p>
        </div>
        <div style="text-align: right;">
            <p style="font-weight: 600; margin: 0;">Fecha: {{ $consultation_date }}</p>
            <p style="color: var(--text-muted); font-size: 0.8rem;">Folio:
                #{{ $consultation_id ? 'EDIT-' . str_pad($consultation_id, 5, '0', STR_PAD_LEFT) : 'NEW-' . time() }}</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 12px; margin-bottom: 1rem;">
            {{ session('message') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Patient Column -->
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0;">
            <h3>Paciente</h3>
            <div style="margin-top: 1rem; position: relative;" x-data="{ open: @entangle('show_patient_dropdown') }">
                <label>Seleccionar Paciente</label>
                <div style="position: relative;">
                    <input type="text" wire:model.live.debounce.300ms="patient_search" x-on:focus="open = true"
                        placeholder="Buscar o escribir nombre para agregar..."
                        style="width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.5rem 1rem;">

                    @if($patient_id)
                        <button wire:click="$set('patient_id', null); $set('patient_search', '')"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; color: #94a3b8;">
                            ✕
                        </button>
                    @endif
                </div>

                <div x-show="open" x-on:click.away="open = false"
                    style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); z-index: 50; margin-top: 0.25rem; max-height: 200px; overflow-y: auto;">

                    @foreach($patients as $patient)
                        <div wire:click="selectPatient({{ $patient->id }})"
                            style="padding: 0.5rem 1rem; cursor: pointer; border-bottom: 1px solid #f1f5f9;"
                            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            {{ $patient->name }} {{ $patient->last_name }}
                        </div>
                    @endforeach

                    @if($patient_search && count($patients) === 0)
                        <div wire:click="quickAddPatient"
                            style="padding: 0.5rem 1rem; cursor: pointer; color: var(--primary); font-weight: 500;"
                            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            Agregar "{{ $patient_search }}" ...
                        </div>
                    @endif

                    <div wire:click="openPatientModal"
                        style="padding: 0.5rem 1rem; cursor: pointer; color: var(--primary); font-weight: 500; border-top: 2px solid #f1f5f9;"
                        onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                        Agregar y editar ...
                    </div>
                </div>
            </div>
            <div style="margin-top: 1rem;">
                <label>Notas Internas</label>
                <textarea wire:model="internal_notes" rows="3"></textarea>
            </div>
        </div>

        <!-- Prescription Column -->
        <div class="card" style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0;">
            <h3>Graduación (Receta)</h3>
            <div style="margin-top: 1rem;">
                <p
                    style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; color: var(--primary);">
                    Ojo Derecho (OD)</p>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem; margin-bottom: 1rem;">
                    <div><label>SPH</label><input type="text" wire:model="right_eye.sph"></div>
                    <div><label>CYL</label><input type="text" wire:model="right_eye.cyl"></div>
                    <div><label>AXIS</label><input type="text" wire:model="right_eye.axis"></div>
                    <div><label>ADD</label><input type="text" wire:model="right_eye.add"></div>
                </div>

                <p
                    style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; color: var(--primary);">
                    Ojo Izquierdo (OI)</p>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem;">
                    <div><label>SPH</label><input type="text" wire:model="left_eye.sph"></div>
                    <div><label>CYL</label><input type="text" wire:model="left_eye.cyl"></div>
                    <div><label>AXIS</label><input type="text" wire:model="left_eye.axis"></div>
                    <div><label>ADD</label><input type="text" wire:model="left_eye.add"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div style="margin-top: 2rem; background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3>Detalle de Venta</h3>
            <button class="btn-primary" wire:click="addProduct" style="padding: 0.5rem 1rem; font-size: 0.8rem;">+
                Agregar Producto</button>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                    <th style="padding: 1rem;">Producto</th>
                    <th style="padding: 1rem; width: 100px;">Cantidad</th>
                    <th style="padding: 1rem; width: 150px;">P. Unitario</th>
                    <th style="padding: 1rem; width: 150px;">Importe</th>
                    <th style="padding: 1rem; width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($selected_products as $index => $item)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 0.5rem;">
                            <select wire:model="selected_products.{{ $index }}.product_id">
                                <option value="">Seleccione...</option>
                                @foreach($products as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->name }} ({{ $prod->brand }})</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="padding: 0.5rem;">
                            <input type="number" wire:model="selected_products.{{ $index }}.quantity">
                        </td>
                        <td style="padding: 0.5rem;">
                            <input type="number" wire:model="selected_products.{{ $index }}.price" step="0.01">
                        </td>
                        <td style="padding: 0.5rem; font-weight: 500;">
                            ${{ number_format(($item['quantity'] ?? 0) * ($item['price'] ?? 0), 2) }}
                        </td>
                        <td style="padding: 0.5rem;">
                            <button wire:click="removeProduct({{ $index }})"
                                style="color: #ef4444; background: none; border: none; cursor: pointer;">✕</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(count($selected_products) == 0)
            <p style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay productos agregados.</p>
        @endif
    </div>

    <!-- Totals Area -->
    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
        <div style="width: 300px; background: #f8fafc; padding: 1.5rem; border-radius: 16px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span color="var(--text-muted)">Subtotal:</span>
                <span style="font-weight: 600;">${{ number_format($subtotal, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span color="var(--text-muted)">IVA (16%):</span>
                <span style="font-weight: 600;">${{ number_format($tax, 2) }}</span>
            </div>
            <div
                style="display: flex; justify-content: space-between; margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #e2e8f0;">
                <span style="font-weight: 700; font-size: 1.25rem;">Total:</span>
                <span
                    style="font-weight: 700; font-size: 1.25rem; color: var(--primary);">${{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
        <a href="{{ route('home') }}" class="btn-primary" style="background: #94a3b8; text-decoration: none;">Cancelar y
            Volver</a>
        <button class="btn-primary" wire:click="save" style="background: #10b981;">Guardar Consulta y Finalizar</button>
    </div>

    <!-- Patient Modal -->
    @if ($show_patient_modal)
        <div
            style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; padding: 1rem;">
            <div
                style="background: white; border-radius: 16px; width: 100%; max-width: 600px; padding: 2rem; box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);">
                <h2 style="margin-top: 0; color: var(--primary);">Nuevo Paciente</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem;">
                    <div>
                        <label>Nombre(s)</label>
                        <input type="text" wire:model="new_patient.name" style="width: 100%;">
                        @error('new_patient.name')
                            <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Apellidos</label>
                        <input type="text" wire:model="new_patient.last_name" style="width: 100%;">
                        @error('new_patient.last_name')
                            <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Teléfono</label>
                        <input type="text" wire:model="new_patient.phone" style="width: 100%;">
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" wire:model="new_patient.email" style="width: 100%;">
                    </div>
                    <div>
                        <label>Fecha de Nacimiento</label>
                        <input type="date" wire:model="new_patient.birth_date" style="width: 100%;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label>Dirección</label>
                        <textarea wire:model="new_patient.address" rows="2" style="width: 100%;"></textarea>
                    </div>
                </div>
                <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button wire:click="$set('show_patient_modal', false)"
                        style="background: #94a3b8; border: none; color: white; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer;">Cancelar</button>
                    <button wire:click="savePatient"
                        style="background: var(--primary); border: none; color: white; padding: 0.75rem 1.5rem; border-radius: 10px; cursor: pointer;">Guardar
                        Paciente</button>
                </div>
            </div>
        </div>
    @endif
</div>