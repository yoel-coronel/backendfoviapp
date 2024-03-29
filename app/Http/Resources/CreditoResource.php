<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->iden_cred_crd,
            'coin' => $this->resource->coin->valo_cadu_det,// $output['codi_mone_crd'], //
            'processed_by_person' =>$this->resource->trmTramite->nomb_tram_trm,
            'amount_requested' => round($this->resource->impo_soli_crd,2),//round($output['impo_soli_crd'],2),
            'amount_response' => round($this->resource->impo_gira_crd,2),//round($output['impo_gira_crd'],2),
            'number_of_installments' => $this->resource->nume_cuot_prd,//force_cast($output['nume_cuot_prd']),
            'credit_status' => optional($this->resource->creditStatus)->valo_cadu_det,//$output['flag_cred_crd'], //
            'product' => $this->resource->product->nomb_prod_prd,// $output['iden_prod_prd'], //
            'initial_payment' =>   round($this->resource->impo_inic_crd,2),//$output['impo_inic_crd'],
            'expired_debt' =>  round($this->resource->sald_venc_crd,2),//round($output['sald_venc_crd'],2),
            'expired_deadlines' =>  $this->resource->nucu_venc_crd,//force_cast($output['nucu_venc_crd']),
            'last_payment_date' =>  $this->resource->fech_ulti_pag,//force_cast($output['fech_ulti_pag']),
            'cancellation_amount' =>  round($this->resource->sald_soli_crd,2) + round($this->resource->sald_venc_crd,2),// round($output['sald_soli_crd'] + $output['sald_venc_crd'],2), //
            'reason_for_credit' => optional($this->resource->reasonForCredit)->valo_cadu_det,//$output['codi_apli_crd'], //
            'date_of_entry' =>Carbon::parse($this->resource->fech_crea_aud)->format('d/m/Y'),
        ];
    }
}
/*

{
    "iden_cred_crd": 50398,
    "codi_cred_crd": null,
    "iden_expe_trm": "98607",
    "codi_fina_crd": "1",
    "perc_soci_crd": "2668",
    "impo_soli_crd": "167522.69",
    "nume_cuot_prd": "360",
    "tasa_inte_crd": "3.8",
    "impo_inte_crd": "107804.29",
    "tasa_gadm_crd": "1",
    "impo_gadm_crd": "1675.23",
    "fech_apro_crd": "2018-11-22 11:36:18",
    "iden_inmu_imb": "6338",
    "impo_gira_crd": "165847.46",
    "codi_mone_crd": "1",
    "auto_cdob_crd": "N",
    "peri_grac_crd": null,
    "fech_crea_aud": "2018-07-10 12:01:22",
    "usua_crea_aud": "ccondori",
    "fech_modi_aud": "2020-11-14 11:16:03",
    "usua_modi_aud": "gvargas",
    "nomb_equi_aud": "192.168.10.4",
    "nomb_sope_aud": null,
    "flag_esta_crd": "1",
    "valo_camb_tcm": null,
    "flag_cred_crd": "1",
    "codi_empr_emp": null,
    "codi_sede_ope": null,
    "fech_flag_crd": "2018-11-22 11:36:18",
    "prio_ordn_crd": null,
    "iden_prod_prd": "1",
    "codi_apli_crd": "1",
    "sald_inte_crd": "499.58",
    "sald_soli_crd": "160158.51",
    "sald_segu_crd": "56.81",
    "impo_auto_seg": null,
    "sald_venc_crd": "888.91",
    "nucu_venc_crd": "1",
    "codi_gest_siga": null,
    "codi_oper_siga": null,
    "impo_inic_crd": "0",
    "codi_siga_per": null,
    "fech_canc_crd": null,
    "fech_ulti_pag": null,
    "fech_baja_crd": null,
    "fech_bloq_crd": null,
    "flag_bloq_crd": null,
    "secu_siga_crd": null,
    "codi_oper_crd": null,
    "flag_reso_crd": "0",
    "anio_apro_crd": null,
    "nmes_apro_crd": null,
    "nucu_pend_crd": "338",
    "in_dar": "0",
    "secu_cred_crd": "1",
    "trm_tramite": {
        "iden_expe_trm": 98607,
        "nume_guia_trm": null,
        "tipo_tram_trm": "4",
        "codi_orig_trm": null,
        "codi_moda_trm": "1",
        "codi_expe_trm": "98607",
        "codi_barr_trm": null,
        "iden_simu_sim": "133216",
        "iden_proc_prc": "1",
        "codi_pers_trm": "132285",
        "nomb_tram_trm": "ARY FLORES LUIS ALBERTO",
        "nume_folio_trm": null,
        "desc_asun_trm": "EXPEDIENTE DE LA MODALIDAD DE CONSTRUCCIÓN O MEJORAMIENTO DE VIVIENDA PROPIA",
        "docu_refe_trm": null,
        "fech_ingr_trm": "2018-07-10 12:01:22",
        "nume_dias_trm": "32",
        "fech_venc_trm": "2018-08-23 12:01:22",
        "codi_prio_trm": "1",
        "flag_priv_trm": null,
        "usua_crea_aud": "ccondori",
        "fech_crea_aud": "2018-07-10 12:01:22",
        "usua_modi_aud": "vvasquez",
        "fech_modi_aud": "2020-11-14 11:15:06",
        "nomb_equi_aud": "192.168.10.4",
        "nomb_sope_aud": null,
        "flag_esta_trm": "2",
        "flag_dema_trm": null,
        "subt_tipo_trm": null,
        "mont_soli_trm": null,
        "mont_sent_trm": null,
        "iden_empr_emp": "177",
        "codi_expp_trm": null,
        "codi_mone_crd": null,
        "seri_docu_trm": null,
        "nume_docu_trm": null,
        "iden_tram_trm": "30848548",
        "iden_pera_trm": "132285",
        "iden_proc_trm": "1",
        "fech_ingr_not": "2018-11-12 13:08:52",
        "fech_sali_not": null,
        "flag_regu_trm": null,
        "moti_regu_trm": null,
        "iden_cod_barras_det": null,
        "tipo_carp_prd": "2",
        "pre_calf_tmr": null,
        "digi_mepa_tmr": null,
        "expe_nume_trm": null,
        "usua_asig_trm": null
    },
    "credit_status": {
        "iden_enti_det": 140,
        "codi_enti_ent": "FLAGCREDCRD",
        "secu_enti_det": "1",
        "valo_cadu_det": "Pendiente de cancelar",
        "valo_cadd_det": null,
        "valo_cadt_det": null,
        "valo_numu_det": "1",
        "valo_numd_det": "1",
        "valo_numt_det": "1",
        "valo_decu_det": null,
        "valo_decd_det": null,
        "valo_dect_det": "1",
        "valo_fecu_det": null,
        "valo_fecd_det": null,
        "valo_fect_det": null,
        "usua_crea_det": null,
        "fech_crea_det": "2014-12-10 18:49:01",
        "usua_modi_det": null,
        "fech_modi_det": "2020-08-23 17:16:51",
        "flag_esta_det": "1",
        "valo_nota_det": null
    },
    "coin": {
        "iden_enti_det": 78,
        "codi_enti_ent": "CODIMONECRD",
        "secu_enti_det": "1",
        "valo_cadu_det": "Nuevos Soles",
        "valo_cadd_det": "PEN",
        "valo_cadt_det": "S/.",
        "valo_numu_det": "853",
        "valo_numd_det": null,
        "valo_numt_det": null,
        "valo_decu_det": "0",
        "valo_decd_det": "0",
        "valo_dect_det": null,
        "valo_fecu_det": null,
        "valo_fecd_det": null,
        "valo_fect_det": null,
        "usua_crea_det": null,
        "fech_crea_det": "2014-10-28 15:02:08",
        "usua_modi_det": null,
        "fech_modi_det": "2017-10-20 16:22:00",
        "flag_esta_det": "1",
        "valo_nota_det": null
    },
    "product": {
        "iden_prod_prd": 1,
        "iden_proc_prc": "1",
        "codi_line_prd": "2",
        "nomb_prod_prd": "CONSTRUCCIÓN O MEJORAMIENTO DE VIVIENDA PROPIA",
        "codi_mone_crd": "1",
        "cant_vece_prd": "15",
        "maxi_peri_prd": "360",
        "fech_ivig_prd": "2014-10-06 00:00:00",
        "fech_fvig_prd": "2014-10-22 00:00:00",
        "tasa_inte_prd": "3.8",
        "tasa_gadm_prd": "1",
        "mont_deud_prd": "12900",
        "mont_cobd_prd": "0",
        "auto_cdob_prd": "1",
        "desc_requ_prd": "Otorgamiento de cr?dito para: |CONSTRUCCI?N O MEJORAMIENTO DE VIVIENDA PROPIA - (CARPETA COLOR AZUL)  ||1.\tSolicitud de Pr?stamo seg?n formato del FOVIPOL. |2.\tCopia de DNI legalizada ante notario p?blico. El DNI debe de consignar el estado civil del titular y su domicilio actualizado al momento de realizar el tr?mite. |3.\tEn el caso de estar casado o haberse divorciado deber? presentar el Acta de Matrimonio Civil original. |4.\tEn caso de estado civil soltero(a), divorciado(a) y viudo(a) deber? presentar declaraci?n jurada de su estado civil con firma legalizada (observar formato). |5.\tEn el caso de ser pensionista deber? presentar las Tres (03) ?ltimas boletas de pago originales o planillas virtuales impresas. |6.\tAutorizaci?n de descuento de Remuneraci?n (DIREJEPER-PNP) suscrita por el solicitante con impresi?n digital del ?ndice derecho, en duplicado (seg?n formato). |7.\tAutorizaci?n de descuento de Pensi?n (Caja Militar ? Policial o DIRECFIN-PNP), suscrita por el solicitante con impresi?n digital del ?ndice derecho, en duplicado (seg?n formato). |8.\tOriginal o copia legalizada del plano de ubicaci?n, suscrita por Ingeniero Civil o Arquitecto colegiado y habilitado por el Colegio Profesional respectivo. |9.\tOriginal o copia legalizada del plano de distribuci?n del inmueble, suscrita por Ingeniero Civil o Arquitecto colegiado y habilitado por el Colegio Profesional respectivo. |10.\tOriginal o copia legalizada del Presupuesto que acredite la obra a realizar. |11.\tTasaci?n del inmueble por Perito Tasador en la especialidad de Ingeniero Civil o Arquitecto, inscrito en la Superintendencia de Banca y Seguros (SBS) o Registro de Peritos Judiciales (REPEJ) en  ejercicio. |12.\tCertificado Registral Inmobiliario (CRI) que acredite la propiedad del bien inmueble a nombre del solicitante (no se aceptan Acciones y Derechos), con sus respectivas copias literales otorgadas por la SUNARP en originales, correspondiente al inmueble a ser hipotecado, el cual no podr? tener la condici?n de bien r?stico y/o agr?cola. |13.\tCertificado de Par?metros expedido por la Municipalidad de la jurisdicci?n, cuando se pretenda intervenir en inmuebles con una altura mayor a Tres (03) pisos. |14.\tNo estar registrado en Centrales de Riesgo como sujeto de riesgo crediticio. (Verificaci?n a cargo de la Secci?n de Cr?ditos-FOVIPOL). |15.\tPresentar una Declaraci?n Jurada suscrita por el solicitante y su c?nyuge (de ser casado), con firma legalizada ante Notario P?blico, en el que se comprometa a:a.\tEmplear el monto total del pr?stamo otorgado por el FOVIPOL, para los fines solicitados.b.\tNo presentar documentaci?n o informaci?n falsa y/o adulterada.c.\tNo asumir deudas que pongan en riesgo su compromiso crediticio adquirido con FOVIPOL.16.\tAutorizar a FOVIPOL para que comunique a las Centrales de Riesgo el pr?stamo otorgado. |17.\tSuscripci?n y firma del Certificado de Afiliaci?n del seguro de desgravamen de Cr?dito. |18.\tLos gastos Notariales y Reg?strales que demande el otorgamiento del pr?stamo ser?n asumidos por el beneficiario. |",
        "form_calc_prd": "min((a-b+e*g)*f,(a-b+e*g)*h-c)+d*i",
        "usua_crea_aud": "ADMIN",
        "fech_crea_aud": "2014-10-27 15:38:35",
        "usua_modi_aud": "LBELLIDO",
        "fech_modi_aud": "2020-09-12 09:52:23",
        "nomb_equi_aud": "192.168.10.4",
        "nomb_sope_aud": "producto_generico.jpg",
        "flag_esta_prd": "0",
        "dias_vali_prd": "30",
        "tasa_prem_prd": "2.65",
        "tasa_cast_prd": "3.35",
        "anio_apor_prd": "1",
        "ncuo_emba_prd": null,
        "anio_soci_prd": "0",
        "iden_ubig_prd": null,
        "iden_ubig_dep": null,
        "iden_ubig_pro": null,
        "leye_prod_prd": "Nota Importante:\r\n- La escala máxima de préstamos  está sujeta a la evaluación crediticia del aportante, en función de las siguientes variables: \r\n  Descuentos por planilla, estar al día en los aportes, riesgo crediticio, deudas financieras, edad y evaluación del seguro de desgravamen.\r\n- La simulación de Capacidad de Endeudamiento es referencial, basada en el valor de la tasación en algunas modalidades de préstamo, a la\r\n  fecha en que se realiza el cálculo, sin considerar otros descuentos.\r\n- El monto del aporte del administrado no está incluido en la cuota mensual a pagar.\r\n- La simulación tiene una validez de 30 días calendario o cambie su situación creticia.\r\n- Pasar a la Unidad de Seguros para su suscripción y evaluación.\r\n- Contar con el seguro de Desgravamen aprobado por la empresa aseguradora.",
        "in_dar": "0",
        "tipo_carp_prd": "2",
        "codi_prod_pad": null
    },
    "reason_for_credit": {
        "iden_enti_det": 634,
        "codi_enti_ent": "CODIAPLICRD",
        "secu_enti_det": "1",
        "valo_cadu_det": "Vivienda",
        "valo_cadd_det": null,
        "valo_cadt_det": null,
        "valo_numu_det": null,
        "valo_numd_det": null,
        "valo_numt_det": null,
        "valo_decu_det": null,
        "valo_decd_det": null,
        "valo_dect_det": null,
        "valo_fecu_det": null,
        "valo_fecd_det": null,
        "valo_fect_det": null,
        "usua_crea_det": null,
        "fech_crea_det": "2015-04-22 15:45:00",
        "usua_modi_det": null,
        "fech_modi_det": "2015-12-02 11:26:37",
        "flag_esta_det": "1",
        "valo_nota_det": null
    }
}

 */
