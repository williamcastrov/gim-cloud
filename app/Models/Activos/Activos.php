<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activos extends Model
{
    use HasFactory;

    protected $table = "activos";

    protected $primaryKey = "id_act";

    protected $fillable = [
        'numeroactivo_act',
        'cuentaactivo_act',
        'ctadepreciacion_act',
        'nombreactivo_act',
        'descripcion_act',
        'nitproveedor_act',
        'nombreproveedor_act',
        'fechaadquisicion_act',
        'fechacontable_act',
        'fechafinalcontable_act',
        'placaempresa_act',
        'factura_act',
        'annostranscurridos_act',
        'diastranscurridos_act',
        'costoadquisicion_act',
        'valorresidual_act',
        'depreciacionacumulada_act',
        'ajustepreciacion_act',
        'valorneto_act',
        'depreciacionmensual_act',
    ];

    public $timestamps = false;
}
