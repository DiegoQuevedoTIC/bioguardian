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
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Departamento;
use App\Models\Vereda;
use App\Models\Estado;
use App\Models\Linea;
use App\Models\Municipio;
use App\Models\Paisaje;
use App\Models\Proyecto;

class PredialAcuerdoResource extends Resource
{
    protected static ?string $model = PredialAcuerdo::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Gestion Procesos Misionales';
    protected static ?string $modelLabel = 'Acuerdo Predial ';
    protected static ?string $navigationLabel = ' Acuerdos Prediales';  

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Wizard::make()
                ->steps([
                    Wizard\Step::make('Datos del Predio ')
                    ->columns(5)
                    ->schema([
                        TextInput::make('codigo')
                                    ->markAsRequired(false)
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->minLength(1)
                                    ->columnSpan(1)
                                    ->disabled(fn ($record) => optional($record)->exists ?? false) // Verificar si $record existe antes de acceder a ->exists
                                    ->maxLength(16)
                                    ->label('Codigo Id del acuerdo'),
                        TextInput::make('nombre')
                                    ->markAsRequired(false)
                                    ->required()
                                    ->minLength(4)
                                    ->maxLength(120)
                                    ->columnSpan(3)
                                    ->label('Nombre del Predio'),
                        TextInput::make('id_predio')
                                    ->markAsRequired(false)
                                    ->minLength(1)
                                    ->maxLength(12)
                                    ->columnSpan(1)
                                    ->label('Id Predio'),
                        Select::make('linea_id')
                                ->relationship('linea', 'nombre')
                                ->required()
                                ->markAsRequired(false)
                                ->preload()
                                ->columnSpan(2)
                                ->label('Linea - Eje estrategico'),
                        Select::make('paisaje_id')
                                ->relationship('paisaje', 'nombre')
                                ->required()
                                ->markAsRequired(false)
                                ->preload()
                                ->columnSpan(2)
                                ->label('Paisaje /Iniciativa'),
                        Select::make('proyecto_id')
                                ->relationship('proyecto', 'nombre')
                                ->required()
                                ->markAsRequired(false)
                                ->preload()
                                ->columnSpan(4)
                                ->label('Proyecto'),
                        Select::make('estado_id')
                                ->relationship('estado', 'nombre')
                                ->required()
                                ->columnSpan(1)
                                ->markAsRequired(false)
                                ->preload()
                                ->label('Estado Actual'), 
                        Select::make('departamento_id')
                                ->options(Departamento::query()->pluck('nombre', 'id'))
                                ->markAsRequired(false)
                                ->required()
                                ->preload()
                                ->columnSpan(1)
                                ->live()
                                ->label('Departamento'),
                        Select::make('municipio_id')
                                ->options(function (Get $get) {
                                    $departamento_id = $get('departamento_id');
                                    return Municipio::query()
                                ->where('departamento_id', $departamento_id)
                                ->pluck('nombre', 'id');})
                                ->markAsRequired(false)
                                ->required()
                                ->columnSpan(1)
                                ->live()
                                ->preload()
                                ->label('Municipio '),
                        Select::make('vereda_id')
                                ->options(function (Get $get) {
                                    $municipio_id = $get('municipio_id');
                                    return Vereda::query()
                                ->where('municipio_id', $municipio_id)
                                ->pluck('nombre', 'id');})
                                ->markAsRequired(false)
                                ->required()
                                ->columnSpan(1)
                                ->live()
                                ->preload()
                                ->label('Vereda-Corregimiento '),
                            ]),

                            Wizard\Step::make('Caracterizacion del Acuerdo ')
                            ->columns(6)
                            ->schema([
                                TextInput::make('nombre_firmante_local')
                                    ->columnSpan(4)
                                    ->minLength(1)
                                    ->maxLength(100)
                                    ->label('Firmante local'),
                                TextInput::make('id_firmante_local')
                                    ->columnSpan(2)
                                    ->minLength(1)
                                    ->maxLength(16)
                                    ->label('Cedula'),
                                DatePicker::make('fecha_inicial')
                                    ->markAsRequired()
                                    ->required()
                                    ->columnSpan(2)
                                    ->label('Fecha Inicio'),
                                DatePicker::make('fecha_finalizacion')
                                    ->markAsRequired()
                                    ->required()
                                    ->columnSpan(2)
                                    ->label('Fecha de Finalizacion'),
                                Toggle::make('renovado')
                                    ->required()
                                    ->columnSpan(1)
                                    ->onColor('primary')
                                    ->offColor('warning')
                                    ->label('Renovación?'),
                                TextInput::make('firmante_lider')
                                    ->columnSpan(3)
                                    ->minLength(1)
                                    ->maxLength(100)
                                    ->label('Institución lider firmante'),
                                TextInput::make('firmantes_adicionales')
                                    ->columnSpan(3)
                                    ->minLength(1)
                                    ->maxLength(100)
                                    ->label('Otras partes firmantes o involucradas'), 
                                TextInput::make('area_predio')
                                    ->columnSpan(2)
                                    ->minValue(0)
                                    ->maxValue(10000000)
                                    ->type('number') 
                                    ->label('Área predio (ha)')
                                    ->step('0.01') 
                                    ->placeholder('0.00'), 
                                TextInput::make('area_bosque')
                                    ->columnSpan(2)
                                    ->minValue(0)
                                    ->maxValue(10000000)
                                    ->type('number') 
                                    ->label('Área bosque (ha)')
                                    ->step('0.01') 
                                    ->placeholder('0.00'), 
                                TextInput::make('area_productiva')
                                    ->columnSpan(2)
                                    ->minValue(0)
                                    ->maxValue(10000000)
                                    ->type('number') 
                                    ->label('Área productiva manejo mejorado (ha)')
                                    ->step('0.01')
                                    ->placeholder('0.00'), 
                                TextInput::make('inversion')
                                    ->columnSpan(2)
                                    ->minValue(0)
                                    ->maxValue(10000000000)
                                    ->type('number')
                                    ->label('Inversión total'),
                                TextInput::make('familias_beneficio')
                                    ->columnSpan(1)
                                    ->minValue(0)
                                    ->maxValue(1000)
                                    ->type('number')
                                    ->label('No. familias beneficiadas'),
                                TextInput::make('personas_beneficio')
                                    ->columnSpan(1)
                                    ->minValue(0)
                                    ->maxValue(10000)
                                    ->type('number')
                                    ->label('No personas beneficiadas'),
                                Toggle::make('planificacion')
                                    ->required()
                                    ->columnSpan(1)
                                    ->onColor('primary')
                                    ->offColor('warning')
                                    ->label('¿Hay planficación de todo el predio?'),
                                    ]),
         
                            Wizard\Step::make('Impacto del Acuerdo ')
                            ->columns(6)
                            ->schema([
                                Toggle::make('area_protegida')
                                        ->required()
                                        ->columnSpan(2)
                                        ->onColor('primary')
                                        ->offColor('warning')
                                        ->label('¿Se encuentra dentro de un área protegida??'),
                                TextInput::make('areas_protegidas_id')
                                        ->columnSpan(4)
                                        ->minLength(1)
                                        ->maxLength(100)
                                        ->label('en caso positivo, ¿Cuál/es AP?'),
                                TextInput::make('especies_valores_conservacion')
                                        ->columnSpanFull()
                                        ->minLength(1)
                                        ->maxLength(250)
                                        ->label('Especies / valores objeto de conservacion'),
                                Toggle::make('restauracion')
                                        ->required()
                                        ->columnSpan(1)
                                        ->onColor('primary')
                                        ->offColor('warning')
                                        ->label('Restauracion'),
                                Toggle::make('sistemas_productivos')
                                        ->required()
                                        ->columnSpan(1)
                                        ->onColor('primary')
                                        ->offColor('warning')
                                        ->label('Sistemas Productivos'),
                                Toggle::make('seguridad_alimentaria')
                                        ->required()
                                        ->columnSpan(1)
                                        ->onColor('primary')
                                        ->offColor('warning')
                                        ->label('Seguridad Alimenaria'),
                                Toggle::make('wash')
                                        ->required()
                                        ->columnSpan(1)
                                        ->onColor('primary')
                                        ->offColor('warning')
                                        ->label('¿Wash'),
                                Toggle::make('iniciativa_biodiversidad')
                                        ->required()
                                        ->columnSpan(2)
                                        ->onColor('primary')
                                        ->offColor('warning')
                                        ->label('Iniciativas sostenibles basadas en biodiversidad'),
                                TextInput::make('especies_sostenibles')
                                        ->columnSpan(5)
                                        ->minLength(1)
                                        ->maxLength(200)
                                        ->label('Nombre de las especies de inciativas sostenibles'),
                                TextInput::make('area_cadena_valor_sostenible')
                                        ->columnSpan(1)
                                        ->minValue(0)
                                        ->maxValue(10000000)
                                        ->type('number') 
                                        ->label('Ha con practicas de cadenas valor sostenible')
                                        ->step('0.01')
                                        ->placeholder('0.00'), 
                                TextInput::make('cadena_valor')
                                        ->columnSpan(5)
                                        ->minLength(1)
                                        ->maxLength(200)
                                        ->label('Cadenas de Valor'),
                                Toggle::make('asesoria_tecnica')
                                        ->required()
                                        ->columnSpan(1)
                                        ->onColor('primary')
                                        ->offColor('warning')
                                        ->label('¿Asesoría técnica?'),
                                    ]),             
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo')
                ->label('Iniciativa')
                ->searchable(),
                TextColumn::make('nombre')
                ->label('Iniciativa')
                ->searchable(),
                TextColumn::make('fecha_inicial')
                ->label('Fecha de Inicio')
                ->sortable(),
                TextColumn::make('inversion')
                ->label('Valor Inversion')
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
