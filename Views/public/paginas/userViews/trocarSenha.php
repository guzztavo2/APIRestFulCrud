<section>
    <?php if (isset($fail)) : ?>
        <div class="shadow" style="color:red; border:1px solid red; text-align:center; width:95%; padding:1%; margin:1% 2%;">
            <?php echo $fail; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <div class="shadow" style="color:green; border:1px solid green; text-align:center; width:95%; padding:1%; margin:1% 2%;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    <div class="container flexColumn shadow">
        <h2>Configuração da conta</h2>
        <h4>Trocar senha</h4>
        <?php if (isset($senhaNova)) : ?>

            <div class="shadow" style="color:green; border:1px solid green; text-align:center; width:95%; padding:1%; margin:1% 2%;">
                Tudo certo, agora digite sua nova senha, e conclua.
            </div>
            <form action="<?php echo Routes::HOME_PATH . 'user/trocarSenha' ?>" method="post">
                <input type="hidden" name="token" value="<?php echo $token ?>">
                <label for="senhaNova">
                    <H4>Digite a sua nova senha</H4>
                    <input type="password" name="senhaNova" placeholder="Digite a nova senha" id="senhaNova">

                </label>
                <label for="senhaNova_1">
                    <H4>Confirme a nova senha</H4>
                    <input type="password" placeholder="Repita a sua nova senha" name="senhaNova_1" id="senhaNova_1">
                    <small class="DangersenhaNova_1" style="color:red;"></small>
                </label>
                <input type="submit" value="Submeter">
            </form>
            <script>
                let senhaNova = document.getElementById('senhaNova_1');
                let senhaNovaInput = document.getElementById('senhaNova');

                senhaAntiga.addEventListener('focus', function() {
                    if (senhaAntigaInput.value.length == 0) {
                        senhaAntigaInput.focus();
                        dangerMessage('É necessário que a senha acima seja informado, e ambos sejam iguais pela confirmação.');
                    }
                })
                senhaAntiga.addEventListener('focusout', function() {
                    if (senhaAntigaInput.value !== senhaAntiga.value) {
                        senhaAntiga.focus();
                        dangerMessage('Ambas as senhas precisam ser iguais, por favor, reconfirme. Pois os dois campos estão diferentes.');
                    }

                })

                function dangerMessage(Message) {
                    let labelDanger = document.getElementsByClassName('DangersenhaNova_1')[0];

                    labelDanger.innerHTML = Message
                    setTimeout(() => {
                        labelDanger.innerHTML = '';
                    }, 5000);
                }
            </script>
        <?php else : ?>
            <form action="<?php echo Routes::HOME_PATH . 'user/verificarsenha' ?>" method="post">
                <input type="hidden" name="token" value="<?php echo $token ?>">
                <label for="senhaAntiga">
                    <H4>Senha atual</H4>
                    <input type="password" name="senhaAntiga" placeholder="Digite sua senha atual" id="senhaAntiga">

                </label>
                <label for="senhaAntiga">
                    <H4>Confirme a senha atual</H4>
                    <input type="password" placeholder="Repita sua senha atual" name="senhaAntiga_1" id="senhaAntiga_1">
                    <small class="senhaAntigaDanger" style="color:red;"></small>
                </label>
                <input type="submit" value="Submeter">
            </form>
            <script>
                let senhaAntiga = document.getElementById('senhaAntiga_1');
                let senhaAntigaInput = document.getElementById('senhaAntiga');

                senhaAntiga.addEventListener('focus', function() {
                    if (senhaAntigaInput.value.length == 0) {
                        senhaAntigaInput.focus();
                        dangerMessage('É necessário que a senha acima seja informado, e ambos sejam iguais pela confirmação.');
                    }
                })
                senhaAntiga.addEventListener('focusout', function() {
                    if (senhaAntigaInput.value !== senhaAntiga.value) {
                        senhaAntiga.focus();
                        dangerMessage('Ambas as senhas precisam ser iguais, por favor, reconfirme. Pois os dois campos estão diferentes.');
                    }

                })

                function dangerMessage(Message) {
                    let labelDanger = document.getElementsByClassName('senhaAntigaDanger')[0];

                    labelDanger.innerHTML = Message
                    setTimeout(() => {
                        labelDanger.innerHTML = '';
                    }, 5000);
                }
            </script>
        <?php endif; ?>

    </div>



</section>