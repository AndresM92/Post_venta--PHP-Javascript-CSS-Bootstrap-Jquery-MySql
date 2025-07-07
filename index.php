<?php

require_once("Config/Config.php");


$ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index";
$array = explode("/", $ruta);
$controller = $array[0];
$metodo = "index";
$parametro = "";

if (!empty($array[1])) {
    $metodo = $array[1];
    
    /*if (!empty($array[1] != "")) {
        $metodo = $array[1];
    }*/
}

if (!empty($array[2])) {

    for ($i = 2; $i < count($array); $i++) {
            $parametro .= $array[$i] . ",";
        }
        $parametro = trim($parametro, ",");

    /*if (!empty($array[2] != "")) {
        for ($i = 2; $i < count($array); $i++) {
            $parametro .= $array[$i] . ",";
        }
        $parametro = trim($parametro, ",");
    }*/
}

require_once ("Config/App/autoload.php");
$dirControllers = "Controllers/" . $controller . ".php";
if (file_exists($dirControllers)) {
    require_once $dirControllers;
    $controllerobj = new $controller();
    if (method_exists($controllerobj, $metodo)) {
        $controllerobj->$metodo($parametro);
    } else {
        echo "No Existe el metodo";
    }
} else {
    echo "No Existe el controlador";
}
