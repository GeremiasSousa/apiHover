<?php
class DB
{
    //STATIC SERVE PARA CHAMAR O METODO JA JUNTO COM A CLASSE EX: db::connect()
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
            if ($conexao->query($sql)) return true;
        } else return false;
    }

    public static function moveImgUser($file)
    {
        define ('RAIZ', 'C:/xampp/htdocs/apiHover/public');
        $pasta = '/img-users/';
        $nome_file = uniqid();
        $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($extensao != 'png' && $extensao != 'jpeg' && $extensao != 'jpg') {
           return 'isso não é uma imagem';
        }

        $point_end = move_uploaded_file($file['tmp_name'], RAIZ . $pasta . $nome_file . '.' . $extensao);
        $point_url = $nome_file . '.' . $extensao;
        if ($point_end) {
            return $point_url;
        }else echo 'Não moveu';
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
            }
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

    public static function getDataUser($id)
    {
        $conexao = db::connect();
        $usuarios_sql = $conexao->query("SELECT * FROM usuarios  WHERE id_usuario = '$id'");
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

    public static function getFile($src){
        $file = file_exists(realpath(dirname(__FILE__)).'/img-users/'.$src);
        if($file){
            return '/img-users/'.$src; 
        }
        else return post::error();
    }

    
}
