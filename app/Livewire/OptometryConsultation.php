<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use App\Models\Consultation;
use App\Models\Product;
use App\Models\Patient;

class OptometryConsultation extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Consultation $record;
    public $consultation_id;

    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;

    public function mount(Consultation $consultation = null): void
    {
        $this->record = $consultation && $consultation->exists ? $consultation : new Consultation();

        if ($this->record->exists) {
            $this->consultation_id = $this->record->id;
            $this->form->fill([
                'patient_id' => $this->record->patient_id,
                'consultation_date' => $this->record->consultation_date->format('Y-m-d'),
                'right_eye_sph' => $this->record->right_eye_sph,
                'right_eye_cyl' => $this->record->right_eye_cyl,
                'right_eye_axis' => $this->record->right_eye_axis,
                'right_eye_add' => $this->record->right_eye_add,
                'left_eye_sph' => $this->record->left_eye_sph,
                'left_eye_cyl' => $this->record->left_eye_cyl,
                'left_eye_axis' => $this->record->left_eye_axis,
                'left_eye_add' => $this->record->left_eye_add,
                'internal_notes' => $this->record->internal_notes,
                'subtotal' => $this->record->subtotal,
                'tax' => $this->record->tax,
                'total' => $this->record->total,
                'consultationProducts' => $this->record->consultationProducts->map(function ($cp) {
                    return [
                        'product_id' => $cp->product_id,
                        'quantity' => $cp->quantity,
                        'price_at_time' => $cp->price_at_time,
                    ];
                })->toArray(),
            ]);
            $this->subtotal = $this->record->subtotal;
            $this->tax = $this->record->tax;
            $this->total = $this->record->total;
        } else {
            $this->form->fill([
                'consultation_date' => now()->format('Y-m-d'),
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(12)
                    ->schema([
                        // Left Column: Patient and Date
                        Forms\Components\Section::make('Información del Paciente')
                            ->schema([
                                Forms\Components\Select::make('patient_id')
                                    ->label('Seleccionar Paciente')
                                    ->relationship('patient', 'name')
                                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} {$record->last_name}")
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\TextInput::make('last_name')
                                            ->required(),
                                        Forms\Components\TextInput::make('phone'),
                                        Forms\Components\TextInput::make('email')
                                            ->email(),
                                        Forms\Components\DatePicker::make('birth_date'),
                                        Forms\Components\Textarea::make('address'),
                                    ])
                                    ->required(),
                                Forms\Components\DatePicker::make('consultation_date')
                                    ->label('Fecha')
                                    ->required()
                                    ->default(now()),
                            ])
                            ->columnSpan(5),

                        // Right Column: Prescription
                        Forms\Components\Section::make('Graduación (Receta)')
                            ->schema([
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\Placeholder::make('eye_label_r')
                                            ->label('Ojo Derecho (OD)')
                                            ->content('')
                                            ->columnSpan(4)
                                            ->extraAttributes(['style' => 'font-weight: 700; color: var(--primary); font-size: 0.75rem; text-transform: uppercase;']),
                                        Forms\Components\TextInput::make('right_eye_sph')->label('SPH'),
                                        Forms\Components\TextInput::make('right_eye_cyl')->label('CYL'),
                                        Forms\Components\TextInput::make('right_eye_axis')->label('AXIS'),
                                        Forms\Components\TextInput::make('right_eye_add')->label('ADD'),

                                        Forms\Components\Placeholder::make('eye_label_l')
                                            ->label('Ojo Izquierdo (OI)')
                                            ->content('')
                                            ->columnSpan(4)
                                            ->extraAttributes(['style' => 'font-weight: 700; color: var(--primary); font-size: 0.75rem; text-transform: uppercase; margin-top: 1rem;']),
                                        Forms\Components\TextInput::make('left_eye_sph')->label('SPH'),
                                        Forms\Components\TextInput::make('left_eye_cyl')->label('CYL'),
                                        Forms\Components\TextInput::make('left_eye_axis')->label('AXIS'),
                                        Forms\Components\TextInput::make('left_eye_add')->label('ADD'),
                                    ]),
                            ])
                            ->columnSpan(7),
                    ]),

                Forms\Components\Section::make('Productos / Detalle de Venta')
                    ->schema([
                        Forms\Components\Repeater::make('consultationProducts')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Producto')
                                    ->relationship('product', 'name')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(
                                        fn(Forms\Set $set, $state) =>
                                        $set('price_at_time', Product::find($state)?->price ?? 0)
                                    )
                                    ->columnSpan(3),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Cant.')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->reactive()
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('price_at_time')
                                    ->label('Precio Unit.')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->columnSpan(2),
                            ])
                            ->columns(6)
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                $products = $get('consultationProducts') ?? [];
                                $subtotal = 0;
                                foreach ($products as $product) {
                                    $subtotal += (float) ($product['quantity'] ?? 0) * (float) ($product['price_at_time'] ?? 0);
                                }
                                $set('subtotal', $subtotal);
                                $set('total', $subtotal * 1.16);
                                $set('tax', $subtotal * 0.16);

                                // Sync component properties for custom totals area
                                $this->subtotal = $subtotal;
                                $this->tax = $subtotal * 0.16;
                                $this->total = $subtotal * 1.16;
                            })
                            ->itemLabel(fn(array $state): ?string => $state['product_id'] ? Product::find($state['product_id'])?->name : 'Nuevo Producto'),
                    ]),

                // Totals and Notes Section
                Forms\Components\Grid::make(12)
                    ->schema([
                        Forms\Components\Textarea::make('internal_notes')
                            ->label('Notas Internas')
                            ->rows(4)
                            ->columnSpan(8),

                        Forms\Components\Section::make('Resumen')
                            ->schema([
                                Forms\Components\TextInput::make('subtotal')->readOnly()->prefix('$')->extraInputAttributes(['style' => 'font-weight: 600;']),
                                Forms\Components\TextInput::make('tax')->label('IVA (16%)')->readOnly()->prefix('$')->extraInputAttributes(['style' => 'font-weight: 600;']),
                                Forms\Components\TextInput::make('total')->readOnly()->prefix('$')->extraInputAttributes(['style' => 'font-weight: 700; color: var(--primary); font-size: 1.1rem;']),
                            ])
                            ->columnSpan(4),
                    ]),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save()
    {
        $state = $this->form->getState();

        if ($this->record->exists) {
            $this->record->update($state);
        } else {
            $this->record = Consultation::create($state);
        }

        session()->flash('message', $this->consultation_id ? 'Consulta actualizada exitosamente.' : 'Consulta guardada exitosamente.');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.optometry-consultation')
            ->layout('layouts.app');
    }
}
