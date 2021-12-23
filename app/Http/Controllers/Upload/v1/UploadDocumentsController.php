<?php

namespace App\Http\Controllers\Upload\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UploadDocumentCollection;
use App\Models\UploadDocument;
use App\Services\UploadService;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UploadDocumentsController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function index(){

        $user = optional(auth()->user())->toArray();
        return $this->showAll(collect(UploadDocumentCollection::make($this->uploadService->getDocumentsAuth($user))));

    }

    public function show($id){
        $user = optional(auth()->user())->toArray();
        return $this->showAll(collect(['file'=>$this->uploadService->findDocumentAuth($user,$id)]));

    }

    public function store(Request $request){

        $rules = [
            'file' =>'required|mimes:pdf,PDF|max:15000',
            'description' =>'required|string|max:191',
            'reason' =>'required|string|max:191',
        ];
        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $name = $this->uploadService->storeFile(new File($file));
            $this->uploadService->createDocument($this->creteDocument($file,$request->only('description','reason'),$name));
        }
        return $this->successResponseStatus("Archivo cargado con éxito.");

    }
    protected function creteDocument($file,array $data,string $name){
        return [
            'uuid' => Str::uuid(),
            'identifier' => optional(auth()->user())->identifier,
            'cip' => optional(auth()->user())->cip,
            'procedure_id' => null,
            'user_id' => auth()->id(),
            'year' => date('Y'),
            'month' => date('m'),
            'day' => date('d'),
            'name' =>$file->getClientOriginalName(),
            'path' => $name,
            'size' => $file->getSize(),
            'extension' => $file->extension(),
            'description' => $data['description'],
            'reason' => $data['reason'],
            'status' => UploadDocument::STATUS_SIN_PROCESAR,
        ];

    }


}
