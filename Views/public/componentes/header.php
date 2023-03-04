<!DOCTYPE html>
<html lang="br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="<?php echo routes::HOME_PATH; ?>/style/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo routes::HOME_PATH; ?>/style/configGeral.css">
    <?php if(file_exists('./style/'.explode('.', $page)[0] . 'File.css')): ?>
    <link rel="stylesheet" type="text/css" href="<?php echo routes::HOME_PATH.'style/'.explode('.', $page)[0] . 'File' ?>.css">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700;900&display=swap" rel="stylesheet">
</head>


<body class="flexColumn" style="justify-content: space-between; flex-wrap:nowrap;">
    <header class="w100" style="padding:1%; background-color: #1D3557; box-shadow: rgba(0, 0, 0, 0.446) 0px 5px 15px;">
        <div class="container">
            <nav class="flexRow">
                <ol class="flexRow w50">
                    <?php switch (routes::getLocalUrl()[0]):
                        case 'home': ?>
                            <li class="w50" style="text-align:center;"><a href="<?php echo routes::HOME_PATH; ?>" style="background-color:#A8DADC;"><i class="fa-solid fa-house"></i> Home</a></li>
                            <li class="w50" style="text-align:center;"><a href="<?php echo routes::HOME_PATH . 'sobre' ?>"><i class="fa-solid fa-question"></i> Sobre</a></li>
                        <?php break;
                        case 'sobre': ?>
                            <li class="w50" style="text-align:center;"><a href="<?php echo routes::HOME_PATH; ?>"><i class="fa-solid fa-house"></i> Home</a></li>
                            <li class="w50" style="text-align:center;"><a href="<?php echo routes::HOME_PATH . 'sobre' ?>" style="background-color:#A8DADC;"><i class="fa-solid fa-question"></i> Sobre</a></li>
                        <?php break;
                        default: ?>
                            <li class="w50" style="text-align:center;"><a href="<?php echo routes::HOME_PATH; ?>"><i class="fa-solid fa-house"></i> Home</a></li>
                            <li class="w50" style="text-align:center;"><a href="<?php echo routes::HOME_PATH . 'sobre' ?>"><i class="fa-solid fa-question"></i> Sobre</a></li>
                    <?php endswitch; ?>


                </ol>
                <ol class="flexColumn w50">
                    
                    <?php if (Controllers\userController::getSessionUserLogado() == null) :
                        switch (@routes::getLocalUrl()[1]):
                            case 'criar': ?>
                                <li><a style="outline: 2px solid white;" href="<?php echo routes::HOME_PATH . 'user/criar'; ?>"><i class="fa-solid fa-user-plus"></i> Criar Conta</a></li>
                                <li><a href="<?php echo routes::HOME_PATH . 'user/logar'; ?>"><i class="fa-solid fa-user"></i> Acessar com a sua Conta</a></li>
                            <?php break;
                            case 'logar': ?>
                                <li><a href="<?php echo routes::HOME_PATH . 'user/criar'; ?>"><i class="fa-solid fa-user-plus"></i> Criar Conta</a></li>
                                <li><a style="outline: 2px solid white;" href="<?php echo routes::HOME_PATH . 'user/logar'; ?>"><i class="fa-solid fa-user"></i> Acessar com a sua Conta</a></li>
                            <?php break;
                            default: ?>
                                <li><a href="<?php echo routes::HOME_PATH . 'user/criar'; ?>"><i class="fa-solid fa-user-plus"></i> Criar Conta</a></li>
                                <li><a href="<?php echo routes::HOME_PATH . 'user/logar'; ?>"><i class="fa-solid fa-user"></i> Acessar com a sua Conta</a></li>
                        <?php endswitch; ?>

                        <?php else :

                        if (@routes::getLocalUrl()[1] == 'conta') :
                        ?>
                            <li><a style="outline:2px solid white;" href="<?php echo routes::HOME_PATH . 'user/conta'; ?>"><i class="fa-solid fa-user"></i> <?php echo Controllers\userController::getSessionUserLogado()->getNomeUsuario() ?></a></li>
                        <?php else : ?>
                            <li><a href="<?php echo routes::HOME_PATH . 'user/conta'; ?>"><i class="fa-solid fa-user"></i> <?php echo Controllers\userController::getSessionUserLogado()->getNomeUsuario() ?></a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo routes::HOME_PATH . 'user/sair'; ?>"><i class="fa-solid fa-user-plus"></i> Sair</a></li>

                    <?php endif; ?>

                </ol>
            </nav>
        </div>

    </header>

    <section style="height:72%;margin-top:1%; overflow-y:auto; overflow-x:hidden; flex-wrap: nowrap;">