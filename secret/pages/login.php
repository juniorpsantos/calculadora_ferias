<?php
    @session_start();
    
    // check the jwt token and redirect to the home page
    if(isset($_SESSION['jwt'])){
        header('Location: /secret/dashboard');
    }
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Login</title>
</head>

<body>
    <main>
        <div class="container-login">
            <div class="content-box">
                <div class="content-box-login">
                    <h1>Login</h1>
                    <div class="form-box">
                        <form action="api/login.php" method="POST">
                            <div class="input-box">
                                <label for="email"><span>Email</span></label>
                                <input id="email" type="email" name="email" placeholder="@mail.com" required>
                            </div>
                            <div class="input-box">
                                <label for="senha"><span>Senha</span></label>
                                <input id="senha" type="password" name="senha" placeholder="senha" required>
                            </div>
                            <div class="remember">
                                <label>
                                    <input type="checkbox"> Lembrar de Mim
                                </label>
                                <a href="">Esqueceu a Senha?</a>
                            </div>
                            <div class="input-box">
                                <input type="submit" value="Entrar">
                            </div>
                            <div class="input-box">
                                <p>Não Tem Uma Conta? <a href="cadastro">Cadastrar</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="img-box">
                <img src="assets/img/login.svg" alt="">
            </div>
        </div>
    </main>
</body>

</html>