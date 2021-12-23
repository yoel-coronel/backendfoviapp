<?php

namespace App\Services;

interface UserService
{
    public function store(array  $data);
    public function update(array  $data,$id);
    public function findSocio($cip,$codofi);
    public function findCip($cip);
    public function verificaToken($email,$token);
}
