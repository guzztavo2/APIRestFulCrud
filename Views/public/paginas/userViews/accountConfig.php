
<div class="container flexColumn shadow" >
    <h2>Configuração da conta</h2>

    <h4>Chave de API:</h4>
    <small style="color:red;">Não compartilhe com ninguém, pois essa API é sua assinatura: 
    Se fizerem mudanças utilizando essa chave, resultará como se fosse você.</small>
    <input id="apikey" class="shadow" type="text" name="" id="" value="<?php echo Controllers\userController::getSessionUserLogado()->getApiKEY() ?>">
    <h4>Trocar senha:</h4>
    <a class="trocarSenha shadow" href="<?php echo Routes::HOME_PATH; ?>user/trocarsenha"><i style="color:black; font-size:22px; padding:0 10px" class="fa-solid fa-unlock-keyhole"></i> Trocar senha</a>
</div>

<script>
    let apiInput = document.getElementById('apikey');
    let apiValue = apiInput.value;

    apiInput.addEventListener('keyup',function(){
        this.value = apiValue;
    })
</script>

