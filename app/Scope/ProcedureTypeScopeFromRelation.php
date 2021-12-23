<?php

namespace App\Scope;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProcedureTypeScopeFromRelation extends ProcedureTypeScope
{
    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, Model $model)
    {
        parent::apply($builder, $model);
        $builder->multipleJoin(
            $this->procedure->getTable(),
            $this->procedure->getTable() .'.'. $this->procedure->getKeyName(),
            '=',
            $model->getTable() . '.'.$this->procedure->getKeyName()
        )->select($model->getTable(). '.*');
    }
}
