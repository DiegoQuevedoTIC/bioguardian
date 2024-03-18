<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CapacitacionResource\Pages;
use App\Filament\Resources\CapacitacionResource\RelationManagers;
use App\Models\Capacitacion;
use App\Models\Linea;
use App\Models\Proyecto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RelationSearchInput;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CapacitacionResource extends Resource
{
    protected static ?string $model = Capacitacion::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';
    protected static ?string $navigationGroup = 'Gestion Procesos Misionales';
    protected static ?string $modelLabel = 'Capacitacion ';
    protected static ?string $navigationLabel = 'Capacitaciones';  

    public static function form(Form $form): Form
    {
        return $form
            ->columns(6)
            ->schema([
                TextInput::make('codigo')
                        ->markAsRequired(false)
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->minLength(1)
                        ->columnSpan(1)
                        ->disabled(fn ($record) => optional($record)->exists ?? false) // Verificar si $record existe antes de acceder a ->exists
                        ->maxLength(5)
                        ->label('Id Capacitacion'),
                TextInput::make('nombre')
                        ->markAsRequired(false)
                        ->required()
                        ->minLength(1)
                        ->maxLength(200)
                        ->columnSpan(4)
                        ->label('Taller/Capacitación'),
                DatePicker::make('fecha')
                        ->markAsRequired()
                        ->required()
                        ->columnSpan(2)
                        ->label('Fecha Capacitacion'),
                TextInput::make('no_talleres')
                        ->columnSpan(1)
                        ->minValue(0)
                        ->maxValue(100)
                        ->type('number')
                        ->label('N° Talleres'),
                TextInput::make('capacitaciones')
                        ->columnSpan(1)
                        ->minValue(0)
                        ->maxValue(100)
                        ->type('number')
                        ->label('N° Talleres'),
                TextInput::make('total_asistentes')
                        ->columnSpan(1)
                        ->minValue(0)
                        ->maxValue(9999)
                        ->type('number')
                        ->label('No. total personas'),
                Select::make('proyecto_id')
                        ->relationship('proyecto', 'nombre')
                        ->required()
                        ->markAsRequired(false)
                        ->preload()
                        ->columnSpan(2)
                        ->label('Proyecto'),
                Select::make('linea_id')
                        ->relationship('linea', 'nombre')
                        ->required()
                        ->markAsRequired(false)
                        ->preload()
                        ->columnSpan(1)
                        ->label('Linea - Eje estrategico'),
                FileUpload::make('soporte_capacitacion')
                        ->preserveFilenames()
                        ->columnSpan(2)
                        ->moveFiles(),
            ]) ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo')
                ->label('Id Capacitacion')
                ->searchable(),
                TextColumn::make('nombre')
                ->label('Tema Capacitacion')
                ->searchable(),
                TextColumn::make('fecha')
                ->label('Fecha de Capacitacion')
                ->sortable(),
                TextColumn::make('linea.nombre')
                ->label('Linea - Eje estrategico'),
                TextColumn::make('proyecto.nombre')
                ->label('Proyecto'),
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
            'index' => Pages\ListCapacitacions::route('/'),
            'create' => Pages\CreateCapacitacion::route('/create'),
            'edit' => Pages\EditCapacitacion::route('/{record}/edit'),
        ];
    }
}
