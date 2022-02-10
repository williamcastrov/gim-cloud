<?php

namespace App\Models\Importar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumosRepuestos extends Model
{
    use HasFactory;

    protected $table = "consumosrepuestos";

    protected $primaryKey = "id_cre";

    protected $fillable = [
        'id_cre',
        'anno_cre',
        'mes_cre',
        'tr_cre', 
        'documento_cre',
        'concepto_cre',
        'fecha_cre',
        'idequipo_cre',
        'codigo_cre',
        'documentodest_cre',
        'bodega_cre',
        'referencia_cre', 
        'descripcion_cre',
        'centrocosto_cre',
        'cantidad_cre', 
        'costounitario_cre', 
        'costototal_cre', 
        'valorbruto_cre',
    ];

    public $timestamps = false;
}
