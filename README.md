<h1>APIRestFulCrud</h1>
    <p>Este repositório contém uma API RESTful em PHP que permite a realização de operações CRUD (Create, Read, Update,
        Delete) em um banco de dados MySQL.</p>
    <h2>Estrutura do diretório</h2>
    <p>O repositório está organizado da seguinte maneira:</p>
    <ul>
       <li><code>Controllers</code>:Os Controllers são responsáveis por controlar cada modelo do aplicativo. Eles enviam
        dados para a view e executam a validação dos dados recebidos. Além disso, a classe de rotas se conecta aos
        Controllers para encaminhar as solicitações recebidas.</li>
    <li><code>Models</code>:Os modelos são responsáveis por conectar o aplicativo ao banco de dados. 
    Cada modelo representa uma tabela no banco de dados. Por exemplo, o modelo de usuário <code>user</code> 
    possui uma chave estrangeira no modelo/tabela <code>informacao</code> para registrar quem cadastrou cada informação.</li>
    <li><code>Views</code>:As views são responsáveis pela exibição de informações para o usuário, mas quem decide se o usuário
     tem permissão para acessar uma determinada página é o controlador. As views são responsáveis pelo Front-End 
    da aplicação e geralmente incluem linguagens como Javascript e CSS para fornecer uma interface interativa e agradável ao usuário.</li>
    <li><code>Code</code>:Este diretório é destinado ao armazenamento de scripts em JavaScript..</li>
    <li><code>Style</code>:Este diretório é destinado ao armazenamento de scripts em CSS.</li>
    <li><code>WebFonts</code>:Neste projeto, foi utilizado o recurso de font FontAwesome para tornar a interface do usuário mais atraente.</li>
    </ul>
    <h2>Requisitos do sistema</h2>
    <p>Para executar este projeto em seu ambiente local, você precisará ter instalado:</p>
    <ul>
        <li>PHP 7.2 ou superior</li>
        <li>MySQL 5.7 ou superior</li>
    </ul>
    <h2>Instalação</h2>
    <p>Para instalar e configurar este projeto em seu ambiente local, siga estas etapas:</p>
    <ol>
        <li>Clone o repositório para o seu computador</li>
        <li>Configure o banco de dados no arquivo <code>config.php</code></li>
        <li>Inicie o servidor PHP no arquivo <code>index.php</code> com o comando <code>php -S localhost:8000</code></li>
        <li>Acesse a documentação em <code>http://localhost:8000/pastaDoArquivo/sobre</code> para ver as rotas disponíveis e seus parâmetros.</li>
    </ol>
    <h2>Uso</h2>
    <p>A API permite a realização das seguintes operações:</p>
   <table><thead><tr><th>Método HTTP</th><th>Endpoint</th><th>Descrição</th></tr></thead><tbody><tr><td>POST</td><td>user/criarConta</td><td>Cria uma nova conta de usuário</td></tr><tr><td>POST</td><td>user/acessarConta</td><td>Faz o login do usuário</td></tr><tr><td>POST</td><td>user/verificarsenha</td><td>Verifica se a senha inserida pelo usuário está correta</td></tr><tr><td>POST</td><td>user/trocarSenha</td><td>Troca a senha do usuário</td></tr><tr><td>POST</td><td>informacao/inserirInformacao</td><td>Insere uma nova informação no sistema</td></tr><tr><td>GET</td><td>home</td><td>Redireciona para a página principal do site</td></tr><tr><td>GET</td><td>sobre</td><td>Redireciona para a página "Sobre" do site</td></tr><tr><td>GET</td><td>informacao/{id}</td><td>Exibe as informações correspondentes ao ID fornecido</td></tr><tr><td>GET</td><td>user/criar</td><td>Redireciona para a página de criação de nova conta de usuário</td></tr><tr><td>GET</td><td>user/logar</td><td>Redireciona para a página de login do usuário</td></tr><tr><td>GET</td><td>user/conta</td><td>Redireciona para a página principal da conta do usuário</td></tr><tr><td>GET</td><td>user/configuracao</td><td>Redireciona para a página de configurações da conta do usuário</td></tr><tr><td>GET</td><td>user/trocarsenha</td><td>Redireciona para a página de troca de senha do usuário</td></tr><tr><td>GET</td><td>user/app</td><td>Exibe informações adicionais do sistema para usuários logados</td></tr><tr><td>GET</td><td>user/sair</td><td>Faz logout do usuário</td></tr><tr><td>DELETE</td><td>informacao/{id}</td><td>Deleta uma informação correspondente ao ID fornecido</td></tr><tr><td>PUT</td><td>informacao/{id}</td><td>Atualiza uma informação correspondente ao ID fornecido</td></tr></tbody></table>
    <p>Você pode enviar requisições HTTP para a API usando o software de sua escolha, como o Postman ou o cURL. Certifique-se de fornecer os parâmetros necessários para cada rota, conforme especificado na documentação.</p>

    <h2>Licença</h2>
    <p>Este projeto está licenciado sob a Licença MIT.</p>
