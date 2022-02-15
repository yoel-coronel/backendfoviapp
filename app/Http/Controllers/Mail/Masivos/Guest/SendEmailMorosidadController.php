<?php

namespace App\Http\Controllers\Mail\Masivos\Guest;

use App\Http\Controllers\Controller;
use App\Services\SendEmailsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SendEmailMorosidadController extends Controller
{

    /**
     * @var SendEmailsService
     */
    private $sendEmailsService;

    public function __construct(SendEmailsService $sendEmailsService)
    {
        $this->sendEmailsService = $sendEmailsService;
    }

    public function sendEmailsMasivos(Request $request){

        try {
            $rules = [
                'datos' =>'required|array',
                'token' =>'required'
            ];
            $validated = Validator::make($request->all(),$rules);
            if ($validated->fails()){
                return $this->errorResponseFails(collect($validated->errors()->all()));
            }
            if (!Hash::check($request->token, config('app.key_sifo'))){
                return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
            }

            $this->sendEmailsService->sendMasivoEmailsMorosos(collect($request->all()));

            return $this->successResponseStatus("Emails enviado con éxito.");
        
        }catch (\Exception $exception){

            return  $this->errorResponse($exception->getMessage(),1,400);

        }
    }
}
