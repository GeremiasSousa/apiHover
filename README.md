# apiHover
A API do blog HOVERLINE

# Ela será do tipo REST, tendo como principal objetivo alimentar o sistema do blog HOVERLINE;
# Todas as requisições feitas na API deverá ser de forma dinâmica pois há a necessidade de uma arquitetura client-sever;
# Por ela ser do tipo REST os dados retornados deveram ser do tipo JSON;
# E pricipal função de leitura, criação, atualização e exclusão dos dados no banco de dados;
# Ela também será responsavel pela autenticação de usuários juntamente com Multifator;
# As requisições feitas na api deverão ser contextualizadas nesse padrão para os usuários:
	1. [GET] /users/getAll -> Para mostrar todos os dados dos usuários;
	2. [GET] /users/getAll/:tipo -> Para mostrar todos os dados dos usuários de tipo ER ou LR;
	3. [GET] /users/getAll/:id -> Para mostrar todos os dados de um usuário específico;
	4. [POST] /users/create/ -> Para criar um novo usuário na base de dados;
	5. [UPDATE] /users/update/:id -> Para atualizar dados de um usuário no banco de dados;
	6. [DELETE] /users/delete/:id -> Para apagar dados de um usuário no banco de dados;
# As requisições feitas na api deverão ser contextualizadas nesse padrão para as publicações:
	1. [GET] /posts/getAll/ -> Para mostrar todos os dados das puplicações;
	2. [GET] /posts/getAll/:id -> Para mostrar todos os dados de uma publicação específica;
	3. [POST] /posts/create/ -> Para criar uma nova publicação na base de dados;
	4. [UPDATE] /posts/update/:id -> Para atualizar dados de uma publicação no banco de dados;
	5. [DELETE] /posts/delete/:id -> Para apagar dados de uma publicação no banco de dados;