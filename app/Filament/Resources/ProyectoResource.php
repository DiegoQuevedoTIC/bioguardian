<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyectoResource\Pages;
use App\Filament\Resources\ProyectoResource\RelationManagers;
use App\Models\Proyecto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProyectoResource extends Resource
{
    protected static ?string $model = Proyecto::class;

    protected static ?string $navigationIcon = 'heroicon-s-lifebuoy';
    protected static ?string $navigationGroup = 'Parametros Proyectos';
    protected static ?string $modelLabel = 'Proyecto';
    protected static ?string $navigationLabel = 'Proyectos';  

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
                TextColumn::make('codigo'),
                TextColumn::make('nombre')
                ->label('Nombre del Proyecto')
                ->searchable()
                ->limit(35),
                TextColumn::make('Descripcion')
                ->label('Descripcion')
                ->limit(100),
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
            'index' => Pages\ManageProyectos::route('/'),
        ];
    }
}
