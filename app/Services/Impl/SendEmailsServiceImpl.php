<?php

namespace App\Services\Impl;

use App\Mail\NotificaEmailMoroso;
use Illuminate\Support\Collection;
use App\Services\SendEmailsService;
use Illuminate\Support\Facades\Mail;

class SendEmailsServiceImpl implements SendEmailsService
{

    public function sendMasivoEmailsMorosos(Collection $collection): void
    {
        try {
            foreach ($collection['datos'] as $item){

                Mail::send(new NotificaEmailMoroso(collect($item)));

            }
        }catch (\Exception $exception){

        }

    }
}