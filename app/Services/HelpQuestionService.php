<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface HelpQuestionService
{

    public function getQuestions():Collection;
    public function store(array $data);

}