<?php

namespace App\Providers;

use App\Repository\CrdCreditoCuotaRepository;
use App\Repository\CrdCreditoRepository;
use App\Repository\Digital\Impl\SolicitudRepositoryImpl;
use App\Repository\Digital\SolicitudRepository;
use App\Repository\ExtInformationRepository;
use App\Repository\FileEntityRepository;
use App\Repository\HelpQuestionRepository;
use App\Repository\Impl\CrdCreditoCuotaRepositoryImpl;
use App\Repository\Impl\CrdCreditoRepositoryImpl;
use App\Repository\Impl\ExtInformationRepositoryImpl;
use App\Repository\Impl\FileEntityRepositoryImpl;
use App\Repository\Impl\HelpQuestionRepositoryImpl;
use App\Repository\Impl\InformationAllRepositoryImpl;
use App\Repository\Impl\MaeAreaRepositoryImpl;
use App\Repository\Impl\MaeEmpresaRepositoryImpl;
use App\Repository\Impl\MaeEntidaddetRepositoryImpl;
use App\Repository\Impl\MaeProcesoRepositoryImpl;
use App\Repository\Impl\MaeUbigeoRepositoryImpl;
use App\Repository\Impl\MovimientosRepositoryImpl;
use App\Repository\Impl\NotificationEntityRepositoryImpl;
use App\Repository\Impl\QueryMigrateMarcacionRepositoryImpl;
use App\Repository\Impl\RecAporteRepositoryImpl;
use App\Repository\Impl\TrmTramiteRepositoryImpl;
use App\Repository\Impl\UploadDocumentRepositoryImpl;
use App\Repository\Impl\UserRepositoryImpl;
use App\Repository\Impl\VwAuraCreditoSocioRepositoryImpl;
use App\Repository\InformationAllRepository;
use App\Repository\MaeAreaRepository;
use App\Repository\MaeEmpresaRepository;
use App\Repository\MaeEntidaddetRepository;
use App\Repository\MaeProcesoRepository;
use App\Repository\MaeUbigeoRepository;
use App\Repository\MovimientosRepository;
use App\Repository\NotificationEntityRepository;
use App\Repository\QueryMigrateMarcacionRepository;
use App\Repository\RecAporteRepository;
use App\Repository\TrmTramiteRepository;
use App\Repository\UploadDocumentRepository;
use App\Repository\UserRepository;
use App\Repository\VwAuraCreditoSocioRepository;
use App\Services\AporteService;
use App\Services\CreditoService;
use App\Services\DigitalService;
use App\Services\ExtInformationService;
use App\Services\FileEntityService;
use App\Services\HelpQuestionService;
use App\Services\Impl\AporteServiceImpl;
use App\Services\Impl\CreditoServiceImpl;
use App\Services\Impl\DigitalServiceImpl;
use App\Services\Impl\ExtInformationServiceImpl;
use App\Services\Impl\FileEntityServiceImpl;
use App\Services\Impl\HelpQuestionServiceImpl;
use App\Services\Impl\InformationAllServiceImpl;
use App\Services\Impl\NotificationEntityServiceImpl;
use App\Services\Impl\queryMigrateSqlOracleServiceImpl;
use App\Services\Impl\RecursosServiceImpl;
use App\Services\Impl\SendEmailsServiceImpl;
use App\Services\Impl\SimulationServiceImpl;
use App\Services\Impl\TramiteServiceImpl;
use App\Services\Impl\UploadServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\InformationAllService;
use App\Services\NotificationEntityService;
use App\Services\QueryMigrateSqlOracleService;
use App\Services\RecursosService;
use App\Services\SendEmailsService;
use App\Services\SimulationService;
use App\Services\TramiteService;
use App\Services\UploadService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UploadRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $toBinds = [
            // all repository map
            UserRepository::class => UserRepositoryImpl::class,
            ExtInformationRepository::class => ExtInformationRepositoryImpl::class,
            MaeUbigeoRepository::class => MaeUbigeoRepositoryImpl::class,
            MaeEntidaddetRepository::class => MaeEntidaddetRepositoryImpl::class,
            TrmTramiteRepository::class => TrmTramiteRepositoryImpl::class,
            MaeProcesoRepository::class => MaeProcesoRepositoryImpl::class,
            RecAporteRepository::class => RecAporteRepositoryImpl::class,
            CrdCreditoRepository::class => CrdCreditoRepositoryImpl::class,
            CrdCreditoCuotaRepository::class => CrdCreditoCuotaRepositoryImpl::class,
            UploadDocumentRepository::class => UploadDocumentRepositoryImpl::class,
            FileEntityRepository::class => FileEntityRepositoryImpl::class,
            HelpQuestionRepository::class => HelpQuestionRepositoryImpl::class,
            NotificationEntityRepository::class => NotificationEntityRepositoryImpl::class,
            MaeEmpresaRepository::class => MaeEmpresaRepositoryImpl::class,
            VwAuraCreditoSocioRepository::class => VwAuraCreditoSocioRepositoryImpl::class,
            QueryMigrateMarcacionRepository::class => QueryMigrateMarcacionRepositoryImpl::class,
            MovimientosRepository::class => MovimientosRepositoryImpl::class,
            InformationAllRepository::class => InformationAllRepositoryImpl::class,
            MaeAreaRepository::class => MaeAreaRepositoryImpl::class,
            SolicitudRepository::class => SolicitudRepositoryImpl::class,

            //all services map
            UserService::class => UserServiceImpl::class,
            ExtInformationService::class => ExtInformationServiceImpl::class,
            RecursosService::class => RecursosServiceImpl::class,
            SimulationService::class => SimulationServiceImpl::class,
            TramiteService::class => TramiteServiceImpl::class,
            AporteService::class => AporteServiceImpl::class,
            CreditoService::class => CreditoServiceImpl::class,
            UploadService::class => UploadServiceImpl::class,
            FileEntityService::class => FileEntityServiceImpl::class,
            HelpQuestionService::class => HelpQuestionServiceImpl::class,
            NotificationEntityService::class => NotificationEntityServiceImpl::class,
            QueryMigrateSqlOracleService::class => QueryMigrateSqlOracleServiceImpl::class,
            InformationAllService::class => InformationAllServiceImpl::class,
            SendEmailsService::class => SendEmailsServiceImpl::class,
            DigitalService::class => DigitalServiceImpl::class,

        ];
        foreach ($toBinds as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


    }
}
