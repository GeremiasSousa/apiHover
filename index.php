<?php
header('Access-Control-Allow-Origin: *'); //Método que faz com que a API possa ser acessada por qualquer host
header('Content-type: application/json'); // Método que dita que qualquer enviado/recebido tem de ser JSON
header('Content-Type: text/html; charset=utf-8');

date_default_timezone_set("America/Sao_Paulo"); //Definindo o fuso-hórario do PHP


$uri = explode('/', $_GET['path']);
$error = json_encode(['erro' => 404,'msg' => 'Not found']);

if(isset($uri[0]) && $uri[0] != '') $context = $uri[0];
else{ echo 'Not found'; exit;}

if(isset($uri[1])) $acao = $uri[1];
else $acao = '';

if(isset($uri[2])) $parametro = $uri[2];
else $parametro = '';

if(isset($uri[3])) $where = $uri[3];
else $where = '';


$method = $_SERVER['REQUEST_METHOD'];

include_once('./src/models/db.class.php');
include_once('./src/controllers/getData.php');
include_once('./src/controllers/postData.php');