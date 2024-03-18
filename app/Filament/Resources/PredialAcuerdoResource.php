<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PredialAcuerdoResource\Pages;
use App\Filament\Resources\PredialAcuerdoResource\RelationManagers;
use App\Models\PredialAcuerdo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RelationSearchInput;
use Filament\Forms\ComponentGroups\InputGroup;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Departamento;
use App\Models\Estado;
use App\Models\Linea;
use App\Models\Municipio;
use App\Models\Paisaje;
use App\Models\Proyecto;

class PredialAcuerdoResource extends Resource
{
    protected static ?string $model = PredialAcuerdo::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Acuerdos Prediales';
    protected static ?string $modelLabel = 'Acuerdo Predial ';
    protected static ?string $navigationLabel = 'Crear Acuerdo Predial';  

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Wizard::make()
                ->steps([
                    Wizard\Step::make('Datos del Predio ')
                    ->columns(4)
                    ->schema([
                        TextInput::make('codigo')
                                    ->markAsRequired(false)
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->minLength(1)
                                    ->disabled(fn ($record) => optional($record)->exists ?? false) // Verificar si $record existe antes de acceder a ->exists
                                    ->maxLength(16)
                                    ->label('Codigo Id del acuerdo'),
                        TextInput::make('nombre')
                                    ->markAsRequired(false)
                                    ->required()
                                    ->minLength(4)
                                    ->maxLength(120)
                                    ->label('Nombre del Predio'),
                        TextInput::make('id_predio')
                                    ->markAsRequired(false)
                                    ->minLength(1)
                                    ->maxLength(12)
                                    ->label('Id Predio'),
                        Select::make('linea_id')
                                ->relationship('linea', 'nombre')
                                ->required()
                                ->markAsRequired(false)
                                ->preload()
                                ->label('Linea - Eje estrategico'),
                        Select::make('paisaje_id')
                                ->relationship('paisaje', 'nombre')
                                ->required()
                                ->markAsRequired(false)
                                ->preload()
                                ->label('Paisaje /Iniciativa'),
                        Select::make('proyecto_id')
                                ->relationship('proyecto', 'nombre')
                                ->required()
                                ->markAsRequired(false)
                                ->preload()
                                ->label('Proyecto'),
                        Select::make('estado_id')
                                ->relationship('estado', 'nombre')
                                ->required()
                                ->markAsRequired(false)
                                ->preload()
                                ->label('Estado Actual'), 

                            ]),




                            
                            
                            
                            
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPredialAcuerdos::route('/'),
            'create' => Pages\CreatePredialAcuerdo::route('/create'),
            'edit' => Pages\EditPredialAcuerdo::route('/{record}/edit'),
        ];
    }
}
