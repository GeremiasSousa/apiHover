<?php 
class POST{

    public static function error(){
        return json_encode(['erro' => 404,'msg' => 'Not found']);
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
