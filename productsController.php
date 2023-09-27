<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');
require 'productsModel.php';
$productsModel= new productsModel();
switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $productsModel->getProducts() : $productsModel->getProducts($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST= json_decode(file_get_contents('php://input',true));
        if(!isset($_POST->name) || is_null($_POST->name) || empty(trim($_POST->name)) || strlen($_POST->name) > 80){
            $respuesta= ['error','El nombre del producto no debe estar vacío y no debe de tener más de 80 caracteres'];
        }
        else if(!isset($_POST->descripcion) || is_null($_POST->descripcion) || empty(trim($_POST->descripcion)) || strlen($_POST->name) > 150){
            $respuesta= ['error','La descripción del producto no debe estar vacía y no debe de tener más de 150 caracteres'];
        }
        else if(!isset($_POST->precio) || is_null($_POST->precio) || empty(trim($_POST->precio)) || !is_numeric($_POST->precio) || strlen($_POST->precio) > 20){
            $respuesta= ['error','El precio del producto no debe estar vacío, debe ser de tipo numérico y no tener más de 20 caracteres'];
        }
        else{
            $respuesta = $productsModel->saveProducts($_POST->name,$_POST->descripcion,$_POST->precio);
        }
        echo json_encode($respuesta);
    break;

    case 'PUT':
        $_PUT= json_decode(file_get_contents('php://input',true));
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta= ['error','El ID del producto no debe estar vacío'];
        }
        else if(!isset($_PUT->name) || is_null($_PUT->name) || empty(trim($_PUT->name)) || strlen($_PUT->name) > 80){
            $respuesta= ['error','El nombre del producto no debe estar vacío y no debe de tener más de 80 caracteres'];
        }
        else if(!isset($_PUT->descripcion) || is_null($_PUT->descripcion) || empty(trim($_PUT->descripcion)) || strlen($_PUT->descripcion) > 150){
            $respuesta= ['error','La descripción del producto no debe estar vacía y no debe de tener más de 150 caracteres'];
        }
        else if(!isset($_PUT->precio) || is_null($_PUT->precio) || empty(trim($_PUT->precio)) || !is_numeric($_PUT->precio) || strlen($_PUT->precio) > 20){
            $respuesta= ['error','El precio del producto no debe estar vacío , debe ser de tipo numérico y no tener más de 20 caracteres'];
        }
        else{
            $respuesta = $productsModel->updateProducts($_PUT->id,$_PUT->name,$_PUT->descripcion,$_PUT->precio);
        }
        echo json_encode($respuesta);
    break;

    case 'DELETE';
        $_DELETE= json_decode(file_get_contents('php://input',true));
        if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
            $respuesta= ['error','El ID del producto no debe estar vacío'];
        }
        else{
            $respuesta = $productsModel->deleteProducts($_DELETE->id);
        }
        echo json_encode($respuesta);
    break;
}
