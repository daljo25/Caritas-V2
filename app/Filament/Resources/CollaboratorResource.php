<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollaboratorResource\Pages;
use App\Filament\Resources\CollaboratorResource\RelationManagers;
use App\Models\Collaborator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CollaboratorResource extends Resource
{
    protected static ?string $model = Collaborator::class;
    protected static ?string $navigationGroup = 'Registro de datos';
    protected static ?string $label = 'Colaboradores';
    protected static ?string $navigationIcon = 'tabler-building';
    protected static ?string $recordTitleAttribute = 'Colaboradores';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('website')
                    ->url(),
                Forms\Components\TextInput::make('responsable'),
                Forms\Components\TextInput::make('position'),
                Forms\Components\TextInput::make('email')
                    ->email(),
                Forms\Components\TextInput::make('phone')
                    ->tel(),
                Forms\Components\TextInput::make('responsable2'),
                Forms\Components\TextInput::make('position2'),
                Forms\Components\TextInput::make('email2')
                    ->email(),
                Forms\Components\TextInput::make('phone2')
                    ->tel(),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('website'),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('responsable'),
                Tables\Columns\TextColumn::make('position'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('responsable2'),
                Tables\Columns\TextColumn::make('position2'),
                Tables\Columns\TextColumn::make('email2'),
                Tables\Columns\TextColumn::make('phone2'),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(20),
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
            'index' => Pages\ManageCollaborators::route('/'),
        ];
    }
}
