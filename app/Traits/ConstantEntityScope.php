<?php

namespace App\Traits;

use App\Models\Oracle\MaeEntidaddet;

trait ConstantEntityScope
{

    /**
     *
     *
     * @param Builder $query
     */
    public function constantEntity($field)
    {
        $code = strtoupper(str_replace('_', '', $field)) ;

        return $this->belongsTo(MaeEntidaddet::class,  $field, 'secu_enti_det')
            ->where('codi_enti_ent', $code);
    }

}
