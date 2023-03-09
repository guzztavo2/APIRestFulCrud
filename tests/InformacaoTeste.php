<?php
require_once('./vendor/autoload.php');
use PHPUnit\Framework\TestCase;
require_once('config.php');
use Models\informacao;
use Models\user;
class InformacaoTeste extends TestCase
{
    public function testGetIdReturnsNullIfNotSet()
    {
        $informacao = new informacao();
        $this->assertNull($informacao->getId());
    }

    public function testSetAndGetId()
    {
        $informacao = new informacao();
        $id = '12345';
        $informacao->setId($id);
        $this->assertEquals($id, $informacao->getId());
    }
    public function testSetInformacaoShouldSetInformacaoIfWithinLengthLimits()
    {
        $informacao = new Informacao();
        $var = 'teste';
        $informacao->setInformacao($var);

        $result = $informacao->getInformacao();

        $this->assertEquals($var, $result);
    }
    
    public function testSetDataCadastrada()
    {
        $informacao = new informacao();
        $informacao->setDataCadastrada();
        $this->assertNotNull($informacao->getDataCadastrada());
    }

    public function testSetDataAtualizacao()
    {
        $informacao = new informacao();
        $informacao->setDataAtualizacao();
        $this->assertNotNull($informacao->getDataAtualizacao());
    }

    public function testGetDataCadastrada()
    {
        $informacao = new informacao();
        $informacao->setDataCadastrada();
        $this->assertNotNull($informacao->getDataCadastrada());
    }

    public function testGetDataAtualizacao()
    {
        $informacao = new informacao();

        $this->assertNull($informacao->getDataAtualizacao());
        $informacao->setDataAtualizacao();
        $this->assertNotNull($informacao->getDataAtualizacao());
    }
    public function testGetQuemCadastrou(): void
    {
        // Cria um novo usuário e informação
        $user = new user();
        $user->setNomeUsuario("Usuário Teste");
        $user->setSenhaUsuario("123456");
        $user->salvar();

        $user->buscarPorNome('Usuário Teste');

        $info = new informacao();

        $info->setInformacao("Informação de teste");
        $info->setQuemCadastrou($user);
        $info->setDataCadastrada(date('d/m/Y H:i:s'));

        $info->salvar();
        $info->buscarInformacao();
        // Verifica se o usuário que cadastrou a informação é o mesmo que recuperamos pelo método
        $this->assertEquals($user->getID(), $info->getQuemCadastrou()->getID());

        // Remove o usuário e informação cadastrados
        
        $info->deletarInformacao();
        $user->deletar();
    }

    public function testGetInformacaoList()
    {
        $informacoes = Informacao::getInformacaoList();

        $this->assertIsArray($informacoes);
        foreach ($informacoes as $informacao) {
            $this->assertInstanceOf(Informacao::class, $informacao);
        }
    }






}
