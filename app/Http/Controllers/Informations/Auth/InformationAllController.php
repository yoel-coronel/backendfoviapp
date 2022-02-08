<?php

namespace App\Http\Controllers\Informations\Auth;

use App\Http\Controllers\Controller;
use App\Services\InformationAllService;
use App\Services\UploadService;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InformationAllController extends Controller
{
    /**
     * @var InformationAllService
     */
    private $informationAllService;
    /**
     * @var UploadService
     */
    private $uploadService;

    public function __construct(InformationAllService $informationAllService,UploadService $uploadService)
    {
        $this->informationAllService = $informationAllService;
        $this->uploadService =$uploadService;
    }

    public function index(Request $request){
        $rules = [
            'token' =>'required'
        ];
        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        if (!Hash::check($request->token, config('app.key_sifo'))){
            return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
        }

        return $this->showAll(collect($this->informationAllService->all()));
    }
    public function show(Request $request, $id){
        $rules = [
            'token' =>'required'
        ];
        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        if (!Hash::check($request->token, config('app.key_sifo'))){
            return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
        }
        return $this->showOne($this->informationAllService->find($id));
    }
    public function store(Request $request){
        $rules = [
            'file' =>'nullable|max:15000',
            'title' => 'required|max:191',
            'subtitle' => 'nullable|max:191',
            'description' =>'required|string|max:2000',
            'link' =>'nullable|string|max:191',
            'token' =>'required'
        ];

        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }

        if (!Hash::check($request->token, config('app.key_sifo'))){
            return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
        }
        $name = "";
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $name = $this->uploadService->storeFileEntity(new File($file));

        }

        $this->informationAllService->create([
            'uuid'=>Str::uuid(),
            'title'=>$request->title,
            'sub-title'=>$request->subtitle,
            'path' =>$name,
            'description' => $request->description,
            'link' => $request->link
        ]);

        return $this->successResponseStatus("Información enviado al servidor.");
    }
    public function update(Request $request, $id){

        $rules = [
            'file' =>'nullable|max:15000',
            'title' => 'required|max:191',
            'subtitle' => 'nullable|max:191',
            'description' =>'required|string|max:2000',
            'link' =>'nullable|string|max:191',
            'token' =>'required'
        ];

        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }

        if (!Hash::check($request->token, config('app.key_sifo'))){
            return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
        }
        $name = "";

        if ($request->hasFile('file')){
            $file = $request->file('file');

            $info = $this->informationAllService->find($id);
            if($info->path){
                $this->uploadService->deleteFileEntity($info->path);
            }
            $name = $this->uploadService->storeFileEntity(new File($file));
        }
        $this->informationAllService->update([
            'title'=>$request->title,
            'sub-title'=>$request->subtitle,
            'path' =>$name,
            'description' => $request->description,
            'link' => $request->link
        ],$id);

        return $this->successResponseStatus("Información actualizado con éxito.");

    }
    public function delete(Request $request,$id){

        $rules = [
            'token' =>'required'
        ];
        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        if (!Hash::check($request->token, config('app.key_sifo'))){
            return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
        }

        $this->informationAllService->delete($id);

        return $this->successResponseStatus("Eliminado con éxito.");
    }
}
