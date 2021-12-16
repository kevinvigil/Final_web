<?php
// 4. API REST
// Tenga en cuenta los siguientes casos de uso:
// Como cliente quiero poder ver mis datos personales
$router->addRoute('CLIENTE/:ID', 'GET', 'controlerCLIENTE', 'datosPersonales');

// Como cliente quiero poder modificar mis datos personales
$router->addRoute('CLIENTE/:ID', 'PUT', 'controlerCLIENTE', 'updateDatosPersonales');

// C) Como cliente quiero poder ver un listado de mis tarjetas
$router->addRoute('TARJETA/:ID', 'GET', 'controlerTARJETA', 'tarjetas');

// Como cliente quiero poder ver el estado actual de mi cuenta
$router->addRoute('ACTIVIDAD/:ID', 'GET', 'controlerACTIVIDAD', 'estadoDeCuenta');

// E) Como cliente quiero poder ver mi historial de actividades dado un intervalo de dos fechas
$router->addRoute('ACTIVIDAD/:ID/:F1/:F2', 'GET', 'controlerACTIVIDAD', 'historialActividades');

// F) Como cliente quiero poder dar de baja una tarjeta
$router->addRoute('TARJETA/:ID', 'DELETE', 'controlerTARJETA', 'deleteTARJETA');
 


require_once "modelCLIENTE";
require_once "modelTARJETA";
require_once "modelACTIVIDAD";
require_once "view";
require_once "outhelper";

// Implemente el controlador de los puntos C, E y F
// 
class controlador  {
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

    function tarjetas ($params = null){
        $id_cliente = $params[":ID"];
        $tarjetas = $this->modelTARJETA->tarjetasAsociadas($id_cliente);
        if ($tarjetas) {
            return $this->view->response($tarjetas, 200);
        } else {
            return $this->view->response("Hubo un error", 404);
        }
    }

    function historialActividades($params = null){
        $id_cliente = $params[":ID"];
        $fecha1= $params[":F1"];
        $fecha2 = $params[":F2"];
        $actividad = $this->modelACTIVIDAD->actividadClienteIdYFecha($id_cliente, $fecha1, $fecha2);
        if ($actividad) {
            return $this->view->response($actividad, 200);
        } else {
            return $this->view->response("Hubo un error", 404);
        }
    }
    
    function deleteTARJETA($params = null){
        $id_tarjeta = $params[":ID"];
        $this->modelTARJETA->deleteTarjeta($id_tarjeta);
        $tarjeta = $this->modelTARJETA->taretasByID($id_tarjeta);
        if (!$tarjeta) {
            return $this->view->response("borrada", 200);
        } else {
            return $this->view->response("Hubo un error", 404);
        }
    }
}

