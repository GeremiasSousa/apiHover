<?php

if ($method === 'POST') {

    //Rota de criação de usuário LR
    if ($context === 'user') {
        if ($acao === 'create') {
            if ($parametro === 'lr') {
                if (isset($_POST['usuario'])) {
                    $usuario = json_decode($_POST['usuario'], JSON_UNESCAPED_UNICODE);
                    $cadastro = db::createUserLR($usuario['nome'], $usuario['email'], $usuario['senha'], $moveImg = '');
                    if ($cadastro != false) {
                        print_r($cadastro);
                    } else {
                        echo 'false';
                    }
                } else {
                    echo $error;
                }
            }
        }

        //Rota de modificação do usuário LR para UR
        if ($acao === 'update') {
            if ($parametro === 'ur' and isset($_POST['usuario']) and $where === 'social') {
                $usuario = json_decode($_POST['usuario'], JSON_UNESCAPED_UNICODE);
                if (db::updateToUr($usuario['id'], $usuario['tipo'], $usuario['instagram'], $usuario['facebook'], $usuario['twitter'])) {
                    print_r('true');
                } else print_r('false');
            }
        }

        //Rota de inserção de foto do usuário
        if ($acao === 'update') {
            if ($parametro === 'file' and isset($where)) {
                $img_src = db::moveImgUser($_FILES['file']);
                if ($img_src != false and db::updateDataUserImg($where, $img_src)) print_r('true');
                else print_r('false');
            }
        }

        //Rota de autenticação de usuário
        if ($acao === 'login') {
            if (isset($_POST['usuario'])) {
                $usuario = json_decode($_POST['usuario'], JSON_UNESCAPED_UNICODE);
                $verify = db::validateUser($usuario['email'], $usuario['senha']);
                if ($verify) {
                    $_SESSION['usuario'] = json_decode(db::getDataUser($verify), true); // O valor retornardo na matriz é 
                    // $_SESSION['usuario'][0] ou seja, os valores dos usuários estarão no primeiro índice do array
                    print_r('true');
                } else {
                    print_r($error);
                }
            } else {
                print_r($error);
            }
        }
    }

    //Rota de criar publicações
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
                    } else {
                        unlink('C:/xampp/htdocs/apiHover/src/models' . $moveImg);
                        echo 'false';
                    }
                }
            }
        }
    }
}
