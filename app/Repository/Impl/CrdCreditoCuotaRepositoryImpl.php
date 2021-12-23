<?php

namespace App\Repository\Impl;
use App\Models\Oracle\CrdCreditoCuota;
use App\Repository\CrdCreditoCuotaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CrdCreditoCuotaRepositoryImpl implements CrdCreditoCuotaRepository
{
    protected $model;

    public function __construct(CrdCreditoCuota $crdCreditoCuota)
    {
        $this->model = $crdCreditoCuota;
    }

    public function showByCredit($credito_id)
    {
        $data =  collect($this->model->setDebts($credito_id)->with('situation')
            ->ofByCredit($credito_id)->get()->toArray());

        $format_datos = $data->map(function ($item){

            $sec = intval($item['secu_cuot_cuo']);
            $amount_paid = CrdCreditoCuota::$debts && isset(CrdCreditoCuota::$debts[$sec]) ?
                CrdCreditoCuota::$debts[$sec] : 0;
            return [
                'id' => $item['secu_cuot_cuo'],
                'quota_number' => $item['nume_cuot_cuo'],
                'quota' => round($item['impo_cuot_cuo'],2),
                'beginning_balance' => round($item['sald_inic_cuo'],2),
                'capital' => round($item['capi_mont_cuo'],2),
                'interest' => round($item['inte_mont_cuo'],2),
                'insurance' => round($item['impo_segu_cuo'],2),
                'due_date' => $item['fech_pago_cuo'],
                'situation' => $item['situation']['valo_cadu_det'],
                'amount_paid' => round(($item['impo_cuot_cuo'] - $amount_paid),2),
                'balance' => round($amount_paid,2),
            ];

        });

        return  [
            'data' => $format_datos->toArray(),
            'total_capital' => round($format_datos->sum('capital'),2),
            'total_interest' => round($format_datos->sum('interest'),2),
            'total_insurance' => round($format_datos->sum('insurance'),2),
            'total_amount_paid' => round($format_datos->sum('amount_paid'),2),
            'total_balance' => round($format_datos->sum('balance'),2),
        ];

    }

    public function showByPagoDetail($creditId, $pagoId)
    {
        $detalles = collect(DB::connection('oracle')->select('SELECT CCC.CODI_CONC_CRD, PD.* FROM SIFO.CRD_CREDITO  C
                                INNER JOIN SIFO.CRD_CREDITO_CUOTA  CC ON C.IDEN_CRED_CRD=CC.IDEN_CRED_CRD
                                INNER JOIN SIFO.CRD_CUOTA_CONCEPTO  CCC ON CCC.IDEN_CRED_CRD=C.IDEN_CRED_CRD AND CCC.SECU_CUOT_CUO=CC.SECU_CUOT_CUO
                                INNER JOIN SIFO.CRD_PAGO_DETALLE  PD ON PD.IDEN_PAGO_RPC=CCC.IDEN_PAGO_RPC
                                WHERE CC.FLAG_ESTA_CUO<>0  AND PD.FLAG_ESTA_CCS<>0 AND C.IDEN_CRED_CRD=? AND CC.SECU_CUOT_CUO=?',[$creditId,$pagoId]));
        return  $this->outputCollect($detalles);
    }
    protected function output($output)
    {
        $concepto = get_object_vars(collect(DB::connection('oracle')->select('SELECT ME.SECU_ENTI_DET,ME.VALO_CADU_DET FROM SIFO.MAE_ENTIDADDET ME
                                                                              WHERE ME.CODI_ENTI_ENT = ? AND ME.SECU_ENTI_DET=? AND ROWNUM=?',["CODICONCCRD",$output['condicion'],1]))[0]);
        $document = get_object_vars(collect(DB::connection('oracle')->select('SELECT RP.NUME_OPER_RPT,RP.TIPO_DOCU_PAG,RP.ENTI_PAGO_SOC FROM SIFO.REC_PAGO_CUOTA RP WHERE RP.IDEN_PAGO_RPG =? AND RP.TIPO_ACCI_PAG = ? AND ROWNUM=?',[$output['iden_pago_rpg'],1,1]))[0]);

        $tipo_pago = get_object_vars(collect(DB::connection('oracle')->select('SELECT D.SECU_ENTI_DET, D.VALO_CADU_DET FROM SIFO.MAE_ENTIDADDET D WHERE D.CODI_ENTI_ENT=? AND D.SECU_ENTI_DET=? AND ROWNUM=?',["TIPODOCUPAG",$document['tipo_docu_pag'],1]))[0]);

        $origen = get_object_vars(collect(DB::connection('oracle')->select('SELECT D.SECU_ENTI_DET,D.VALO_CADU_DET FROM SIFO.MAE_ENTIDADDET D WHERE D.CODI_ENTI_ENT=? AND D.SECU_ENTI_DET=? AND ROWNUM=?',["ENTIPAGOMAE",$document['enti_pago_soc'],1]))[0]);

        return [
            'fecha' => Carbon::parse($output['fecha'])->format('d/m/Y'),
            'monto' => $output['monto'],
            'condicion' =>$concepto['valo_cadu_det'],
            'documento' =>$document['nume_oper_rpt'],
            'tipo_docu' =>$tipo_pago['valo_cadu_det'],
            'origen'    =>$origen['valo_cadu_det'],
        ];
    }
    protected function outputCollect($array_value)
    {
        $collect1 = array();
        foreach ($array_value as $key => $value) {

            $value = get_object_vars($value);
            $obj  = array('fecha'=>$value["fech_pago_css"],'monto'=>$value["impo_saldo_css"],'condicion'=>$value["codi_conc_crd"],'iden_pago_rpg'=>$value['iden_pago_rpg']);
            array_push($collect1,$this->output($obj));
            $obj = array();
        }
        return collect($collect1);
    }
}
