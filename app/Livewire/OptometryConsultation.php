<?php

namespace App\Livewire;

use Livewire\Component;

class OptometryConsultation extends Component
{
    public $patient_id;
    public $consultation_date;
    public $right_eye = ['sph' => '', 'cyl' => '', 'axis' => '', 'add' => ''];
    public $left_eye = ['sph' => '', 'cyl' => '', 'axis' => '', 'add' => ''];
    public $selected_products = [];
    public $internal_notes;
    
    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;

    public function mount()
    {
        $this->consultation_date = date('Y-m-d');
    }

    public function addProduct()
    {
        $this->selected_products[] = ['product_id' => '', 'quantity' => 1, 'price' => 0];
    }

    public function removeProduct($index)
    {
        unset($this->selected_products[$index]);
        $this->selected_products = array_values($this->selected_products);
        $this->calculateTotals();
    }

    public function updatedSelectedProducts($value, $key)
    {
        if (str_ends_with($key, '.product_id')) {
            $index = explode('.', $key)[0];
            $product = \App\Models\Product::find($value);
            if ($product) {
                $this->selected_products[$index]['price'] = $product->price;
            }
        }
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        foreach ($this->selected_products as $p) {
            $this->subtotal += ($p['quantity'] ?? 0) * ($p['price'] ?? 0);
        }
        $this->tax = $this->subtotal * 0.16;
        $this->total = $this->subtotal + $this->tax;
    }

    public function save()
    {
        $this->validate([
            'patient_id' => 'required',
            'consultation_date' => 'required|date',
        ]);

        $consultation = \App\Models\Consultation::create([
            'patient_id' => $this->patient_id,
            'consultation_date' => $this->consultation_date,
            'right_eye_sph' => $this->right_eye['sph'],
            'right_eye_cyl' => $this->right_eye['cyl'],
            'right_eye_axis' => $this->right_eye['axis'],
            'right_eye_add' => $this->right_eye['add'],
            'left_eye_sph' => $this->left_eye['sph'],
            'left_eye_cyl' => $this->left_eye['cyl'],
            'left_eye_axis' => $this->left_eye['axis'],
            'left_eye_add' => $this->left_eye['add'],
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
            'internal_notes' => $this->internal_notes,
        ]);

        foreach ($this->selected_products as $p) {
            if ($p['product_id']) {
                $consultation->products()->attach($p['product_id'], [
                    'quantity' => $p['quantity'],
                    'price_at_time' => $p['price'],
                ]);
            }
        }

        session()->flash('message', 'Consulta guardada exitosamente.');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.optometry-consultation', [
            'patients' => \App\Models\Patient::all(),
            'products' => \App\Models\Product::all(),
        ])->layout('layouts.app');
    }
}
