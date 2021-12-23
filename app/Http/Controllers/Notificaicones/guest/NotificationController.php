<?php

namespace App\Http\Controllers\Notificaicones\guest;

use App\Http\Controllers\Controller;
use App\Services\NotificationEntityService;
use App\Services\UploadService;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    protected $notificationEntityService;
    protected $uploadService;

    public function __construct(NotificationEntityService $notificationEntityService,UploadService $uploadService)
    {
        $this->notificationEntityService = $notificationEntityService;
        $this->uploadService = $uploadService;
    }

    public function guestStore(Request $request){

        $rules = [
            'title' =>'required|string|max:191',
            'description' =>'required|max:1000',
            'file' =>'nullable|max:15000',
            'url' =>'nullable|string',
            'identifier' =>'required|numeric',
            'token' =>'required'
        ];
        $validated = Validator::make($request->all(),$rules);

        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        if (!Hash::check($request->token, config('app.key_sifo'))){
            return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
        }

        $path = null;
        $data = $request->only('title','description','url','identifier');

        if ($request->hasFile('file')){
            $file = $request->file('file');
            $path = $this->uploadService->storeFileEntity(new File($file));
        }

        $data['path'] = $path;

        return $this->showAll(
            collect(
                $this->notificationEntityService->guestStore($data)
            )
        );

    }
    public function guestUpdate(Request $request, $id){

        $rules = [
            'title' =>'required|string|max:191',
            'description' =>'required|max:1000',
            'file' =>'nullable|max:15000',
            'url' =>'nullable|string',
            'identifier' =>'required|numeric',
            'token' =>'required'
        ];
        $validated = Validator::make($request->all(),$rules);

        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        if (!Hash::check($request->token, config('app.key_sifo'))){
            return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
        }

        $path = null;
        $data = $request->only('title','description','url','identifier');

        if ($request->hasFile('file')){
            $file = $request->file('file');
            $path = $this->uploadService->storeFileEntity(new File($file));
        }

        $data['path'] = $path;

        return $this->showAll(
            collect(
                $this->notificationEntityService->guestUpdate($data,$id)
            )
        );
    }

}
