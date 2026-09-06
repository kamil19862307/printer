<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Exceptions\DriverException;
use Intervention\Image\Exceptions\ImageDecoderException;
use Intervention\Image\Exceptions\InvalidArgumentException;
use Intervention\Image\ImageManager;

class ImageService
{
    /**
     * @throws InvalidArgumentException
     * @throws ImageDecoderException
     * @throws DriverException
     */
    public function process(UploadedFile $file): string
    {
        $manager = new ImageManager(
            new Driver()
        );

        $image = $manager->decodeSplFileInfo($file);

        $image->scaleDown(
            width: 1600,
            height: 1600
        );

        $filename = uniqid('printer_') . '.webp';

        $path = 'printers/' . $filename;

        Storage::disk('public')->makeDirectory('printers');

        $destinationPath = Storage::disk('public')->path($path);

        $image->save(
            $destinationPath,
            quality: 85
        );

        return $path;
    }
}
