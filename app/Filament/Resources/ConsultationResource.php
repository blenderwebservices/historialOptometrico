<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Filament\Resources\ConsultationResource\RelationManagers;
use App\Models\Consultation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Grid::make(12)
                        ->schema([
                                Forms\Components\Section::make('Información del Paciente')
                                    ->schema([
                                            Forms\Components\Select::make('patient_id')
                                                ->relationship('patient', 'name')
                                                ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} {$record->last_name}")
                                                ->searchable()
                                                ->preload()
                                                ->required(),
                                            Forms\Components\DatePicker::make('consultation_date')
                                                ->default(now())
                                                ->required(),
                                        ])
                                    ->columns(2)
                                    ->columnSpan(5)
                                    ->extraAttributes([
                                            'class' => 'relative z-[10] focus-within:z-[50]',
                                        ]),

                                Forms\Components\Section::make('Graduación (Receta)')
                                    ->schema([
                                            Forms\Components\Grid::make(4)
                                                ->schema([
                                                        Forms\Components\Placeholder::make('eye_label_r')
                                                            ->label('Ojo Derecho (OD)')
                                                            ->columnSpan(4)
                                                            ->extraAttributes(['style' => 'font-weight: 700; margin-bottom: -1rem;']),
                                                        Forms\Components\TextInput::make('right_eye_sph')
                                                            ->label('Esfera (SPH)')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(-20)
                                                            ->maxValue(20)
                                                            ->hint('Rango: -20 a +20')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('right_eye_cyl')
                                                            ->label('Cilindro (CYL)')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(-6)
                                                            ->maxValue(6)
                                                            ->hint('Rango: -6 a +6')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('right_eye_axis')
                                                            ->label('Eje (AXIS)')
                                                            ->numeric()
                                                            ->step(1)
                                                            ->minValue(0)
                                                            ->maxValue(180)
                                                            ->hint('Rango: 0 a 180°')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('right_eye_add')
                                                            ->label('Adición (ADD)')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(0)
                                                            ->maxValue(4)
                                                            ->hint('Rango: 0 a 4')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                    ])->columns(4),

                                            Forms\Components\Grid::make(4)
                                                ->schema([
                                                        Forms\Components\Placeholder::make('eye_label_l')
                                                            ->label('Ojo Izquierdo (OI)')
                                                            ->columnSpan(4)
                                                            ->extraAttributes(['style' => 'font-weight: 700; margin-top: 1rem; margin-bottom: -1rem;']),
                                                        Forms\Components\TextInput::make('left_eye_sph')
                                                            ->label('Esfera (SPH)')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(-20)
                                                            ->maxValue(20)
                                                            ->hint('Rango: -20 a +20')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('left_eye_cyl')
                                                            ->label('Cilindro (CYL)')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(-6)
                                                            ->maxValue(6)
                                                            ->hint('Rango: -6 a +6')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('left_eye_axis')
                                                            ->label('Eje (AXIS)')
                                                            ->numeric()
                                                            ->step(1)
                                                            ->minValue(0)
                                                            ->maxValue(180)
                                                            ->hint('Rango: 0 a 180°')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                        Forms\Components\TextInput::make('left_eye_add')
                                                            ->label('Adición (ADD)')
                                                            ->numeric()
                                                            ->step(0.25)
                                                            ->minValue(0)
                                                            ->maxValue(4)
                                                            ->hint('Rango: 0 a 4')
                                                            ->hintIcon('heroicon-m-question-mark-circle'),
                                                    ])->columns(4),
                                        ])
                                    ->columnSpan(7)
                                    ->extraAttributes([
                                            'class' => 'relative z-[5] focus-within:z-[50]',
                                        ]),
                            ]),

                    Forms\Components\Section::make('Productos / Venta')
                        ->schema([
                                Forms\Components\Repeater::make('consultationProducts')
                                    ->relationship()
                                    ->schema([
                                            Forms\Components\Select::make('product_id')
                                                ->relationship('product', 'name')
                                                ->required()
                                                ->reactive()
                                                ->afterStateUpdated(
                                                    fn(Forms\Set $set, $state) =>
                                                    $set('price_at_time', \App\Models\Product::find($state)?->price ?? 0)
                                                )
                                                ->columnSpan(3),
                                            Forms\Components\TextInput::make('quantity')
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
                                            $subtotal += ($product['quantity'] ?? 0) * ($product['price_at_time'] ?? 0);
                                        }
                                        $set('subtotal', $subtotal);
                                        $set('total', $subtotal * 1.16); // Example tax 16%
                                        $set('tax', $subtotal * 0.16);
                                    }),
                            ]),

                    Forms\Components\Section::make('Totales')
                        ->schema([
                                Forms\Components\TextInput::make('subtotal')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('$'),
                                Forms\Components\TextInput::make('tax')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('$'),
                                Forms\Components\TextInput::make('total')
                                    ->numeric()
                                    ->readOnly()
                                    ->prefix('$'),
                                Forms\Components\Textarea::make('internal_notes')
                                    ->columnSpanFull(),
                            ])->columns(3),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    Tables\Columns\TextColumn::make('patient_id')
                        ->numeric()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('consultation_date')
                        ->date()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('right_eye_sph')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('right_eye_cyl')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('right_eye_axis')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('right_eye_add')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('left_eye_sph')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('left_eye_cyl')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('left_eye_axis')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('left_eye_add')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('subtotal')
                        ->numeric()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('tax')
                        ->numeric()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('total')
                        ->numeric()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])
            ->filters([
                    //
                ])
            ->actions([
                    Tables\Actions\EditAction::make(),
                ])
            ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConsultations::route('/'),
            'create' => Pages\CreateConsultation::route('/create'),
            'edit' => Pages\EditConsultation::route('/{record}/edit'),
        ];
    }
}
