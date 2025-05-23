<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Image;

class ImportImages extends Command
{
    protected $signature = 'images:import {folder?}';
    protected $description = 'Importar imágenes desde una carpeta específica o todas las carpetas a la base de datos';

    public function handle()
    {
        $folder = $this->argument('folder');
        $basePath = public_path('images');

        if ($folder) {
            $folders = [ $folder ];
        } else {
            // Obtener todas las carpetas dentro de public/images
            $folders = array_filter(scandir($basePath), function($dir) use ($basePath) {
                return $dir !== '.' && $dir !== '..' && is_dir($basePath . DIRECTORY_SEPARATOR . $dir);
            });
        }

        foreach ($folders as $folderName) {
            $imagePath = $basePath . DIRECTORY_SEPARATOR . $folderName;
            if (!File::exists($imagePath)) {
                $this->error("La carpeta {$folderName} no existe en public/images.");
                continue;
            }

            $files = File::files($imagePath);

            foreach ($files as $file) {
                if (in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $dbPath = 'images/' . $folderName . '/' . $file->getFilename();
                    if (!Image::where('path', $dbPath)->exists()) {
                        Image::create([
                            'path' => $dbPath,
                            'folder' => $folderName,
                            'is_correct' => false,
                        ]);
                        $this->info('Imagen importada: ' . $dbPath);
                    }
                }
            }
        }

        $this->info('Todas las imágenes han sido importadas.');
    }
}
