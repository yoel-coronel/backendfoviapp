<?php

namespace App\Scope;

use App\Models\Oracle\TrmTramite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ProcedureAuthUser implements Scope
{
    protected $procedure;

    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, Model $model)
    {
        $this->procedure = new TrmTramite();
        $builder->where(
            $this->procedure->getTable(). '.'.'IDEN_PERA_TRM',
            optional(Auth::user())->identifier
        );
    }
}
