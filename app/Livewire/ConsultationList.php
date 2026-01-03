<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Consultation;
use Livewire\WithPagination;

class ConsultationList extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $consultation = Consultation::find($id);
        if ($consultation) {
            $consultation->delete();
            session()->flash('message', 'Consulta eliminada exitosamente.');
        }
    }

    public function render()
    {
        return view('livewire.consultation-list', [
            'consultations' => Consultation::with('patient')->latest()->paginate(10),
        ])->layout('layouts.app');
    }
}
