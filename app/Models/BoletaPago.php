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
        $estado = 'pago_pendiente';
        $fecha_emision = date('Y-m-d');
        return DB::insert('INSERT INTO boleta_pago (id_contrato, total, estado, ruta_comprobante, fecha_emision) VALUES (?, ?, ?, ?, ?)', [$id_contrato, $total, $estado, $ruta_comprobante, $fecha_emision]);
    }

    public static function getBoletaById($id)
    {
        return DB::select('SELECT * FROM boleta_pago WHERE id_boleta = ?', [$id]);
    }
    public static function getBoletaByContrato($id_contrato)
    {
        return DB::select('SELECT * FROM boleta_pago WHERE id_contrato = ?', [$id_contrato]);
    }
    public static function getAllBoletas()
    {
        return DB::select('SELECT * FROM boleta_pago');
    }

    public static function pagoBoleta($id_boleta)
    {
        return DB::update('UPDATE boleta_pago SET estado = ? WHERE id_boleta = ?', ['pago_realizado', $id_boleta]);
    }

    public static function deleteBoleta($id)
    {
        return DB::delete('DELETE FROM boleta_pago WHERE id_boleta = ?', [$id]);
    }

    public static function marcarBoletaComoPagada($id_boleta)
    {
        return DB::update('UPDATE boleta_pago SET estado = ? WHERE id_boleta = ?', ['pagado', $id_boleta]);
    }

    public static function getIdContratoByBoleta($id_boleta)
    {
        return DB::select('SELECT id_contrato FROM boleta_pago WHERE id_boleta = ?', [$id_boleta]);
    }

    public static function getAllInfoContratoBoletas(){
        return DB::select('SELECT * FROM vista_contratos_boletas');
    }

    public static function procesarPagoBoleta($id_boleta){
        try{
            DB::statement('CALL procesarPagoBoleta(?)', [$id_boleta]);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

}
