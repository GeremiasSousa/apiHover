<?php

if ($method === 'POST') {
    if ($context === 'user') {
        if ($acao === 'create') {
            if (isset($_POST['usuario'])) {
                $usuario = json_decode($_POST['usuario'], JSON_UNESCAPED_UNICODE);
                $usuario['img'] = $_FILES['file'];
                $moveImg = db::moveImgUser($usuario['img']);
                if ($moveImg) {
                    if (db::createUserLR($usuario['nome'], $usuario['email'], $usuario['senha'], $moveImg)) {
                        echo 'true';
                    } else {
                        unlink('C:/xampp/htdocs/apiHover/src/models' . $moveImg);
                        echo 'false';
                    }
                } else {
                    echo $error;
                }
            } else {
                echo $error;
            }
        }

        if ($acao === 'login') {
            if (isset($_POST['usuario'])) {
                $usuario = json_decode($_POST['usuario'], JSON_UNESCAPED_UNICODE);
                if(db::validateUser($usuario['email'], $usuario['senha'])){
                    echo 'criar seções';
                }else{
                    echo 'usuario não existe';
                }
            }
        }
    }

    if ($context === 'post') {
        if ($acao === 'create') {
            if (isset($_POST['publicacao'])) {
                $publicaco = json_decode($_POST['publicacao'], JSON_UNESCAPED_UNICODE);
                $publicaco['img'] = $_FILES['img'];
                $moveImg = post::moveImgPubli($publicaco['img']);
                if ($moveImg) {
                    if (post::createPost(
                        $publicaco['titulo'],
                        $publicaco['conteudo'],
                        $publicaco['previa'],
                        $publicaco['tag'],
                        $moveImg,
                        $publicaco['autor'],
                        $publicaco['id']
                    )) {
                        print_r('true');
                    }else{
                        unlink('C:/xampp/htdocs/apiHover/src/models' . $moveImg);
                        echo 'false';
                    }
                }
            }
        }
    }

}
