<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartamentoResource\Pages;
use App\Filament\Resources\DepartamentoResource\RelationManagers;
use App\Models\Departamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartamentoResource extends Resource
{
    protected static ?string $model = Departamento::class;

    protected static ?string $navigationIcon = 'heroicon-m-globe-americas';
    protected static ?string $navigationGroup = 'Ubicacion Geografica';
    protected static ?string $modelLabel = 'Departamento';
    protected static ?string $navigationLabel = 'Departamentos';  

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\TextInput::make('codigo')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(255),
                        Forms\Components\Select::make('pais_id')
                        ->relationship('pais', 'nombre')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('codigo')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('nombre')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('indicativo')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->required()
        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo'),
                Tables\Columns\TextColumn::make('nombre')
                ->searchable(),
                Tables\Columns\TextColumn::make('pais.nombre'),
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
            'index' => Pages\ManageDepartamentos::route('/'),
        ];
    }
}
