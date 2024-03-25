<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollaboratorResource\Pages;
use App\Filament\Resources\CollaboratorResource\RelationManagers;
use App\Models\Collaborator;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
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
                Fieldset::make('Datos de la Empresa u Organizmo')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255)
                            ->label('Nombre')
                            ->required(),
                        Forms\Components\TextInput::make('address')
                            ->maxLength(255)
                            ->label('Dirección'),
                        Forms\Components\TextInput::make('website')
                            ->maxLength(255)
                            ->label('Sitio web')
                            ->url(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notas')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->label('Imagen')
                            ->image()
                            ->columnSpanFull(),
                    ]),
                Fieldset::make('Persona Responsable')
                    ->schema([
                        Forms\Components\TextInput::make('responsable')
                            ->maxLength(255)
                            ->label('Nombres y Apellidos'),
                        Forms\Components\TextInput::make('position')
                            ->maxLength(255)
                            ->label('Cargo'),
                        Forms\Components\TextInput::make('email')
                            ->maxLength(255)
                            ->label('Correo electrónico')
                            ->email(),
                        Forms\Components\TextInput::make('phone')
                            ->maxLength(255)
                            ->label('Telefono')
                            ->tel(),
                    ]),
                Fieldset::make('Otro Contacto')
                    ->schema([
                        Forms\Components\TextInput::make('responsable2')
                            ->maxLength(255)
                            ->label('Nombres y Apellidos'),
                        Forms\Components\TextInput::make('position2')
                            ->maxLength(255)
                            ->label('Cargo'),
                        Forms\Components\TextInput::make('email2')
                            ->maxLength(255)
                            ->label('Correo electrónico')
                            ->email(),
                        Forms\Components\TextInput::make('phone2')
                            ->maxLength(255)
                            ->label('Telefono')
                            ->tel(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Dirección')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('website')
                    ->label('Sitio Web')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('responsable')
                    ->label('Responsable')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('position')
                    ->label('Cargo')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('responsable2')
                    ->label('Responsable')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('position2')
                    ->label('Cargo')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email2')
                    ->label('Correo')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone2')
                    ->label('Teléfono')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Notas')
                    ->toggleable(isToggledHiddenByDefault: true)
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
