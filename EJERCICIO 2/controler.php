<?php
require_once "modelCLIENTE";
require_once "modelTARJETA";
require_once "modelACTIVIDAD";
require_once "view";
require_once "outhelper";

class controler {
    private $modelCLIENTE;
    private $modelTARJETA;
    private $modelACTIVIDAD;
    private $view;
    private $outhelper;

    function __construct(){
        $this->modelCLIENTE = new modelCLIENTE();
        $this->modelTARJETA = new modelTARJETA();
        $this->modelACTIVIDAD = new modelACTIVIDAD();
        // $this->view = new view();
        // $this->outhelper = new outhelper();
    }

    function resumenCuenta(){
        $id_cliente = $_POST["id_cliente"];
        if ($id_cliente) {
            $operaciones = $this->modelACTIVIDAD->actividadClienteId($id_cliente);
            $taretasAsociadas = $this->modelTARJETA->tarjetasAsociadas($id_cliente);
            if ($operaciones && $taretasAsociadas) {
                $this->view->ShowDatos($operaciones, $taretasAsociadas);
            } elseif ($operaciones) {
                $this->view->ShowDatos($operaciones, "no tiene tarjetas");
            }elseif ($taretasAsociadas) {
                $this->view->ShowDatos($taretasAsociadas, "no tiene actividad registrada en la cuenta");
            }

        }
    }
}
// Generar una tabla resumen de cuenta de un cliente determinado
// Informar posibles errores
// Se debe mostrar una lista detallada de las operaciones 
// del cliente y el saldo actual de km
// Se debe informar la lista de tarjetas asociadas