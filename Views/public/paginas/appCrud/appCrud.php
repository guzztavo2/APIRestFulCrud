<div class="container shadow main flexColumn" style="width:100%; height:100%">
    <?php

use Controllers\informacaoController;

    $listaInfo;
    $paginaAtual;
    $totalPages;
    ?>
    <h1 style="height:5%">Painel da aplicação CRUD</h1>
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
                    <td><?php echo $item->getDataAtualizacao(); ?></td>
                    <td><?php echo $item->getDataCadastrada(); ?></td>
                    <td><?php echo $item->getQuemCadastrou()->getNomeUsuario(); ?></td>

                </tr>
            <?php endforeach; ?>

        </table>
    <?php endif; ?>
    <div class="paginacao flexRow">
        <?php if (count($listaInfo) == 0) : ?>
            <h2 class="pagina marcado">1</h2>
        <?php else : ?>
           <h2 class="pagina"> <a href="<?php echo informacaoController::gerarUrl(1); ?>"><i class="fa-solid fa-angles-left"></i></a></h2>

            <?php for ($n = 1; $n <= (int)$totalPages; $n++) : ?>
                <?php if ($paginaAtual == $n) : ?>
                <h2 class="pagina marcado"><a href="<?php echo informacaoController::gerarUrl($n); ?>"><?php echo $n; ?></a></h2>

                <?php else: ?>
                    <h2 class="pagina"><a href=""><?php echo $n; ?>2</a></h2>

                <?php endif; ?>
            <?php endfor; ?>
            <h2 class="pagina"><a href=""><i class="fa-solid fa-angles-right"></i></a></h2>

            <!-- <h2 class="pagina marcado">1</h2> -->
        <?php endif; ?>
    </div>
</div>


<style>
    div.container.main {
        border: 1px solid black;
        padding: 2%;
        overflow: auto;

    }

    div.main h1 {
        border-bottom: 1px solid black;
    }

    table {
        margin-top: 1%;
        min-width: 600px;
        background-color: #A8DADC;
        width: 100%;
        text-align: center;
        padding: 1%;
        height: 75%;
        box-shadow: rgba(0, 0, 0, 0.55) 0px 0px 10px;

    }

    table td {
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
        
        height: 15%;
        justify-content: center;
        align-items: center;
    }
    .pagina > a {
        display: block;
        width: 100%;
        height: 100%;
        background-color: red;
        padding: 2%;
    }
    .pagina {
        background-color: #1D3557;
        width: calc(100% / 14);
        border: 1px solid black;
        text-align: center;
        cursor: pointer;
        font-weight: 100;
        color: white;
        padding: 1% 0%;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        transition: ease-in-out 0.2s;
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