<?php

namespace App\Filament\Resources\PrinterResource\RelationManagers;

//use App\Services\ImageService;
use App\Models\PrinterImage;
use App\Services\ImageService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Exceptions\ImageDecoderException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use function Symfony\Component\Translation\t;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected ?string $oldImagePath = null;

    protected array $justCreatedImages = [];

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
                        try {
                            $path = app(ImageService::class)->process($file);

                            $this->justCreatedImages[] = $path;

                            return $path;
                        } catch (ImageDecoderException | \InvalidArgumentException $e) {
                            $this->rollbackCreatedImages();

                            throw ValidationException::withMessages([
                                'images' => 'Один из загружаемых файлов поврежден или не является корректным изображением.',
                            ]);

                        } catch (\Exception $e) {
                            // На случай других непредвиденных ошибок
                            $this->rollbackCreatedImages();

                            report($e);

                            throw ValidationException::withMessages([
                                'images' => 'Произошла ошибка при обработке изображения, попробуйте другой файл',
                            ]);
                        }
                    })
                    ->required(),
            ]);
    }

    /**
     * Метод для удаления «осиротевших» файлов с диска
     */
    protected function rollbackCreatedImages(): void
    {
        foreach ($this->justCreatedImages as $image) {
            Storage::disk('public')->delete($image);
        }

        $this->justCreatedImages = [];
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
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Фотография')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('printers'),
                    ])

                    ->before(function (PrinterImage $record) {
                        $this->oldImagePath = $record->image_path;
                    })

                    ->after(function () {
                        if ($this->oldImagePath) {
                            Storage::disk('public')->delete($this->oldImagePath);

                            $this->oldImagePath = null;
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
