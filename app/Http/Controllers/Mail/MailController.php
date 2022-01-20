<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailController extends Controller
{

    public function getCredentialsEmails(){
        $mail = config("mail.mailers.smtp");
        return response()->json(['data'=>$mail]);
    }

}
