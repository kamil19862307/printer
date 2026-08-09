<?php

namespace App\Filament\Resources\PrinterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('images')
                    ->label('Фотография')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('printers')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image_path')
            ->defaultSort('sort')
            ->reorderable('sort')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Фото')
                    ->disk('public'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Добавить фоторгафии')
                    ->using(function (array $data) {
                        $printer = $this->getOwnerRecord();

                        foreach ($data['images'] as $imagePath) {
                            $sort = ($printer->images()->max('sort') ?? -1) + 1;

                            $printer->images()->create([
                                'image_path' => $imagePath,
                                'sort' => $sort++,
                            ]);
                        }

                        return $printer->images()->latest()->first();
                    })
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
}
