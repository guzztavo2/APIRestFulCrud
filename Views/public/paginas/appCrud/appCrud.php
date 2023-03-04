<div class="container shadow main flexColumn" style="width:100%; height:100%">
    <h1 style="height:5%">Painel da aplicação CRUD</h1>
    <?php if (count($listaInfo) === 0) : ?>
        <table>
            <tr>
                <th>Informações</th>
            </tr>
            <tr><td><p>Não há informações cadastradas.</p></td></tr>
        </table>

    <?php else : ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Informação</th>
                <th>Quando foi cadastrado</th>
                <th>Quem cadastrou</th>
            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>

            </tr>
        </table>
    <?php endif; ?>

    <div class="paginacao flexRow">
        <h2 class="pagina"><i class="fa-solid fa-angles-left"></i></h2>
        <h2 class="pagina">2</h2>
        <h2 class="pagina">3</h2>
        <h2 class="pagina">1</h2>
        <h2 class="pagina">2</h2>
        <h2 class="pagina">3</h2>
        <h2 class="pagina">1</h2>
        <h2 class="pagina">2</h2>
        <h2 class="pagina">3</h2>
        <h2 class="pagina">1</h2>
        <h2 class="pagina marcado">1</h2>
        <h2 class="pagina"><i class="fa-solid fa-angles-right"></i></h2>
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
        padding: 2%;
        height: 15%;
        justify-content: center;
        align-items: center;
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