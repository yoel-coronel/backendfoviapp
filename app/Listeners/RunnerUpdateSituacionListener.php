<?php

namespace App\Listeners;

use App\Events\RunnerUpdateSituacion;
use App\Services\QueryMigrateSqlOracleService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RunnerUpdateSituacionListener implements ShouldQueue
{
    protected $queryMigrateSqlOracleService;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(QueryMigrateSqlOracleService $queryMigrateSqlOracleService)
    {
        $this->queryMigrateSqlOracleService =$queryMigrateSqlOracleService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RunnerUpdateSituacion  $event
     * @return void
     */
    public function handle(RunnerUpdateSituacion $event)
    {
        $this->queryMigrateSqlOracleService->executeRunBatch($event->iden_plan_pla);
    }
}
