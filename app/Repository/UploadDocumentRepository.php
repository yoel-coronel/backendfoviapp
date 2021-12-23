<?php

namespace App\Repository;

interface UploadDocumentRepository extends BaseRepository
{
    public function getDocumentsAuth(array $user);
    public function findDocumentsAuth(array $user, $id);

}