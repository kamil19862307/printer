<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DownloadResource\Pages;
use App\Models\Download;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DownloadResource extends Resource
{
    protected static ?string $model = Download::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основная информация')
                    ->schema([
                        Forms\Components\Select::make('download_category_id')
                            ->label('Категория')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->where('is_active', true)
                                    ->orderBy('sort')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Название')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (
                                string $operation,
                                       $state,
                                Forms\Set $set
                            ) {
                                if ($operation === 'create' && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL-идентификатор')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Описание')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('version')
                            ->label('Версия')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('operating_system')
                            ->label('Операционная система')
                            ->placeholder('Например, Windows 10/11')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('architecture')
                            ->label('Архитектура')
                            ->placeholder('Например, x64')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('source_url')
                            ->label('Официальный источник')
                            ->url()
                            ->maxLength(2048)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Файл')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Установщик или архив')
                            ->disk('downloads')
                            ->directory('')
                            ->visibility('private')
                            ->storeFileNamesIn('original_filename')
                            ->required(fn (string $operation) => $operation === 'create')
                            ->maxSize(1024 * 1024)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Публикация')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Показывать в каталоге')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable(),

                Tables\Columns\TextColumn::make('version')
                    ->label('Версия')
                    ->placeholder('Не указана')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('original_filename')
                    ->label('Имя файла')
                    ->searchable()
                    ->limit(35)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('file_size')
                    ->label('Размер')
                    ->formatStateUsing(
                        fn ($state) => number_format($state / 1024 / 1024, 2, ',', ' ') . ' МБ'
                    )
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Опубликован')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Добавлен')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('download_category_id')
                    ->label('Категория')
                    ->relationship('category', 'name'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Публикация'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Редактировать'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Удалить выбранные'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListDownloads::route('/'),
            'create' => Pages\CreateDownload::route('/create'),
            'edit' => Pages\EditDownload::route('/{record}/edit'),
        ];
    }
}
