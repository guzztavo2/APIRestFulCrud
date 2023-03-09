<section>
    <div class="container" style="display:flex; flex-flow:column nowrap">
        <h1>Informação:</h1>
        <div class="informacoes">
            <label for="id"> Identificador:
                <textarea id="id"><?php echo $informacao->getId() ?? 'Não há a informação: "id" da informação cadastrada.'; ?></textarea>
            </label>

            <label for="informacao"> Informação:
                <textarea id="informacao"><?php echo $informacao->getInformacao() ?? 'Não há a informação cadastrada.'; ?></textarea>
            </label>

            <label for="dataAtualizacao"> Data de atualização:
                <textarea id="dataAtualizacao"><?php echo $informacao->getDataAtualizacao() ?? 'Não há a informação: "data de atualização" da informação cadastrada.'; ?></textarea>
            </label>

            <label for="dataCadastrada"> Data cadastrada:
                <textarea id="dataCadastrada"><?php echo $informacao->getDataCadastrada() ?? 'Não há data cadastrada'; ?></textarea>
            </label>

            <label for="quemCadastrou"> Usuário que cadastrou:
                <textarea id="quemCadastrou"><?php echo $informacao->getQuemCadastrou() ?? 'Não há a informação: "Usuário" da informação cadastrada.'; ?></textarea>
            </label>

        </div>
    </div>
</section>

<script>
    let listTexts = document.querySelectorAll('textarea');
    let listValues = [];
    listTexts.forEach(item => {
    let valor = item.innerHTML;

    item.addEventListener('keyup', function(){
        this.value = valor;
    })
    })
</script>


<style>
    section {
        width: 100%;
        padding: 0 2%;
        height: 80%;
    }

    div.container>h1 {
        padding: 1% 0;
        border-bottom: 1px solid black;
        border-top: 1px solid black;
        max-height: 10%;
        font-weight: 500;
        text-transform: uppercase;

    }

    div.informacoes {
        height: 100%;
        width: 100%;
        padding: 2%;
        overflow: auto;

        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;

    }

    section>div.container {
        height: 100%;
        width: 100%;
       justify-content: space-around;
      
    }

    div.informacoes label,
    textarea {
        width: 100%;
        resize: none;
        font-size: 20px;
        text-align: center;
    }

    textarea {
        margin: 0.50% 0;
        font-size: 26px;
        display: inline;
        height: 10%;

    }
</style>