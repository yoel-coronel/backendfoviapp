<?php

namespace App\Services;

use Illuminate\Http\Request;

interface ExtInformationService
{
    public function storeAndUpdate(Request $request,array $user);
    public function getAllAuth(array $user);
    public function store(Request $request,array $user);
    public function update(Request $request,array $user,$id);
}
