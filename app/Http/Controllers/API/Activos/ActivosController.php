<?php

namespace App\Http\Controllers\API\Activos;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parameters\Empresa;
use App\Models\Parameters\Estados;
use App\Models\Mantenimiento\Marcas;
use App\Models\Interlocutores\Interlocutores;
use App\Models\Activos\Activos;

class ActivosController extends Controller
{
    //
    public function create(Request $request){
        try { 
          $insert['id_act']                    = $request['id_act'];
          $insert['numeroactivo_act']          = $request['numeroactivo_act'];
          $insert['cuentaactivo_act']          = $request['cuentaactivo_act'];
          $insert['ctadepreciacion_act']       = $request['ctadepreciacion_act'];
          $insert['nombreactivo_act']          = $request['nombreactivo_act'];
          $insert['descripcion_act']           = $request['descripcion_act'];
          $insert['nitproveedor_act']          = $request['nitproveedor_act'];
          $insert['nombreproveedor_act']       = $request['nombreproveedor_act'];
          $insert['fechaadquisicion_act']      = $request['fechaadquisicion_act'];
          $insert['fechacontable_act']         = $request['fechacontable_act'];
          $insert['fechafinalcontable_act']    = $request['fechafinalcontable_act'];
          $insert['placaempresa_act']          = $request['placaempresa_act'];
          $insert['factura_act']               = $request['factura_act'];
          $insert['annostranscurridos_act']    = $request['annostranscurridos_act'];
          $insert['diastranscurridos_act']     = $request['diastranscurridos_act'];
          $insert['costoadquisicion_act']      = $request['costoadquisicion_act'];
          $insert['valorresidual_act']         = $request['valorresidual_act'];
          $insert['depreciacionacumulada_act'] = $request['depreciacionacumulada_act'];
          $insert['ajustepreciacion_act']      = $request['ajustepreciacion_act'];
          $insert['valorneto_act']             = $request['valorneto_act'];
          $insert['depreciacionmensual_act']   = $request['depreciacionmensual_act'];
        
              
          Activos::insert($insert);
      
          $response['message'] = "Activo Grabado de forma correcta";
          $response['success'] = true;
      
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = true;
        }
        return $response;
    }
    
    public function listar_activos(){  
        try {
          
            $data = DB::select("SELECT t0.*, t1.nombre_emp, t2.razonsocial_int, t3.descripcion_mar,
                                             t4.nombre_est, t5.codigo_equ
            FROM activos as t0 INNER JOIN empresa as t1 INNER JOIN interlocutores as t2 INNER JOIN equipos as t5
                               INNER JOIN marcas  as t3 INNER JOIN estados        as t4
            WHERE t0.empresa_act = t1.id_emp and t0.descripcion_act    = t2.id_int  and t0.codigo_act = t5.id_equ and
                  t0.marca_act   = t3.id_mar and t0.estadocontable_act = t4.id_est");
  
          $response['data'] = $data;
          // $response['data'] = $data1;
          $response['message'] = "load successful";
          $response['success'] = true;
      
        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }
          return $response;
    }
    
    public function get($id_act){
        try { 
            $data = DB::select("SELECT t0.*, t1.nombre_emp, t2.razonsocial_int, t3.descripcion_mar,
                                             t4.nombre_est
            FROM activos as t0 INNER JOIN empresa as t1 INNER JOIN interlocutores as t2
                               INNER JOIN marcas  as t3 INNER JOIN estados        as t4
            WHERE t0.empresa_act = t1.id_emp and t0.propietario_act    = t2.id_int and
                  t0.marca_act   = t3.id_mar and t0.estadocontable_act = t4.id_est and t0.id_act = $id_act");
         
            if ($data) {
                $response['data'] = $data;
                $response['message'] = "Load successful";
                $response['success'] = true;
            }
            else {
                $response['data'] = null;
                $response['message'] = "Not found data id_act => $id_act";
                $response['success'] = false;
            }
            } catch (\Exception $e) {
              $response['message'] = $e->getMessage();
              $response['success'] = false;
        }
        return $response;
    }

    public function leeactivo($id_equ){
      try { 
          $data = DB::select("SELECT t0.*, t1.nombre_emp, t2.razonsocial_int, t3.descripcion_mar,
                                           t4.nombre_est
          FROM activos as t0 INNER JOIN empresa as t1 INNER JOIN interlocutores as t2
                             INNER JOIN marcas  as t3 INNER JOIN estados        as t4
          WHERE t0.empresa_act = t1.id_emp and t0.propietario_act    = t2.id_int and
                t0.marca_act   = t3.id_mar and t0.estadocontable_act = t4.id_est and t0.codigo_act = $id_equ");
       
          if ($data) {
              $response['data'] = $data;
              $response['message'] = "Load successful";
              $response['success'] = true;
          }
          else {
              $response['data'] = null;
              $response['message'] = "Not found data codigo_equ => $codigo_equ";
              $response['success'] = false;
          }
          } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
      }
      return $response;
    }

    public function validadepreciacionacumulada($fecha){
      try { 
          $data = DB::select("SELECT t0.*
          FROM activos as t0 
          WHERE t0.fechaultimadepre_act >= DATE_FORMAT($fecha, '%Y-%m-01')
            AND t0.fechaultimadepre_act <= LAST_DAY($fecha);");
       
          if ($data) {
              $response['data'] = $data;
              $response['message'] = "Load successful";
              $response['success'] = true;
          }
          else {
              $response['data'] = null;
              $response['message'] = "Not found data fechaultimadepre_act => $fecha";
              $response['success'] = false;
          }
          } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
      }
      return $response;
    }

    public function actualizadepreactivos($annomes_dpr){
      /*
        $res = DB::update('update activos set depreciacionacumulada_act = (depreciacionacumulada_act + depreciacionmensual_act),
                                                                          fechaultimadepre_act = NOW()
                          where (depreciacionacumulada_act + valorresidual_act) < valoradquisicion_act');

        $res = DB::update('update activos set valorneto_act = valoradquisicion_act - depreciacionacumulada_act                                
                           where (depreciacionacumulada_act + valorresidual_act) < valoradquisicion_act');
      */
      try {
        $res = DB::update('update activos set depreciacionacumulada_act = (depreciacionacumulada_act + depreciacionmensual_act),
                                                                          fechaultimadepre_act = NOW()
                                        where (depreciacionacumulada_act + valorresidual_act) < valoradquisicion_act');

        $res = DB::update('update activos set valorneto_act = valoradquisicion_act - depreciacionacumulada_act');

        $response['res'] = $res;
        $response['message'] = "Updated successful";
        $response['success'] = true;
      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }
      return $response;
    } 

    public function leeactivodepreciar($periodo){
      try { 
         /*
         $data = DB::select("SELECT t0.id_act as activo_dpr, year(now()) as anno_dpr, month(now()) as mes_dpr, 
                                     t0.descripcion_act as descripcion_dpr, 1 as empresa_dpr, 
                                     depreciacionmensual_act as valordepreciacion_dpr,
                                     'Calculo Depreciación' as observacion_dpr,
                                     CONCAT(year(now()),month(now())) as annomes_dpr
          */
          $data = DB::select("SELECT t0.id_act as activo_dpr, CAST(LEFT($periodo,4) AS SIGNED) as anno_dpr,
                                                              CAST(RIGHT($periodo,2) AS SIGNED) as mes_dpr, 
          t0.descripcion_act as descripcion_dpr, 1 as empresa_dpr, 
          depreciacionmensual_act as valordepreciacion_dpr,
          'Calculo Depreciación' as observacion_dpr,
          $periodo as annomes_dpr
          FROM  activos as t0 
          WHERE (t0.depreciacionacumulada_act + t0.valorresidual_act) < t0.valoradquisicion_act;");
       
          $response['data'] = $data;
          // $response['data'] = $data1;
          $response['message'] = "load successful";
          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }
        return $response;
    }
    
    public function update(Request $request, $id_act){
        try {
          $data['numeroactivo_act']          = $request['numeroactivo_act'];
          $data['cuentaactivo_act']          = $request['cuentaactivo_act'];
          $data['ctadepreciacion_act']       = $request['ctadepreciacion_act'];
          $data['nombreactivo_act']          = $request['nombreactivo_act'];
          $data['descripcion_act']           = $request['descripcion_act'];
          $data['nitproveedor_act']          = $request['nitproveedor_act'];
          $data['nombreproveedor_act']       = $request['nombreproveedor_act'];
          $data['fechaadquisicion_act']      = $request['fechaadquisicion_act'];
          $data['fechacontable_act']         = $request['fechacontable_act'];
          $data['fechafinalcontable_act']    = $request['fechafinalcontable_act'];
          $data['placaempresa_act']          = $request['placaempresa_act'];
          $data['factura_act']               = $request['factura_act'];
          $data['annostranscurridos_act']    = $request['annostranscurridos_act'];
          $data['diastranscurridos_act']     = $request['diastranscurridos_act'];
          $data['costoadquisicion_act']      = $request['costoadquisicion_act'];
          $data['valorresidual_act']         = $request['valorresidual_act'];
          $data['depreciacionacumulada_act'] = $request['depreciacionacumulada_act'];
          $data['ajustepreciacion_act']      = $request['ajustepreciacion_act'];
          $data['valorneto_act']             = $request['valorneto_act'];
          $data['depreciacionmensual_act']   = $request['depreciacionmensual_act'];
    
          $res = Activos::where("id_act",$id_act)->update($data);
    
          $response['res'] = $res;
          $response['message'] = "Updated successful";
          $response['success'] = true;
        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }
        return $response;
    }
    
    public function delete($id_act){ 
        try {
          $res = Activos::where("id_act",$id_act)->delete($id_act);
          $response['res'] = $res;
    
          $response['message'] = "Deleted successful";
          $response['success'] = true; 
        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }
          return $response;
    }
}
