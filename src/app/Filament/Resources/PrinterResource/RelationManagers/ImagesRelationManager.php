<?php

namespace App\Filament\Resources\PrinterResource\RelationManagers;

//use App\Services\ImageService;
use App\Services\ImageService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImagesRelationManager extends RelationManager
{
//    public function __construct(protected ImageService $imageService)
//    {
//    }
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
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {
                        return app(ImageService::class)->process($file);
                    })
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

                        $sort = ($printer->images()->max('sort') ?? -1) + 1;

                        foreach ($data['images'] as $imagePath) {
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
