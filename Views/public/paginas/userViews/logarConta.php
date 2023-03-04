
<?php if(isset($fail) && strlen($fail) > 0): ?>
<div class="failMessage">
Não foi possível acessar a sua conta, pois houve um erro: <br>
<?php echo $fail; ?>

</div>

<?php endif; ?>

<?php if(isset($success) && strlen($success) > 0): ?>
<div class="successMessage">
<?php echo $success; ?>

</div>

<?php endif; ?>
<div class="container flexColumn w100" style="height:70%;margin-top:1%; overflow-y:auto; overflow-x:hidden; flex-wrap: nowrap;">
    <h2>Acesse utilizando sua conta</h2>
    <form action="<?php echo routes::HOME_PATH . 'user/acessarConta'; ?>" method="post" class="flexColumn w100" style="justify-content:space-between">
        <label for="nomeUsuario">
            Nome de Usuário:<br>
            <input type="text" name="nomeUsuario" class="w100" style="padding:1% 1%;" id="nomeUsuario">
        </label>
        <label for="password">
            Sua senha:<br>
            <input type="password" class="w100" style="padding:1% 1%;" name="senhaUsuario" id="password">
        </label>

        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <input type="submit" value="Acessar Conta">
    </form>
</div>


<style>


</style>