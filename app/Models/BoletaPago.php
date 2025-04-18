<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class BoletaPago extends Model
{
    protected $table = 'boleta_pago';
    //
    /*
    CREATE TABLE BOLETA_PAGO (
    id_boleta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    total DECIMAL(10,2),
    estado VARCHAR(20),
    ruta_comprobante VARCHAR(255),
    fecha_emision DATE,
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato)
); */
    public static function generarBoleta($id_contrato, $ruta_comprobante)
    {
        $total = 600;
        $estado = 'pago pendiente';
        $fecha_emision = date('Y-m-d');
        return DB::insert('INSERT INTO boleta_pago (id_contrato, total, estado, ruta_comprobante, fecha_emision) VALUES (?, ?, ?, ?, ?)', [$id_contrato, $total, $estado, $ruta_comprobante, $fecha_emision]);
    }
}
