<?php

namespace App\Console\Commands;

use App\Services\ImageService;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TestImageProcessing extends Command
{
    protected $signature = 'image:test {path}';

    protected $description = 'Test printer image processing';

    public function handle(ImageService $imageService): int
    {
        $path = $this->argument('path');

        if (! file_exists($path)) {
            $this->error("Файл не найден: {$path}");

            return self::FAILURE;
        }

        $this->info('Исходный файл:' . $path);
        $this->info("Размер: " . $this->formatBytes(filesize($path)));

        $image = getimagesize($path);

        $this->info(
            "Разрешение: {$image[0]}x{$image[1]}"
        );

        $uploadedFile = new UploadedFile(
            $path,
            basename($path),
            mime_content_type($path),
            null,
            true
        );

        $this->info(
            'Память до обработки: ' .
            $this->formatBytes(memory_get_usage(true))
        );

        $this->info(
            'Пиковая память до обработки: ' .
            $this->formatBytes(memory_get_peak_usage(true))
        );

        $result = $imageService->process($uploadedFile);

        $resultPath = Storage::disk('public')->path($result);

        $this->newLine();

        $this->info('Результат:');
        $this->info("Путь: {$result}");
        $this->info("Размер: " . $this->formatBytes(filesize($resultPath)));

        $resultImage = getimagesize($resultPath);

        $this->info(
            "Разрешение: {$resultImage[0]}x{$resultImage[1]}"
        );

        return self::SUCCESS;
    }

    private function formatBytes(int $bytes): string
    {
        return number_format($bytes / 1024 / 1024, 2) . ' MB';
    }
}
