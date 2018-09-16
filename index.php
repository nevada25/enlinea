<?php
require_once('lib/nusoap.php');
// Esta es su dirección URL WSDL del servidor de servicios web
$wsdl = "http://www.enlacesframework.info/wsfesunat/feosesunat.php?wsdl";

// Crear objeto del cliente
$client = new SoapClient($wsdl, 'wsdl');
$err = $client->getError();
if ($err) {
    //  Mostrar el error
    echo '<h2>Constructor error</h2>' . $err;
    // En este punto, sabes que la llamada que sigue fallará
    exit();
}
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
if (isset($_GET["opcion"])) {
    $opcion = $_GET["opcion"];
    header('Content-Type: application/json');
    if ($opcion == "List") {
        $data = array();
        $output = array();
        $ruc = $_POST["RUC"];
//        $ruc = 20542332990;
        $Datos = $client->call("FE_Ruc_Sunat", array("lcRUC" => $ruc));
        if ($Datos["return"] === "false") {
            $output["return"] = utf8_encode($Datos["return"]);
            $output["mensaje"] = utf8_encode($Datos["fe_ruc"]);
            $output["alert"] = utf8_encode("error");
        } else {
            $output["return"] = utf8_encode($Datos["return"]);
            $output["ruc"] = utf8_encode($Datos["fe_ruc"]);
            $output["nombre"] = utf8_encode($Datos["fe_nombre"]);
            $output["nrodocumento"] = utf8_encode($Datos["fe_numero_documento"]);
            $output["domicilio"] = utf8_encode($Datos["fe_domicilio_fiscal"]);
            $output["nombre_comercial"] = utf8_encode($Datos["fe_nombre_comercial"]);
            $output["estado_contribuyente"] = utf8_encode($Datos["fe_estado_contribuyente"]);
            $output["tipo_contribuyente"] = utf8_encode($Datos["fe_tipo_contribuyente"]);
            $output["distrito"] = utf8_encode($Datos["fe_distrito"]);
            $output["provincia"] = utf8_encode($Datos["fe_provincia"]);
            $output["departamento"] = utf8_encode($Datos["fe_departamento"]);
            $output["ubigeo"] = utf8_encode($Datos["fe_ubigeo"]);
            $output["codicion_contribuyente"] = utf8_encode($Datos["fe_condicion_contribuyente"]);

            if (count($Datos["fe_telefono"]) > "1") {
                $output["telefono"] = utf8_encode($Datos["fe_telefono"]);
            } else {
                $output["telefono"] = utf8_encode("-");
            }

            $output["fecha_inscripcion"] = utf8_encode($Datos["fe_fecha_inscripcion"]);
            $output["emision_electronica"] = utf8_encode($Datos["fe_emision_electronica"]);
            $output["sistema_contabilidad"] = utf8_encode($Datos["fe_sistema_contabilidad"]);
            $output["actividad_economica"] = utf8_encode($Datos["fe_actividad_economica"]);
        }
        $data[] = $output;
        $salida = array('data' => $data);
        echo json_encode($salida);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>CODIGO SUNAT</title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="css/mdb.min.css" rel="stylesheet">
        <!-- Your custom styles (optional) -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Start your project here-->
        <div style="height: 100vh">
            <div class="flex-center flex-column">
                <h1 class="animated fadeIn mb-4">BIENVENIDOS</h1>

                <h5 class="animated fadeIn mb-3">AL SERVICIO DE CONSULTA ONLINE</h5>

                <p class="animated fadeIn text-muted">EN LINEA</p>
            </div>
        </div>
        <!-- /Start your project here-->

        <!-- SCRIPTS -->
        <!-- JQuery -->
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="js/mdb.min.js"></script>
    </body>

</html>
