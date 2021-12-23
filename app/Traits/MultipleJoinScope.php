<?php

namespace App\Traits;

trait MultipleJoinScope
{
    public function scopeMultipleJoin(
        $query, $table, $one, $operator = null, $two = null, $type = 'inner',
        $where = false
    ) {

        // verifica si existe en queryBuilder un join para la tabla $table
        if (!$this->exitJoin($query, $table)) {
            // sino existe lo agrega
            $query->join($table, $one, $operator, $two, $type, $where);

        }

        return $query;
    }

    protected function exitJoin($query, $table) {
        // devuelve todas los join que tiene el queryBuilder
        $joins = $query->getQuery()->joins;

        $result = false;

        $joinsCount = count(collect($joins));
        $i = 0;

        // verifica si ya existe un join para esa tabla
        while ( $joinsCount > $i && !$result ) {
            $result = $table == $joins[$i]->table;
            $i++;
        }

        return $result;
    }

}
