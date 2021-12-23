<?php

namespace App\Scope;

use App\Models\Oracle\TrmTramite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Scope;
class ProcedureTypeScope implements Scope
{
    const TYPE_ENABLE = 4;

    protected $procedure;

    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, Model $model)
    {
        $this->procedure = new TrmTramite();

        $builder->where(
            $this->procedure->getTable(). '.'.'tipo_tram_trm',
            self::TYPE_ENABLE
        );
    }
}
