<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface SendEmailsService
{
        public function sendMasivoEmailsMorosos(Collection $collection):void;
}