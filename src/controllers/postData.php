<?php

if ($method === 'POST') {
    if ($context === 'user') {
        if ($acao === 'create') {
            if (isset($_POST['dados'])) {
                $usuario = json_decode($_POST['dados'], JSON_UNESCAPED_UNICODE);
                $usuario['img'] = $_FILES['file'];
                $moveImg = db::moveImgUser($usuario['img']);
                if ($moveImg) {
                    if (db::createUserLR($usuario['nome'], $usuario['email'], $usuario['senha'], $moveImg)) {
                        echo 'true';
                    } else {
                        unlink('C:/xampp/htdocs/apiHover/src/models'.$moveImg);
                        echo 'false';
                    }
                }else{
                    echo $error;
                }
            } else {
                echo $error;
            }
        }
    }
}
