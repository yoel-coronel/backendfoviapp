<?php

namespace App\Services;

use App\Models\FileEntity;
use Illuminate\Http\File;

interface UploadService
{

    public function storeFile(File $file);
    public function storeFileEntity(File $file);
    public function deleteFileEntity($path);
    public function createDocument(array $array);
    public function getDocumentsAuth(array $user);
    public function findDocumentAuth(array $user,$id);
    public function loadDocument(string $path);

}