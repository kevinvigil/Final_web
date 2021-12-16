<?php
require_once "modelCLIENTE";
require_once "modelTARJETA";
require_once "modelACTIVIDAD";
require_once "view";
require_once "outhelper";

// Como usuario quiero poder realizar una transferencia 
// rápida a otro usuario indicando sólo su DNI.
// Se debe verificar que el cliente destinatario exista.
// Se debe verificar que el cliente originario tenga 
// fondos suficientes en su cuenta. 
// Se debe verificar que el cliente esté logueado.
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

    function transferencia($id_cliente){
        $this->outhelper->clienteLoged();
        if ($_POST["dni"] && $id_cliente && $_POST["kms"]) {
            if ($this->modelCLIENTE->getClienteByDNI($_POST["dni"])) {
                $kms = $_POST["kms"];
                $destinatario = $_POST["dni"];
                $ID_usuario = $id_cliente;
                $Saldo = $this->GetSaldo($ID_usuario, $kms);
                if ($Saldo) {
                    $this->modelACTIVIDAD->addKms($destinatario,$kms,getFecha(),1);
                    $this->modelACTIVIDAD->addKms($ID_usuario,-$kms,getFecha(),1);
                }else {
                    $this->view->mensaje("Saldo insuficiente");
                }
            }else {
                $this->view->mensaje("El destinatario no existe");
            }
        }else {
            $this->view->mensaje("Faltan datos");
        }
    }

    function GetSaldo($ID_usuario, $kms){
        $operaciones = $this->modelACTIVIDAD->actividadClienteId($ID_usuario);
        foreach ($operaciones as $op) {
            $saldo =+ $op->kms;
        }
        if ($saldo >= $kms) {
            return true;
        } else {
            return false;
        }
    }
}
