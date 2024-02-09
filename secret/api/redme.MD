Seja bem vindo (a) à Calculadora de Férias!

Para execultar o projeto você vai precisar ter o xampp v3.3.0
O sistema tem a integração com o banco de dados MySQL e será preciso conectar com o banco de dados e ultilizar o script que está no arquivo creation.sql

Foi utilizado para este projeto HTML5, CSS, PHP, JavaScript e MySQL

Para esse projeto foi utilizado o JWT para a verificação de segurança com o banco de dados.
Foi feito inserção dinâmica foi que você vai conseguir vizualizar ao longo do projeto se você notar ele
está estruturado para ter um ponto de volta mas devido ao curto tempo não foi possível acrescentar.

O projeto foi feito com rotas que você consegue vizualizar em index.php para direcionar as páginas de login, cadastro, 404 e dashboard.
Dentro de dashboard foi ultilizado step para reduzir o tempo de retorno de resposta e dando uma ótima experiência para o usuário.

A tela inicial é a página de login atravês de localhost/secret e sempre que um usuário não logado tentar acessar o conteúdo da calculadora fazer o acesso será redirecionado para a tela inicial. Caso o usuário já esteja logado e entrar novamente no sistema será redirecionado para a página inicial da calculadora e não de login novamente.

Para o banco de dados está sendo armazenado os dados do usúario e também os dados ultilizados na calculadora pelo usuário armazenando os resultados e o preenchimento que o usuário fez. Está sendo armazenado também data e horario que o usuário usou o sitema para fazer os cálculos.