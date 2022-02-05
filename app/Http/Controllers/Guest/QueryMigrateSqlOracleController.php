<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Services\QueryMigrateSqlOracleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class QueryMigrateSqlOracleController extends Controller
{

    /**
     * @var QueryMigrateSqlOracleService
     */
    private $queryMigrateSqlOracleService;

    public function __construct(QueryMigrateSqlOracleService $queryMigrateSqlOracleService)
    {
        $this->queryMigrateSqlOracleService = $queryMigrateSqlOracleService;
    }

    public function migrateInformation(Request $request){

        try {
            $rules = [
                'token' =>'required',
                'fecha' =>'required|date_format:"Y-m-d"',
                'asistencia' =>'required|numeric',
                'empleados' =>'required|array'
            ];
            $validated = Validator::make($request->all(),$rules);
            if ($validated->fails()){
                return $this->errorResponseFails(collect($validated->errors()->all()));
            }
            if (!Hash::check($request->token, config('app.key_sifo'))){
                return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
            }

            $this->queryMigrateSqlOracleService->migraInformationTheSQLOracle(collect(request('empleados')),request('asistencia'),request('fecha'));

            return $this->successResponseStatus("Procesado con éxito");

        }catch (\Exception $exception){

            return  $this->errorResponse($exception->getMessage(),1,400);

        }


    }


}
