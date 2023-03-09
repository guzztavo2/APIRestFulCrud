<div class="container flexColumn" style="height:90%; overflow:auto; flex-flow:column nowrap; padding:2%;">
   <h2>Bem vindo a sessão: Sobre</h2>
   <p>Aqui você entenderá como a API REST funciona.</p>


   <h2 style="margin-top:2%">Antes de tudo, você precisa saber:</h2>
   <p>Essa API funciona como um CRUD, onde você pode Criar, Ler, Atualizar e Deletar.</p>

   <p style="margin-top:2%">
      Entretanto, para conseguir fazer isso, você precisa: criar ou logar em sua conta, pode fazer acima pelo header.
   </p>

   <h4 style="margin-top:2%">
      Para entender melhor, classe "Routes", que lida com as rotas e as requisições recebidas pela aplicação. A tabela
      abaixo descreve as funções, seus nomes e propósitos:<br>
   </h4>
   <table>
      <thead>
         <tr>
            <th>Nome da Função</th>
            <th>Descrição</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td>verificarTipoRequest</td>
            <td>Verifica se o método da requisição é suportado e o chama</td>
         </tr>
         <tr>
            <td>verificarTokenUser</td>
            <td>Verifica o token do usuário</td>
         </tr>
         <tr>
            <td>redirecionarDeleteMethod</td>
            <td>Manipula solicitações de exclusão de informações</td>
         </tr>
         <tr>
            <td>redirecionarPutMethod</td>
            <td>Manipula solicitações de atualização de informações</td>
         </tr>
         <tr>
            <td>verificarUrlParaDeletarInformacao</td>
            <td>Verifica se a URL é para a exclusão de informações</td>
         </tr>
         <tr>
            <td>verificarUrlParaAtualizarInformacao</td>
            <td>Verifica se a URL é para a atualização de informações</td>
         </tr>
         <tr>
            <td>responderRequisicaoNaoPermitida</td>
            <td>Responde com código 403 se a requisição não for permitida</td>
         </tr>
         <tr>
            <td>redirecionamentoPOSTmethod</td>
            <td>Manipula as solicitações POST com base na URL</td>
         </tr>
         <tr>
            <td>filtrarDadosDeEntrada</td>
            <td>Filtra e retorna dados de entrada POST</td>
         </tr>
         <tr>
            <td>__construct</td>
            <td>Método construtor, que inicializa a classe e chama outras funções</td>
         </tr>
         <tr>
            <td>setURL</td>
            <td>Extrai a URL da solicitação e a armazena em uma propriedade</td>
         </tr>
         <tr>
            <td>getURL</td>
            <td>Retorna a URL armazenada na propriedade</td>
         </tr>
         <tr>
            <td>getLocalUrl</td>
            <td>Retorna a URL da solicitação atual</td>
         </tr>
         <tr>
            <td>redirecionarGETmethod</td>
            <td>Manipula solicitações GET com base na URL</td>
         </tr>
      </tbody>
   </table>

   <p><br>
      O código trata as requisições POST, GET, PUT e DELETE. Os endpoints para as requisições POST estão definidos no
      método redirecionamentoPOSTmethod(), enquanto que os endpoints para as requisições GET, PUT e DELETE estão
      definidos nos métodos redirecionarGETmethod(), redirecionarPutMethod() e redirecionarDeleteMethod(),
      respectivamente. Os endpoints para as requisições DELETE e PUT são dinâmicos e dependem do ID da informação que
      se deseja deletar ou atualizar.

   </p>
   <h2 style="margin-top:2%">Exemplos de utilização:<br><br></h2>

   <p>Digamos que a conta já está criada e com acesso ativo.<br><br></p>
   <p>Para inserir uma informação, é necessário enviar um método POST para a URL "informacao/inserirInformacao",
      juntamente com a APIKEY da sua conta no cabeçalho da autenticação. O conteúdo da solicitação deve ser um array
      em JSON com as informações que você deseja salvar, como mostrado abaixo:</p>
   <table>
      <thead>
         <tr>
            <th>URL</th>
            <th>Método HTTP</th>
            <th>Cabeçalho de autenticação</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td>informacao/inserirInformacao</td>
            <td>POST</td>
            <td>Authorization: Bearer {APIKEY}</td>
         </tr>
      </tbody>
   </table>
   <h4><br>Corpo JSON:</h4>
   <ol>
      <li>{ "informacao": "Este é o primeiro objeto" }</li>
      <li>{ "informacao": "Este é o segundo objeto" }</li>
      <li>{ "informacao": "Este é o terceiro objeto" }</li>
      <li>{ "informacao": "Este é o quarto objeto" }</li>
   </ol>
   <p>Para excluir uma informação, é necessário enviar uma solicitação DELETE para a URL
      'informacao/deletarinformacao', juntamente com a APIKEY da sua conta incluída no cabeçalho de autenticação. O
      corpo da solicitação deve ser um array em JSON com o ID das informações que você deseja deletar, conforme
      exemplificado abaixo:</p>
   <table>
      <thead>
         <tr>
            <th>URL</th>
            <th>Método HTTP</th>
            <th>Cabeçalho de autenticação</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td>informacao/deletarinformacao </td>
            <td>DELETE</td>
            <td>Authorization: Bearer {APIKEY}</td>
         </tr>
      </tbody>
   </table>
   <h4><br>Corpo JSON:</h4>
   <ol>
      <li>{ "id": "1" }</li>
      <li>{ "id": "2" }</li>
      <li>{ "id": "3" }</li>
      <li>{ "id": "4" }</li>
   </ol>


   <p>Para atualizar uma informação, é necessário enviar um método PUT para a URL 'informacao/atualizarinformacao',
      juntamente com a APIKEY da sua conta no cabeçalho da autenticação. O conteúdo da solicitação deve ser um objeto
      em JSON com o ID da informação que deseja atualizar e as novas informações, como mostrado abaixo:</p>
   <table>
      <thead>
         <tr>
            <th>URL</th>
            <th>Método HTTP</th>
            <th>Cabeçalho de autenticação</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td>informacao/atualizarinformacao </td>
            <td>PUT</td>
            <td>Authorization: Bearer {APIKEY}</td>
         </tr>
      </tbody>
   </table>
   <h4><br>Corpo JSON:</h4>
   <ol>
      <li>{ "id": "1", "novaInformacao": "Esta é a informação 1 atualizada" }</li>
      <li> {"id": "2",
         "novaInformacao": "Esta é a informação 2 atualizada"} </li>
      <li> {"id": "3",
         "novaInformacao": "Esta é a informação 3 atualizada"} </li>
   </ol>


   <p>Observe que o método HTTP utilizado para atualizar informações é o PUT e não o DELETE. Além disso, como as outras
      requisições, você pode atualizar diversas informações, enviando no corpo da requisição.</p>
</div>




<style>
   table {
      margin: 0 0;
      border: 1px solid black;
   }

   table th {
      border: 1px solid black;
   }

   table td {
      border: 1px solid black;
      padding: 1%;
   }

   ol {
      padding: 2% 3%;
   }

   ol li {
      padding: 1%;
   }
</style>