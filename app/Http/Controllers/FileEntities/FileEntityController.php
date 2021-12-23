<?php

namespace App\Http\Controllers\FileEntities;

use App\Http\Controllers\Controller;
use App\Http\Resources\fileEntityCollection;
use App\Services\FileEntityService;
use App\Services\UploadService;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FileEntityController extends Controller
{
    protected $fileEntityService;
    protected $uploadService;

    public function __construct(FileEntityService $fileEntityService,UploadService $uploadService)
    {
        $this->fileEntityService = $fileEntityService;
        $this->uploadService = $uploadService;
    }

    public function index(){

        $files =  collect(fileEntityCollection::make($this->fileEntityService->getAll()))->map(function ($item){
          return [
              'file' => $this->uploadService->loadDocument($item['file']),
              'title' => $item['title'],
              'description' => $item['description']
          ];
      });
       return $this->showAll($files);

    }

    public function store(Request $request){

        $rules = [
            'file' =>'required|mimes:pdf,PDF|max:15000',
            'description' =>'required|string|max:191',
            'title' =>'required|string|max:191',
        ];
        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $name = $this->uploadService->storeFileEntity(new File($file));

            $this->fileEntityService->store([
                'path' =>$name,
                'title' => $request->title,
                'description' => $request->description
            ]);
        }
        return $this->successResponseStatus("Documento cargado con éxito.");

    }

}
