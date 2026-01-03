<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; margin: 0; color: var(--primary);">Nueva Consulta</h1>
            <p style="color: var(--text-muted);">Registro clínico y facturación optométrica</p>
        </div>
        <div style="text-align: right;">
            <p style="font-weight: 600; margin: 0;">Fecha: {{ $consultation_date }}</p>
            <p style="color: var(--text-muted); font-size: 0.8rem;">Folio: #ABS-{{ time() }}</p>
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
            <div style="margin-top: 1rem;">
                <label>Seleccionar Paciente</label>
                <select wire:model="patient_id">
                    <option value="">Seleccione un paciente</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }} {{ $patient->last_name }}</option>
                    @endforeach
                </select>
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
                <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; color: var(--primary);">Ojo Derecho (OD)</p>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem; margin-bottom: 1rem;">
                    <div><label>SPH</label><input type="text" wire:model="right_eye.sph"></div>
                    <div><label>CYL</label><input type="text" wire:model="right_eye.cyl"></div>
                    <div><label>AXIS</label><input type="text" wire:model="right_eye.axis"></div>
                    <div><label>ADD</label><input type="text" wire:model="right_eye.add"></div>
                </div>
                
                <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; color: var(--primary);">Ojo Izquierdo (OI)</p>
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
            <button class="btn-primary" wire:click="addProduct" style="padding: 0.5rem 1rem; font-size: 0.8rem;">+ Agregar Producto</button>
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
                            <button wire:click="removeProduct({{ $index }})" style="color: #ef4444; background: none; border: none; cursor: pointer;">✕</button>
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
            <div style="display: flex; justify-content: space-between; margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #e2e8f0;">
                <span style="font-weight: 700; font-size: 1.25rem;">Total:</span>
                <span style="font-weight: 700; font-size: 1.25rem; color: var(--primary);">${{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
        <a href="{{ route('home') }}" class="btn-primary" style="background: #94a3b8; text-decoration: none;">Cancelar y Volver</a>
        <button class="btn-primary" wire:click="save" style="background: #10b981;">Guardar Consulta y Finalizar</button>
    </div>
</div>
