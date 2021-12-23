<?php

namespace App\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProcedureAuthUserFromRelation extends ProcedureAuthUser
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
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
