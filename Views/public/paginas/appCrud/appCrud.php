<div class="container shadow main flexColumn" style="width:100%; height:100%;">
    <?php

    use Controllers\informacaoController;

    $listaInfo;
    $paginaAtual;
    $totalPages;
    ?>
    <h1>Painel da aplicação CRUD</h1>
    <?php if (count($listaInfo) === 0) : ?>
        <table>
            <tr>
                <th>Informações</th>
            </tr>
            <tr>
                <td>
                    <p>Não há informações cadastradas.</p>
                </td>
            </tr>
        </table>

    <?php else : ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Informação</th>
                <th>Quando foi cadastrado</th>
                <th>Quando foi atualizado</th>
                <th>Quem cadastrou</th>
            </tr>
            <?php foreach ($listaInfo as $item) : ?>
                <tr>
                    <td><?php echo $item->getId(); ?></td>
                    <td><?php echo $item->getInformacao() ?></td>
                    <td><?php echo $item->getDataCadastrada(); ?></td>
                    <td><?php echo $item->getDataAtualizacao(); ?></td>
                    <td><?php if ($item->getQuemCadastrou() == false) {
                            echo 'O usuário não existe ou teve sua conta deletada!';
                        } else {
                            echo $item->getQuemCadastrou()->getNomeUsuario();;
                        } ?></td>

                </tr>
            <?php endforeach; ?>

        </table>
    <?php endif; ?>

    <div class="paginacao flexRow">
        <?php if (count($listaInfo) == 0) : ?>
            <h2 class="pagina marcado">1</h2>
            <?php else :
            $maxPages = 0;
            $initialPage = 0;
            informacaoController::gerarPaginacao($totalPages, $paginaAtual, $maxPages, $initialPage);

            if ($paginaAtual == 1) : ?>
                <h2 class="pagina" disabled="true"> <a href="<?php echo informacaoController::gerarUrl(1); ?>"><i class="fa-solid fa-angles-left"></i></a></h2>

            <?php else : ?>

                <h2 class="pagina"> <a href="<?php echo informacaoController::gerarUrl($paginaAtual - 1); ?>"><i class="fa-solid fa-angles-left"></i></a></h2>
            <?php endif; ?>

            <?php for ($n = $initialPage; $n <= (int)$maxPages; $n++) : ?>
                <?php if ($paginaAtual == $n) : ?>
                    <h2 class="pagina marcado"><a href="<?php echo informacaoController::gerarUrl($n); ?>"><?php echo $n; ?></a></h2>

                <?php else : ?>
                    <h2 class="pagina"><a href="<?php echo informacaoController::gerarUrl($n); ?>"><?php echo $n; ?></a></h2>

                <?php endif; ?>
            <?php endfor;
            if ($maxPages == $paginaAtual) : ?>
                <h2 class="pagina" disabled="true"> <a href="<?php echo informacaoController::gerarUrl($paginaAtual); ?>"><i class="fa-solid fa-angles-right"></i></a></h2>
            <?php else : ?>
                <h2 class="pagina"><a href="<?php echo informacaoController::gerarUrl($paginaAtual + 1); ?>"><i class="fa-solid fa-angles-right"></i></a></h2>
            <?php endif; ?>

            <!-- <h2 class="pagina marcado">1</h2> -->
        <?php endif; ?>
    </div>
</div>

<script>
    let listTD = document.querySelectorAll('table tr');
    listTD.forEach(item =>{
        item.addEventListener('click', function(e){
            window.location.href = HOME_PATH + 'informacao/'+e.target.parentElement.children[0].innerHTML;
        });
    })
</script>
<style>
    div.container.main {
        border: 1px solid black;
        padding: 2%;
        overflow: auto;
        flex-flow: column nowrap;
    }

    div.main h1 {
        border-bottom: 1px solid black;
        height:10%;
    }

    table {
        margin-top: 1%;
        min-width: 600px;
        min-height: 400px;
        background-color: #A8DADC;
        width: 100%;
        text-align: center;
        padding: 1%;
        height: 75%;
        box-shadow: rgba(0, 0, 0, 0.55) 0px 0px 10px;

    }

    table th {
        padding: 1%;
        height: 5px;
    }

    table td {
        height: calc(100% / 8);
        padding: 1% 0;
        background-color: #1D3557;
        color: white;
        cursor: pointer;
        box-shadow: rgba(0, 0, 0, 0.55) 0px 0px 10px;
        font-size: 18px;
    }

    table tr:hover>td {
        background-color: #E63946;
    }

    .paginacao {
        width: 100%;
        min-width: 600px;
        height: 15%;
        justify-content: center;
        flex-flow: row nowrap;
        align-items: center;
    }

    .pagina>a {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 900;
        text-decoration: none;
        text-shadow: 2px 2px 2px black;
    }

    .pagina {
        background-color: #1D3557;
       
        width: calc(100% / 14);
        
        border: 1px solid black;
        min-width: 35px;
        height: 100%;
        text-align: center;
        cursor: pointer;
        font-weight: 100;
        color: white;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        transition: ease-in-out 0.2s;
   
    }

    .pagina[disabled=true] {
        opacity: 75%;
        cursor: not-allowed;
    }

    .pagina[disabled=true] a {

        cursor: not-allowed;
    }

    .pagina:hover {
        background-color: #457B9D;
        box-shadow: rgba(0, 0, 0, 0.80) 5px 5px 5px;
        z-index: 0;
    }

    .pagina.marcado {
        background-color: #A8DADC;
        color: black;
    }
</style>