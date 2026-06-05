<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class PictureService
{
    /**
     * Permet d'enregistrer l'image
     * @param UploadedFile $file L'image à enregistrer
     * @param string $folder Le dossier de destination (products, categories)
     */
    public function uploadPicture($file, $folder): ?string
    {
        if (!$file) return null;
        return $file->store($folder, 'public');
    }
}