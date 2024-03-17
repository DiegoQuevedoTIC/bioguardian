<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaisajeResource\Pages;
use App\Filament\Resources\PaisajeResource\RelationManagers;
use App\Models\Paisaje;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaisajeResource extends Resource
{
    protected static ?string $model = Paisaje::class;

    protected static ?string $navigationIcon = 'heroicon-s-presentation-chart-line';
    protected static ?string $navigationGroup = 'Parametros Proyectos';
    protected static ?string $modelLabel = 'Paisaje / Iniciativas';
    protected static ?string $navigationLabel = 'Paisajes / Iniciativas';  

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('codigo')
                ->required()
                ->maxLength(255),
                TextInput::make('nombre')
                ->required()
                ->maxLength(255),
                TextInput::make('responsable')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
                TextInput::make('presupuesto')
                ->numeric()
                ->required()
                ->maxLength(12),
                DatePicker::make('fecha_inicio')
                ->required(),
                Textarea::make('descripcion') 
                ->minLength(2)
                ->maxLength(1024)
                ->rows(6)
                ->required()
                ->columnSpanFull(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                ->label('Iniciativa')
                ->searchable(),
                TextColumn::make('responsable')
                ->label('Responsable Paisaje')
                ->sortable(),
                TextColumn::make('fecha_inicio')
                ->label('Fecha de Inicio')
                ->sortable(),
                TextColumn::make('presupuesto')
                ->label('Valor Presupuesto')
                ->sortable()
                ->numeric()
                ->money('COP')
                ->alignment(Alignment::End), 
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePaisajes::route('/'),
        ];
    }
}
