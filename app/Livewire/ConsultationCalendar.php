<?php

namespace App\Livewire;

use App\Models\Consultation;
use Livewire\Component;

class ConsultationCalendar extends Component
{
    public function getEvents()
    {
        return Consultation::with('patient')
            ->get()
            ->map(function ($consultation) {
                return [
                    'id' => $consultation->id,
                    'title' => ($consultation->patient->name ?? 'Paciente') . ' ' . ($consultation->patient->last_name ?? ''),
                    'start' => $consultation->consultation_date->format('Y-m-d'),
                    'url' => route('consultation.edit', $consultation->id),
                    'backgroundColor' => '#6366f1',
                    'borderColor' => '#4f46e5',
                ];
            });
    }

    public function render()
    {
        return view('livewire.consultation-calendar', [
            'events' => $this->getEvents(),
        ])->layout('layouts.app');
    }
}
