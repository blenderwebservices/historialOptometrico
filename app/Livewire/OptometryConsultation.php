<?php

namespace App\Livewire;

use Livewire\Component;

class OptometryConsultation extends Component
{
    public $consultation_id;
    public $patient_id;
    public $consultation_date;
    public $right_eye = ['sph' => '', 'cyl' => '', 'axis' => '', 'add' => ''];
    public $left_eye = ['sph' => '', 'cyl' => '', 'axis' => '', 'add' => ''];
    public $selected_products = [];
    public $internal_notes;

    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;

    // Patient Selection & Modal Search
    public $patient_search = '';

    // Quick Patient Modal Fields
    public $show_patient_modal = false;
    public $new_patient = [
        'name' => '',
        'last_name' => '',
        'phone' => '',
        'email' => '',
        'birth_date' => '',
        'address' => '',
    ];

    public function mount(\App\Models\Consultation $consultation = null)
    {
        if ($consultation && $consultation->exists) {
            $this->consultation_id = $consultation->id;
            $this->patient_id = $consultation->patient_id;
            $this->consultation_date = $consultation->consultation_date->format('Y-m-d');
            $this->right_eye = [
                'sph' => $consultation->right_eye_sph,
                'cyl' => $consultation->right_eye_cyl,
                'axis' => $consultation->right_eye_axis,
                'add' => $consultation->right_eye_add,
            ];
            $this->left_eye = [
                'sph' => $consultation->left_eye_sph,
                'cyl' => $consultation->left_eye_cyl,
                'axis' => $consultation->left_eye_axis,
                'add' => $consultation->left_eye_add,
            ];
            $this->internal_notes = $consultation->internal_notes;
            $this->subtotal = $consultation->subtotal;
            $this->tax = $consultation->tax;
            $this->total = $consultation->total;

            foreach ($consultation->products as $product) {
                $this->selected_products[] = [
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->pivot->price_at_time,
                ];
            }
        } else {
            $this->consultation_date = date('Y-m-d');
        }
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
            $parts = explode('.', $key);
            $index = $parts[0];
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

    public function updatedPatientSearch($value)
    {
        $this->patient_id = null;
    }

    public function quickAddPatient()
    {
        if (empty($this->patient_search))
            return;

        $names = explode(' ', $this->patient_search, 2);
        $patient = \App\Models\Patient::create([
            'name' => $names[0],
            'last_name' => $names[1] ?? '',
        ]);

        $this->selectPatient($patient->id);
        $this->patient_search = '';
    }

    public function openPatientModal()
    {
        $this->new_patient = [
            'name' => $this->patient_search,
            'last_name' => '',
            'phone' => '',
            'email' => '',
            'birth_date' => '',
            'address' => '',
        ];
        $this->show_patient_modal = true;
    }

    public function savePatient()
    {
        $this->validate([
            'new_patient.name' => 'required|min:2',
            'new_patient.last_name' => 'required|min:2',
            'new_patient.phone' => 'nullable',
            'new_patient.email' => 'nullable|email',
            'new_patient.birth_date' => 'nullable|date',
            'new_patient.address' => 'nullable',
        ]);

        $patient = \App\Models\Patient::create($this->new_patient);

        $this->selectPatient($patient->id);
        $this->show_patient_modal = false;
    }

    public function selectPatient($id)
    {
        $this->patient_id = $id;
        $patient = \App\Models\Patient::find($id);
        if ($patient) {
            $this->patient_search = $patient->name . ' ' . $patient->last_name;
        }
    }

    public function save()
    {
        $this->validate([
            'patient_id' => 'required',
            'consultation_date' => 'required|date',
        ]);

        $data = [
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
        ];

        if ($this->consultation_id) {
            $consultation = \App\Models\Consultation::find($this->consultation_id);
            $consultation->update($data);
            $consultation->products()->detach();
        } else {
            $consultation = \App\Models\Consultation::create($data);
        }

        foreach ($this->selected_products as $p) {
            if ($p['product_id']) {
                $consultation->products()->attach($p['product_id'], [
                    'quantity' => $p['quantity'],
                    'price_at_time' => $p['price'],
                ]);
            }
        }

        session()->flash('message', $this->consultation_id ? 'Consulta actualizada exitosamente.' : 'Consulta guardada exitosamente.');
        return redirect()->route('home');
    }

    public function render()
    {
        $patients = collect();
        $search = trim($this->patient_search);
        if ($search !== '') {
            $searchTerm = '%' . mb_strtolower($search, 'UTF-8') . '%';
            $patients = \App\Models\Patient::whereRaw("LOWER(CONCAT_WS(' ', name, last_name)) LIKE ?", [$searchTerm])
                ->limit(10)
                ->get();
        }

        return view('livewire.optometry-consultation', [
            'patients' => $patients,
            'products' => \App\Models\Product::all(),
        ])->layout('layouts.app');
    }
}
