<?php

namespace App\Services\Impl;

use App\Models\FileEntity;
use App\Repository\UploadDocumentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\File;
use App\Services\UploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadServiceImpl implements UploadService
{
    protected $uploadDocumentRepository;

    public function __construct(UploadDocumentRepository $uploadDocumentRepository)
    {
        $this->uploadDocumentRepository = $uploadDocumentRepository;
    }
    public function storeFileEntity(File $file)
    {
        try {
            $name ='entities/'.Str::uuid()->toString().'.'.$file->extension();
            Storage::disk('uploads')->put($name, $file->getContent());
            return $name;
        }catch (\Exception $exception){
            return null;
        }
    }

    public function storeFile(File $file)
    {
        try {
            $name = date('Y').'/'.date('m').'/'.date('d').'/'.optional(auth()->user())->identifier.'/'.optional(auth()->user())->cip.'/'.Str::uuid()->toString().'.'.$file->extension();
            Storage::disk('uploads')->put($name, $file->getContent());
            return $name;
        }catch (\Exception $exception){
            return null;
        }

    }

    public function createDocument(array $array)
    {
        return $this->uploadDocumentRepository->create($array);
    }

    public function getDocumentsAuth(array $user)
    {
        return $this->uploadDocumentRepository->getDocumentsAuth($user);
    }

    public function findDocumentAuth(array $user, $id)
    {
        $document = $this->uploadDocumentRepository->findDocumentsAuth($user,$id);
        if($document){
            $archivo = Storage::disk('uploads')->get($document->path);
            return base64_encode($archivo);
        }else{
            throw new ModelNotFoundException("Recurso no localizado");
        }

    }


    public function loadDocument(string $path)
    {
        if(Storage::disk('uploads')->exists($path)){
            return base64_encode(Storage::disk('uploads')->get($path));
        }else{
            return null;
        }


    }
}