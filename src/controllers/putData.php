<?php 

if ($method === 'PUT') {
   if ($context === 'user' and $acao === 'update') {
    if (isset($_POST['usuario'])) {
        $usuario = json_decode($_POST['usuario'], true);
        print_r(db::updateDataUser($usuario['id'], $usuario));
    }
   }
}
