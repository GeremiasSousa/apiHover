<?php 
class POST{

    public static function error(){
        return json_encode(['erro' => 404,'msg' => 'Not found']);
    }

    public static function createPost($titulo, $conteudo, $previa, $tag, $img, $nome_user, $id_user){
        $conexao = db::connect();
        $data = date('d/m/y');
        $sql = "INSERT INTO publicacoes (titulo_publicacao, conteudo_publicacao, previa_publicacao, tag_publicacao, data_publicacao, img_publicacao, nome_usuario, id_usuario)
        VALUES (
            '$titulo',
            '$conteudo',
            '$previa',
            '$tag',
            '$data',
            '$img',
            '$nome_user',
            '$id_user'
        )";
        $conexao -> query($sql);
        return true;
    }


    public static function moveImgPubli($file){
        define ('RAIZ', realpath(dirname(__FILE__)));
        $pasta = '/img-publi/';
        $nome_file = uniqid();
        $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($extensao != 'png' && $extensao != 'jpeg' && $extensao != 'jpg') {
           return 'isso não é uma imagem';
        }

        $point_end = move_uploaded_file($file['tmp_name'], RAIZ . $pasta . $nome_file . '.' . $extensao);
        $point_url = $pasta . $nome_file . '.' . $extensao;
        if ($point_end) {
            return $point_url;
        }else echo 'Não moveu';
    }

    public static function getDataPosts($id = '')
    {
        $conexao = db::connect();
        $sql = "SELECT * FROM publicacoes";
        if($id != '') {
            $sql = "SELECT * FROM publicacoes WHERE id_publicacao = '$id' ";
        }
        $posts_sql = $conexao->query($sql);
        if(mysqli_num_rows($posts_sql) > 0){
        $posts = array();
        while ($key = mysqli_fetch_assoc($posts_sql)) {
            $posts[] = $key;
        }
        return json_encode($posts, JSON_UNESCAPED_UNICODE);
    }
     return post::error();
    }
}
