<?php

namespace App\Services\Impl;

use App\Repository\HelpQuestionRepository;
use App\Services\HelpQuestionService;
use Illuminate\Support\Collection;

class HelpQuestionServiceImpl implements HelpQuestionService
{

    protected $helpQuestionRepository;

    public function __construct(HelpQuestionRepository $helpQuestionRepository)
    {
        $this->helpQuestionRepository = $helpQuestionRepository;
    }

    public function getQuestions():Collection
    {
        return collect($this->helpQuestionRepository->all());
    }

    public function store(array $data)
    {
       return $this->helpQuestionRepository->create($data);
    }
}