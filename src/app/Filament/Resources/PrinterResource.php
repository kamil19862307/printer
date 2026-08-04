<?php

namespace App\Filament\Resources;

use App\Enums\PrinterBrands;
use App\Enums\PrinterState;
use App\Enums\PrinterStatus;
use App\Filament\Resources\PrinterResource\Pages;
use App\Models\Printer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrinterResource extends Resource
{
    protected static ?string $model = Printer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Обязательная информация')
                    ->description('Укажите основные параметры устройства')
                    ->schema([
                        Select::make('brand')
                            ->label('Бренд')
                            ->options(collect(PrinterBrands::cases())->mapWithKeys(fn ($case) => [
                                $case->name => $case->value // Сохраняет value (HP), отображает текст
                            ]))
                            ->required()
                            ->searchable(), // Живой поиск по брендам
                        TextInput::make('model')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->label('Цена'),
                        Select::make('state')
                            ->label('Состаяние аппарата')
                            ->options(collect(PrinterState::cases())->mapWithKeys(fn ($case) => [
                                $case->name => $case->value // Сохраняет value (NEW), отображает текст
                            ]))
                            ->required(),
                    ])->columns(2),

                Section::make('Характеристики')
                    ->description('Укажите остальные детали')
                    ->schema([
                        TextInput::make('cartridge')
                            ->label('Какой картидж идёт')
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Описание'),
                        TextInput::make('pages_printed')
                            ->label('Пробег аппарата')
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Статус')
                            ->options(collect(PrinterStatus::cases())->mapWithKeys(fn ($case) => [
                                $case->name => $case->value // Сохраняет value (AVAILABLE), отображает текст
                            ]))
                            ->default(PrinterStatus::AVAILABLE->name),
                        Forms\Components\Toggle::make('usb')
                            ->onColor('success')
                            ->default(true)
                            ->label('Наличие USB'),
                        Forms\Components\Toggle::make('duplex')
                            ->onColor('success')
                            ->label('Двусторонняя печать'),
                        Forms\Components\Toggle::make('ethernet')
                            ->onColor('success')
                            ->label('Наличие сетегото разъёма'),
                        Forms\Components\Toggle::make('wifi')
                            ->onColor('success')
                            ->label('Наличие wifi'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->disk('public')
                    ->label('Фото'),
                Tables\Columns\TextColumn::make('price')
                    ->money('RUB', locale: 'ru')
                    ->sortable()
                    ->label('Цена'),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->label('Бренд'),
                Tables\Columns\TextColumn::make('model')
                    ->searchable()
                    ->label('Модель'),
                Tables\Columns\TextColumn::make('state')
                    ->searchable()
                    ->label('Состояние'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrinters::route('/'),
            'create' => Pages\CreatePrinter::route('/create'),
            'edit' => Pages\EditPrinter::route('/{record}/edit'),
        ];
    }
}
