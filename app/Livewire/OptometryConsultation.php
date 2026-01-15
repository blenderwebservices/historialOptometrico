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
                'consultationProducts' => $this->record->consultationProducts->map(fn($cp) => [
                    'product_id' => $cp->product_id,
                    'quantity' => $cp->quantity,
                    'price_at_time' => $cp->price_at_time,
                ])->toArray(),
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

                    Forms\Components\Section::make('Detalle de Venta')
                        ->headerActions([
                            Forms\Components\Actions\Action::make('add_product')
                                ->label('+ Agregar Producto')
                                ->color('primary')
                                ->action(function (Forms\Components\Repeater $component) {
                                    $state = $component->getState();
                                    $state[] = [
                                        'quantity' => 1,
                                        'price_at_time' => 0,
                                        'row_total' => 0,
                                    ];
                                    $component->state($state);
                                })
                        ])
                        ->schema([
                            Forms\Components\Placeholder::make('repeater_header')
                                ->label('')
                                ->content(view('livewire.repeater-header'))
                                ->extraAttributes(['class' => 'repeater-header-row']),
                            Forms\Components\Repeater::make('consultationProducts')
                                ->relationship()
                                ->label('')
                                ->addable(false) // Hide the bottom add button as we have the header one
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
                                        ->columnSpan(7),
                                    Forms\Components\TextInput::make('quantity')
                                        ->label('Cantidad')
                                        ->numeric()
                                        ->default(1)
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                            $price = (float) ($get('price_at_time') ?? 0);
                                            $qty = (float) ($state ?? 0);

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
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('price_at_time')
                                        ->label('P. Unitario')
                                        ->numeric()
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                            $qty = (float) ($get('quantity') ?? 0);
                                            $price = (float) ($state ?? 0);

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
                                        ->columnSpan(2),
                                    Forms\Components\Placeholder::make('row_total_display')
                                        ->label('Importe')
                                        ->content(fn ($get) => '$' . number_format((float) ($get('quantity') ?? 1) * (float) ($get('price_at_time') ?? 0), 2))
                                        ->extraAttributes(['class' => 'row-total-display'])
                                        ->columnSpan(1),
                                ])
                                ->columns(12)
                                ->extraAttributes(['class' => 'products-repeater-table'])
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
                                // Hide default reorder and delete to customize them later in CSS
                                ->reorderable(false),
                        ]),

                    // Totals and Notes Section
                    Forms\Components\Grid::make(12)
                        ->schema([
                            Forms\Components\Placeholder::make('totals_spacer')
                                ->label('')
                                ->content('')
                                ->columnSpan(8),

                            Forms\Components\Section::make('Resumen')
                                ->schema([
                                    Forms\Components\Grid::make(12)
                                        ->schema([
                                            Forms\Components\Placeholder::make('subtotal_label')
                                                ->content('Subtotal:')
                                                ->hiddenLabel()
                                                ->columnSpan(8)
                                                ->extraAttributes(['style' => 'text-align: right; padding-right: 1rem; color: var(--text-muted); font-weight: 500;']),
                                            Forms\Components\Placeholder::make('subtotal_val')
                                                ->content(fn ($get) => '$' . number_format((float) ($get('subtotal') ?? 0), 2))
                                                ->hiddenLabel()
                                                ->columnSpan(4)
                                                ->extraAttributes(['style' => 'text-align: right; font-weight: 700; color: var(--text-main);']),

                                            Forms\Components\Placeholder::make('tax_label')
                                                ->content('IVA (16%):')
                                                ->hiddenLabel()
                                                ->columnSpan(8)
                                                ->extraAttributes(['style' => 'text-align: right; padding-right: 1rem; color: var(--text-muted); font-weight: 500;']),
                                            Forms\Components\Placeholder::make('tax_val')
                                                ->content(fn ($get) => '$' . number_format((float) ($get('tax') ?? 0), 2))
                                                ->hiddenLabel()
                                                ->columnSpan(4)
                                                ->extraAttributes(['style' => 'text-align: right; font-weight: 700; color: var(--text-main);']),

                                            Forms\Components\Placeholder::make('total_label')
                                                ->content('Total:')
                                                ->hiddenLabel()
                                                ->columnSpan(6)
                                                ->extraAttributes(['style' => 'text-align: right; padding-right: 1rem; font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-top: 1rem;']),
                                            Forms\Components\Placeholder::make('total_val')
                                                ->content(fn ($get) => '$' . number_format((float) ($get('total') ?? 0), 2))
                                                ->hiddenLabel()
                                                ->columnSpan(6)
                                                ->extraAttributes(['style' => 'text-align: right; font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-top: 1rem;']),
                                        ]),
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
