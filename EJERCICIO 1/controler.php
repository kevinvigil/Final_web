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

    function nuevoCliente(){
        $this->outhelper->adminLoged();
        if ($_POST["nombre"] && $_POST["dni"] && $_POST["telefono"] && $_POST["direccion"] && $_POST["ejecutivo"]) {
            $clienteConDNIX = $this->modelCLIENTE->getClienteByDNI($_POST["dni"]);
            if (!$clienteConDNIX) {
                $ultimoClienteId = $this->modelCLIENTE->addCliente($_POST["nombre"] , $_POST["dni"] , $_POST["telefono"] , $_POST["direccion"] , $_POST["ejecutivo"]);
                $ultimoCliente = $this->modelCLIENTE->getClienteById($ultimoClienteId);
                $this->modelACTIVIDAD->addKms($ultimoCliente->id, 200, getFecha(), 2);
                if ($ultimoCliente->ejecutivo == true) {
                    $datos = $this->CardHelper->getBussinesCard();
                    $this->modelTARJETA->addTarjeta($datos->fecha_alta, $datos->nro_tarjeta,$datos->fecha_vencimiento,$datos->tipo_tarjeta, $ultimoCliente->id);
                }
            }else {
                $this->view->mensaje("ya existe un cliente con ese documento");
            }
        }else {
            $this->view->mensaje("Faltan datos");
        }
        
    }
    
}

// Dar de alta un cliente nuevo al sistema. 
// Controlar posibles errores de carga de datos.
// Verificar que un usuario admin esté logueado.
// Verificar que no exista un cliente con el mismo dni.
// Cuando se agrega un cliente se le deben depositar 
// automáticamente 200 kms en su cuenta.
// Si el cliente es EJECUTIVO, 
// se le debe asociar automáticamente una tarjeta del tipo
// ejecutiva empresarial. (Suponga que los datos de la tarjeta 
// se obtienen de una función CardHelper->getBussinesCard())