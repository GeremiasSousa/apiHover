<?php

/**
 * Summary of DB
 * * @return bool|mysqli|int|string
 */
class DB
{
    //STATIC SERVE PARA CHAMAR O METODO JA JUNTO COM A CLASSE EX: db::connect()
    /**
     * Summary of connect
     * @return bool|mysqli
     */
    public static function connect()
    {
        return mysqli_connect('localhost', 'root', '', 'hoverline');
    }

    public static function createUserER($nome, $email, $senha, $insta, $face, $twitter, $img_user)
    {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $conexao = db::connect();
        $data = date('d/m/y');
        $sql = "INSERT INTO usuarios(tipo_usuario, nome_usuario, email_usuario, senha_usuario, data_cadastro, twiter_usuario, facebook_usuario, instagram_usuario, img_usuario) VALUES
           (
            'UR',
            '$nome',
            '$email',
            '$senha',
            '$data',
            '$twitter',
            '$face',
            '$insta',
            '$img_user'
           ) ";
        if (!db::verifyUser($email)) {
            if ($conexao->query($sql)) return true;
            exit;
        }
        return false;
    }
    public static function createUserLR($nome, $email, $senha, $img_user)
    {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $conexao = db::connect();
        $data = date('d/m/y');
        $sql = "INSERT INTO usuarios (tipo_usuario, nome_usuario, email_usuario, senha_usuario, data_cadastro, img_usuario) VALUES (
            'LR',
            '$nome',
            '$email',
            '$senha',
            '$data',
            '$img_user'
        )";

        if (!db::verifyUser($email)) {
            if ($conexao->query($sql)) return mysqli_insert_id($conexao);
        } else return false;
    }

    public static function moveImgUser($file)
    {
        define('RAIZ', 'C:/xampp/htdocs/apiHover/public');
        $pasta = '/img-users/';
        $nome_file = uniqid();
        $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($extensao != 'png' && $extensao != 'jpeg' && $extensao != 'jpg') {
            return false;
        }

        $point_end = move_uploaded_file($file['tmp_name'], RAIZ . $pasta . $nome_file . '.' . $extensao);
        $point_url = $nome_file . '.' . $extensao;
        if ($point_end) {
            return $point_url;
        } else return false;
    }

    public static function verifyUser($email)
    {
        $conexao = db::connect();
        $sql = "SELECT * FROM usuarios WHERE email_usuario = '$email' ";
        if (mysqli_num_rows($conexao->query($sql)) > 0) return true;
        else return false;
    }

    public static function validateUser($email, $senha)
    {
        $conexao = db::connect();
        $sql = "SELECT * FROM usuarios WHERE email_usuario = '$email' ";
        $res = $conexao->query($sql);
        if (mysqli_num_rows($res) > 0) {
            $usuario = mysqli_fetch_assoc($res);
            if (password_verify($senha, $usuario['senha_usuario'])) {
                return $usuario['id_usuario'];
            } else return false;
        }
        return false;
    }

    public static function getDataUsers($type = '')
    {
        $conexao = db::connect();
        $sql = "SELECT * FROM usuarios";
        if ($type != '') {
            $sql = "SELECT * FROM usuarios WHERE tipo_usuario = '$type'";
        }
        $usuarios_sql = $conexao->query($sql);
        $usuarios = array();
        if (mysqli_num_rows($usuarios_sql) > 0) {
            while ($key = mysqli_fetch_assoc($usuarios_sql)) {
                $usuarios[] = $key;
            }
            return json_encode($usuarios, JSON_UNESCAPED_UNICODE);
        } else {
            $usuarios['error'] = 404;
            $usuarios['message'] = 'Not found';
            return json_encode($usuarios, JSON_UNESCAPED_UNICODE);
        }
    }

    public static function getDataUser($id = '', $email = '')
    {
        $conexao = db::connect();
        $usuarios_sql = $conexao->query("SELECT * FROM usuarios  WHERE id_usuario = '$id' OR email_usuario = '$email' ");
        $usuarios = array();
        if (mysqli_num_rows($usuarios_sql) > 0) {
            while ($key = mysqli_fetch_assoc($usuarios_sql)) {
                $usuarios[] = $key;
            }
            return json_encode($usuarios, JSON_UNESCAPED_UNICODE);
        } else {
            $usuarios['error'] = 404;
            $usuarios['message'] = 'Not found';
            return json_encode($usuarios, JSON_UNESCAPED_UNICODE);
        }
    }

    public static function getFile($src)
    {
        if (file_exists('C:/xampp/htdocs/apiHover/public' . '/img-users/' . $src)) {
            return '/img-users/' . $src;
        } else if (file_exists('C:/xampp/htdocs/apiHover/public' . '/img-publi/' . $src)) {
            return '/img-publi/' . $src;
        } else return false;
    }


    public static function updateToUr($id, $tipo_usuario, $insta, $face, $twitter)
    {
        $conexao = db::connect();
        $sql = "UPDATE usuarios SET tipo_usuario = '$tipo_usuario', instagram_usuario = '$insta', facebook_usuario = '$face', twiter_usuario = '$twitter'  WHERE id_usuario = '$id' ";
        if ($conexao->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public static function updateDataUserImg($id, $img_src)
    {
        $conexao = db::connect();

        $sql = "UPDATE usuarios SET img_usuario = '$img_src' WHERE id_usuario = '$id' ";
        if ($conexao->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public static function updateDataUser($id, $dados)
    {
        $conexao = db::connect();
        $nome = $dados['nome'];
        $email = $dados['email'];
        $twitter = $dados['twitter'];
        $insta = $dados['insta'];
        $face = $dados['face'];

        $sql = "UPDATE usuarios SET nome_usuario = '$nome',
            email_usuario = '$email',
            twiter_usuario = '$twitter',
            instagram_usuario = '$insta',
            facebook_usuario = '$face' 
        WHERE id_usuario = '$id' ";

        if ($conexao->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}
