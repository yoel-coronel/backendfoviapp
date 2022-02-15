<?php

namespace App\Listeners;

use App\Events\SendTokenSMS;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SendTokenTheVerificationSMS
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendTokenSMS  $event
     * @return void
     */
    public function handle(SendTokenSMS $event)
    {
        try {

            DB::delete("delete from password_resets where email = ?",[$event->user->email]);
            DB::table("password_resets")->insert(['email'=>$event->user->email,'token'=>bcrypt($event->token),'created_at'=>now()]);

            $url = config('app.url_simulation').'/api/sifo/enviarSms';
            $name = $event->user->getFullName();
            $toke = $event->token;
            $messege = "Estimado $name hemos recibido una solicitud de recuperación de clave de seguridad. Código de validación $toke";
            $body = array(
                "mensaje"=>$messege,
                "domain"=> config('app.url'),
                "celular"=>"943403849" //$event->user->telephone
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                    CURLOPT_URL =>$url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($body),
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: application/json",
                        "Accept: application/json"
                    ),
                )
            );

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($response){
                \Log::info($response);
            }else{
                \Log::error("Error en enviar el SMS API $url");
            }

        }catch (\Exception $exception){

            \Log::error($exception->getMessage());

        }



    }
}
