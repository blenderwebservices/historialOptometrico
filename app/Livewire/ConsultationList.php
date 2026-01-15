<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Consultation;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\TextColumn;

class ConsultationList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Consultation::query())
            ->columns([
                    TextColumn::make('id')
                        ->label('ID')
                        ->formatStateUsing(fn($state) => '#' . str_pad($state, 5, '0', STR_PAD_LEFT))
                        ->sortable()
                        ->searchable()
                        ->fontFamily('monospace')
                        ->color('gray')
                        ->toggleable(),
                    TextColumn::make('patient.full_name') // Assuming a full_name attribute exists or use fallback
                        ->label('Paciente')
                        ->getStateUsing(fn($record) => $record->patient->name . ' ' . $record->patient->last_name)
                        ->searchable(['name', 'last_name'])
                        ->sortable()
                        ->toggleable(),
                    TextColumn::make('consultation_date')
                        ->label('Fecha')
                        ->date('d/m/Y')
                        ->sortable()
                        ->toggleable(),
                    TextColumn::make('right_eye_sph')
                        ->label('OD Esf.')
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('right_eye_cyl')
                        ->label('OD Cil.')
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('left_eye_sph')
                        ->label('OI Esf.')
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('left_eye_cyl')
                        ->label('OI Cil.')
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('total')
                        ->label('Total')
                        ->money('MXN')
                        ->sortable()
                        ->weight('bold')
                        ->color('primary')
                        ->toggleable(),
                ])
            ->filters([
                    Tables\Filters\Filter::make('recent')
                        ->query(fn($query) => $query->where('consultation_date', '>=', now()->subDays(30))),
                    Tables\Filters\SelectFilter::make('patient_id')
                        ->label('Paciente')
                        ->relationship('patient', 'name'),
                ])
            ->actions([
                    Tables\Actions\Action::make('edit')
                        ->label('Editar')
                        ->icon('heroicon-m-pencil-square')
                        ->color('indigo')
                        ->url(fn(Consultation $record): string => route('consultation.edit', $record)),
                    Tables\Actions\DeleteAction::make()
                        ->label('Eliminar')
                        ->modalHeading('¿Estás seguro de eliminar esta consulta?'),
                ])
            ->groups([
                    Tables\Grouping\Group::make('consultation_date')
                        ->label('Fecha')
                        ->date(),
                    Tables\Grouping\Group::make('patient.name')
                        ->label('Paciente'),
                ])
            ->bulkActions([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar')
                        ->icon('heroicon-m-trash')
                        ->color('danger'),
                ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No hay consultas registradas')
            ->emptyStateDescription('Comienza creando una nueva consulta.')
            ->persistFiltersInSession()
            ->persistSortInSession()
            ->persistColumnSearchesInSession();
    }

    public function render(): View
    {
        return view('livewire.consultation-list')
            ->layout('layouts.app');
    }
}
