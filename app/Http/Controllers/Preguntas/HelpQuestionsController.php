<?php

namespace App\Http\Controllers\Preguntas;

use App\Http\Controllers\Controller;
use App\Http\Resources\HelpQuestionscollection;
use App\Http\Resources\HelpQuestionsResource;
use App\Services\HelpQuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HelpQuestionsController extends Controller
{
    protected $helpQuestionService;

    public function __construct(HelpQuestionService $helpQuestionService)
    {
        $this->helpQuestionService = $helpQuestionService;
    }
    public function index(){

        return $this->showAll(
            collect( HelpQuestionscollection::make($this->helpQuestionService->getQuestions()))
        );
    }
    public function store(Request $request){

        $rules = [
            'question' =>'required|unique:help_questions',
            'answer' =>'required|string|max:191',
            'order' =>'required|numeric',
        ];
        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }

        return $this->showAll(
            collect(
               HelpQuestionsResource::make($this->helpQuestionService->store($request->only('question','answer','order')))
            )
        );

    }

}
