<?php
if ($method === 'GET') {
    //Rota de mostrar os usuários por tipo ou id
    if ($context === 'users') {
        if ($acao === 'getAll') {
            if ($parametro === '') {
                print_r(db::getDataUsers());
                exit;
            } else if ($parametro === 'er') {
                print_r(db::getDataUsers('ER'));
                exit;
            } else if ($parametro === 'lr') {
                print_r(db::getDataUsers('LR'));
                exit;
            } else {
                print_r(db::getDataUser($parametro));
            }
        }
    }

    //Rota de mostrar os posts
    if ($context === 'posts') {
        if ($acao === 'getAll') {
            print_r(post::getDataPosts($parametro));
        }
    }

    //Rota de retorno de fotos
    if ($context === 'file') {
        if ($acao === 'get') {
            if ($parametro != '') {
                $file = db::getFile($parametro);
                if ($file != false) {
                    $extent = explode('.', $file);
                    if ($extent[1] === 'jpg') $extent[1] = 'jpeg';
                    header("Content-type: image/$extent[1]");
                    header("Content-Disposition: filename=" . $parametro . "");
                    if ($extent[1] === 'jpeg') {
                        $img = imagecreatefromjpeg("http://localhost/apiHover/public$file");
                        imagejpeg($img, null, 95);
                    } else if ($extent[1] === 'png') {
                        $img = imagecreatefrompng("http://localhost/apiHover/public$file");
                        imagealphablending($img, false);
                        imagesavealpha($img, true);
                        imagecolortransparent($img);
                        imagepng($img, null, 8);
                    }else if(!$file){
                        print_r($error);
                    }
                } else {
                    print_r($error);
                }
            }
        }
    }

    if($context === 'user'){
        if ($acao === 'logoff') {
            if (isset($_SESSION['usuario'])) {
                unset($_SESSION['usuario']);
                print_r('true');
            }else{
                print_r('false');
            }
        }
    }
}
