<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class PictureService
{
    /**
     * Permet d'enregistrer une image dans le dossier storage/app/public/$folder
     * @param UploadedFile $file L'image à enregistrer
     * @param string $folder Le dossier de destination
     * @return ?string L'url de l'image si elle a été enregistrée correctement, sinon null
     */
    public function uploadPicture($file, $folder)
    {
        if (!$file) return null;
        return $file->store($folder, 'public');
    }
}