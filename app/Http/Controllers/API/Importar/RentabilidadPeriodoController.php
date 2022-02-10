<?php

namespace App\Http\Controllers\API\Importar;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importar\RentabilidadPeriodo;

class RentabilidadPeriodoController extends Controller
{
    //
    public function create(Request $request){

        try {
            $insert['id_rtb']                    = $request['id_rtb'];
            $insert['periodo_rtb']               = $request['periodo_rtb'];
            $insert['equipo_rtb']                = $request['equipo_rtb'];
            $insert['equipoperiodo_rtb']         = $request['equipoperiodo_rtb'];
            $insert['nombrefacturacion']         = $request['nombrefacturacion'];
            $insert['tipofacturacion']           = $request['tipofacturacion'];
            $insert['valorfacturacion_rtb']      = $request['valorfacturacion_rtb'];
            $insert['nombreconsumointerno']      = $request['nombreconsumointerno'];
            $insert['tipoconsumointerno']        = $request['tipoconsumointerno'];
            $insert['valorconsumointerno_rtb']   = $request['valorconsumointerno_rtb'];
            $insert['nombrerepuestos']           = $request['nombrerepuestos'];
            $insert['tiporepuestos']             = $request['tiporepuestos'];
            $insert['valorrepuestos_rtb']        = $request['valorrepuestos_rtb'];
            $insert['mttocorrectivo']            = $request['mttocorrectivo'];
            $insert['tipomttocorrectivo']        = $request['tipomttocorrectivo'];
            $insert['valormttocorrectivo_rtb']   = $request['valormttocorrectivo_rtb'];
            $insert['nombremttopreventivo']      = $request['nombremttopreventivo'];
            $insert['tipomttopreventivo']        = $request['tipomttopreventivo'];
            $insert['valormttopreventivo_rtb']   = $request['valormttopreventivo_rtb'];
            $insert['nombreentregaequipo']       = $request['nombreentregaequipo'];
            $insert['tipoentregaequipo']         = $request['tipoentregaequipo'];
            $insert['valorentregaequipo_rtb']    = $request['valorentregaequipo_rtb'];
            $insert['nombredevolucionequipo']    = $request['nombredevolucionequipo'];
            $insert['tipodevolucionequipo']      = $request['tipodevolucionequipo'];
            $insert['valordevolucionequipo_rtb'] = $request['valordevolucionequipo_rtb'];
            $insert['nombrediagnostico']         = $request['nombrediagnostico'];
            $insert['tipodiagnostico']           = $request['tipodiagnostico'];
            $insert['valordiagnostico_rtb']      = $request['valordiagnostico_rtb'];
            $insert['nombredepreciacion']        = $request['nombredepreciacion'];
            $insert['tipodepreciacion']          = $request['tipodepreciacion'];
            $insert['valordepreciacion_rtb']     = $request['valordepreciacion_rtb'];

            RentabilidadPeriodo::insert($insert);
    
            $response['message'] = "Concepto Rentabilidad por Periodo Grabado de forma correcta";
            $response['success'] = true;
    
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
        }
           
          return $response;
    } 
  
      public function listar_rentabilidadperiodo(){
        try {
            //$data = Especialidades::with("empresa")->get();
            $data = DB::select("SELECT t0.*
            FROM conceptosrentabilidadperiodo as t0");
  
            $response['data'] = $data;
            $response['message'] = "load successful";
            $response['success'] = true;
    
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
        }
        return $response;
      }

      public function listar_rentabilidadperiodoequipo($periodo){
        try {
            $data = DB::select("SELECT t0.*
            FROM conceptosrentabilidadperiodo as t0
            WHERE equipoperiodo_rtb = $periodo");
  
            $response['data'] = $data;
            $response['message'] = "load successful";
            $response['success'] = true;
    
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
        }
        return $response;
      }

      public function consumorptorentabilidadperiodo($periodo){
        try {
          //$data['estado_otr'] = 26;
          $res = DB::update('update conceptosrentabilidadperiodo set valorconsumointerno_rtb =
                            (select sum(costototal_cre) from consumosrepuestos 
                             where consumosrepuestos.codigo_cre = conceptosrentabilidadperiodo.equipoperiodo_rtb 
                             GROUP BY anno_cre, mes_cre, periodo_cre) where periodo_rtb = ?' [$periodo]);
    
          $response['res'] = $res;
          $response['message'] = "Updated successful";
          $response['success'] = true;
        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }
        return $response;
      }
}
