<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Concerns\InteractsWithActions;
use App\Models\Consultation;
use App\Models\Product;
use App\Models\Patient;

class OptometryConsultation extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];
    public Consultation $record;
    public $consultation_id;

    public function mount(Consultation $consultation = null): void
    {
        $this->record = $consultation && $consultation->exists ? $consultation : new Consultation();

        if ($this->record->exists) {
            $this->consultation_id = $this->record->id;
            $this->form->fill([
                'patient_id' => $this->record->patient_id,
                'consultation_date' => optional($this->record->consultation_date)->format('Y-m-d'),
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
            ]);
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
                        ->extraAttributes(['class' => 'custom-form-grid'])
                        ->schema([
                                // Left Column: Patient and Date
                                Forms\Components\Section::make('Información del Paciente')
                                    ->extraAttributes(['class' => 'section-patient-info'])
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
                                    ->extraAttributes(['class' => 'section-prescription'])
                                    ->schema([
                                            Forms\Components\Grid::make(4)
                                                ->schema([
                                                        Forms\Components\Placeholder::make('eye_label_r')
                                                            ->label('Ojo Derecho (OD)')
                                                            ->content('')
                                                            ->columnSpan(4)
                                                            ->extraAttributes(['style' => 'font-weight: 700; color: var(--primary); font-size: 0.75rem; text-transform: uppercase; margin-bottom: -1rem;']),
                                                        Forms\Components\TextInput::make('right_eye_sph')
                                                            ->label('SPH')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(-20)
                                                            ->maxValue(20)
                                                            ->hint('Rango: -20 a +20')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('right_eye_cyl')
                                                            ->label('CYL')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(-6)
                                                            ->maxValue(6)
                                                            ->hint('Rango: -6 a +6')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('right_eye_axis')
                                                            ->label('AXIS')
                                                            ->numeric()
                                                            ->step(1)
                                                            ->minValue(0)
                                                            ->maxValue(180)
                                                            ->hint('Rango: 0 a 180°')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('right_eye_add')
                                                            ->label('ADD')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(0)
                                                            ->maxValue(4)
                                                            ->hint('Rango: 0 a 4')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                    ])
                                                ->columns(4)
                                                ->extraAttributes(['class' => 'eye-values-grid']),

                                            Forms\Components\Grid::make(4)
                                                ->schema([
                                                        Forms\Components\Placeholder::make('eye_label_l')
                                                            ->label('Ojo Izquierdo (OI)')
                                                            ->content('')
                                                            ->columnSpan(4)
                                                            ->extraAttributes(['style' => 'font-weight: 700; color: var(--primary); font-size: 0.75rem; text-transform: uppercase; margin-top: 1rem; margin-bottom: -1rem;']),
                                                        Forms\Components\TextInput::make('left_eye_sph')
                                                            ->label('SPH')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(-20)
                                                            ->maxValue(20)
                                                            ->hint('Rango: -20 a +20')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('left_eye_cyl')
                                                            ->label('CYL')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(-6)
                                                            ->maxValue(6)
                                                            ->hint('Rango: -6 a +6')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('left_eye_axis')
                                                            ->label('AXIS')
                                                            ->numeric()
                                                            ->step(1)
                                                            ->minValue(0)
                                                            ->maxValue(180)
                                                            ->hint('Rango: 0 a 180°')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('left_eye_add')
                                                            ->label('ADD')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(0)
                                                            ->maxValue(4)
                                                            ->hint('Rango: 0 a 4')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                    ])
                                                ->columns(4)
                                                ->extraAttributes(['class' => 'eye-values-grid']),
                                        ])
                                    ->columnSpan(7)
                                    ->extraAttributes([
                                            'class' => 'relative z-[5] focus-within:z-[50]',
                                        ]),
                            ]),

                    Forms\Components\Section::make('Productos / Detalle de Venta')
                        ->schema([
                                Forms\Components\Repeater::make('consultationProducts')
                                    ->relationship()
                                    ->label('Detalle de Productos / Venta')
                                    ->addActionLabel('Agregar Producto')
                                    ->live()
                                    ->schema([
                                            Forms\Components\Select::make('product_id')
                                                ->label('Producto')
                                                ->relationship('product', 'name')
                                                ->required()
                                                ->reactive()
                                                ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                                    $product = Product::find($state);
                                                    $price = $product?->price ?? 0;
                                                    $set('price_at_time', $price);

                                                    $qty = (float) ($get('quantity') ?? 1);
                                                    $set('row_total', number_format($qty * $price, 2, '.', ''));

                                                    // Update totals
                                                    $products = $get('../../consultationProducts') ?? [];
                                                    $subtotal = 0;
                                                    foreach ($products as $product) {
                                                        $p_qty = (float) ($product['quantity'] ?? 0);
                                                        $p_price = (float) ($product['price_at_time'] ?? 0);
                                                        $subtotal += $p_qty * $p_price;
                                                    }
                                                    $set('../../subtotal', number_format($subtotal, 2, '.', ''));
                                                    $set('../../tax', number_format($subtotal * 0.16, 2, '.', ''));
                                                    $set('../../total', number_format($subtotal * 1.16, 2, '.', ''));
                                                })
                                                ->columnSpan(3),
                                            Forms\Components\TextInput::make('quantity')
                                                ->label('Cant.')
                                                ->numeric()
                                                ->default(1)
                                                ->required()
                                                ->reactive()
                                                ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                                    $price = (float) ($get('price_at_time') ?? 0);
                                                    $qty = (float) ($state ?? 0);
                                                    $set('row_total', number_format($qty * $price, 2, '.', ''));

                                                    // Update totals
                                                    $products = $get('../../consultationProducts') ?? [];
                                                    $subtotal = 0;
                                                    foreach ($products as $product) {
                                                        $p_qty = (float) ($product['quantity'] ?? 0);
                                                        $p_price = (float) ($product['price_at_time'] ?? 0);
                                                        $subtotal += $p_qty * $p_price;
                                                    }
                                                    $set('../../subtotal', number_format($subtotal, 2, '.', ''));
                                                    $set('../../tax', number_format($subtotal * 0.16, 2, '.', ''));
                                                    $set('../../total', number_format($subtotal * 1.16, 2, '.', ''));
                                                })
                                                ->columnSpan(1),
                                            Forms\Components\TextInput::make('price_at_time')
                                                ->label('Precio Unit.')
                                                ->numeric()
                                                ->required()
                                                ->prefix('$')
                                                ->reactive()
                                                ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                                    $qty = (float) ($get('quantity') ?? 0);
                                                    $price = (float) ($state ?? 0);
                                                    $set('row_total', number_format($qty * $price, 2, '.', ''));

                                                    // Update totals
                                                    $products = $get('../../consultationProducts') ?? [];
                                                    $subtotal = 0;
                                                    foreach ($products as $product) {
                                                        $p_qty = (float) ($product['quantity'] ?? 0);
                                                        $p_price = (float) ($product['price_at_time'] ?? 0);
                                                        $subtotal += $p_qty * $p_price;
                                                    }
                                                    $set('../../subtotal', number_format($subtotal, 2, '.', ''));
                                                    $set('../../tax', number_format($subtotal * 0.16, 2, '.', ''));
                                                    $set('../../total', number_format($subtotal * 1.16, 2, '.', ''));
                                                })
                                                ->columnSpan(1),
                                            Forms\Components\TextInput::make('row_total')
                                                ->label('Importe')
                                                ->prefix('$')
                                                ->disabled()
                                                ->dehydrated(false)
                                                ->numeric()
                                                ->columnSpan(1),
                                        ])
                                    ->columns(6)
                                    ->extraAttributes(['class' => 'products-repeater'])
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                        $products = $get('consultationProducts') ?? [];
                                        $subtotal = 0;
                                        foreach ($products as $product) {
                                            $qty = (float) ($product['quantity'] ?? 0);
                                            $price = (float) ($product['price_at_time'] ?? 0);
                                            $subtotal += $qty * $price;
                                        }

                                        $set('subtotal', number_format($subtotal, 2, '.', ''));
                                        $set('tax', number_format($subtotal * 0.16, 2, '.', ''));
                                        $set('total', number_format($subtotal * 1.16, 2, '.', ''));
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
            // Filament handles the relationship updates automatically when relationship() is set on the repeater
        } else {
            $this->record = Consultation::create($state);
            // Manually trigger relationship saving for new records
            $this->form->model($this->record)->saveRelationships();
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
