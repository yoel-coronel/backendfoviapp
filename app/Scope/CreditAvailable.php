<?php

namespace App\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CreditAvailable implements Scope
{

    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getTable(). '.'.'flag_esta_crd', '<>', 0)
            ->whereIn($model->getTable().'.'.'flag_cred_crd', [1,10,12,13]);
    }
}
