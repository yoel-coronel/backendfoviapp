<?php

namespace App\Repository;

interface UserRepository extends BaseRepository
{
    public function findCip($cip);
    public function findEmail($email);
    public function findUserWithSocio($id);

}
