<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Image;

class ImportImages extends Command
{
    protected $signature = 'images:import {folder=seriesTamaño}';
    protected $description = 'Importar imágenes desde una carpeta específica a la base de datos';

    public function handle()
    {
        $folder = $this->argument('folder');
        $imagePath = public_path('images/' . $folder);

        if (!File::exists($imagePath)) {
            $this->error("La carpeta {$folder} no existe en public/images.");
            return;
        }

        $files = File::files($imagePath);

        foreach ($files as $file) {
            if (in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                if (!Image::where('path', 'images/' . $folder . '/' . $file->getFilename())->exists()) {
                    Image::create([
                        'path' => 'images/' . $folder . '/' . $file->getFilename(),
                        'folder' => $folder,
                        'is_correct' => false,
                    ]);
                    $this->info('Imagen importada: ' . $file->getFilename());
                }
            }
        }

        $this->info('Todas las imágenes de la carpeta han sido importadas.');
    }
}
