<?php

session_start();
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>"; // Display the alert
    unset($_SESSION['error']); // Clear the error message from session
}

// Verificando se o $_POST contem dados
if (!empty($_POST)) {
    include_once('config.php');

    // Limpando e validando os dados
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $sobrenome = mysqli_real_escape_string($conexao, $_POST['sobrenome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $celular = mysqli_real_escape_string($conexao, $_POST['celular']);
    $genero = mysqli_real_escape_string($conexao, $_POST['genero']);


    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $confirmacao = mysqli_real_escape_string($conexao, $_POST['confirmacao']);
    if ($senha !== $confirmacao) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error'] = "As senhas não são iguais!";
        // Redirect back to the form page
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

    // Use prepared statements to prevent SQL Injection
    $query = $conexao->prepare("INSERT INTO usuarios (nome, sobrenome, email, celular, senha, genero) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $nome, $sobrenome, $email, $celular, $hashedPassword, $genero);

    if ($query->execute()) {
        debug_to_console("Dados cadastrados com sucesso!");
        alert("Dados cadastrados com sucesso!");
        header('Location: /secret/');
    } else {
        alert("Ops! Houve um error ao tentar cadastrar os dados.");
        debug_to_console("Error: " . $query->error);
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link rel="stylesheet" href="assets/css/cadastro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="bg-[#004AAD]">

    <a href="/secret/" class="absolute top-4 left-4 text-3xl text-[#fff] hover:text-[#5bb4ff] transition-all">
        <i class="fas fa-chevron-left"></i>
    </a>
    <main class="flex justify-center items-center h-scree w-screen">
        <div class="w-[50%] flex justify-center items-center">
            <div class="w-[80%] flex flex-col justify-center align-start">
                <h1 class="text-[3em] font-bold text-[#fff]">
                    Cadastre-se
                </h1>
                <form action="/secret/cadastro" method="POST" class="flex flex-col bg-[#fff] p-8 rounded-lg">
                    <div class="input-box flex-row">
                        <div class="flex flex-col">
                            <label for="nome">Primeiro Nome</label>
                            <input id="nome" type="text" name="nome" value="<?php echo isset($_SESSION['form_data']['nome']) ? htmlspecialchars($_SESSION['form_data']['nome']) : ''; ?>" placeholder="Digite seu primeiro nome" required>
                        </div>

                        <div class="flex flex-col">
                            <label for="sobrenome">Sobrenome</label>
                            <input id="sobrenome" type="text" name="sobrenome" value="<?php echo isset($_SESSION['form_data']['sobrenome']) ? htmlspecialchars($_SESSION['form_data']['sobrenome']) : ''; ?>" placeholder="Digite seu sobrenome" required>
                        </div>
                    </div>

                    <div class="input-box flex-row">
                        <div class="flex flex-col">

                            <label for="email">E-mail</label>
                            <input id="email" type="email" name="email" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['nome']) : ''; ?>" placeholder="Digite seu e-mail" required>
                        </div>

                        <div class="flex flex-col">

                            <label for="celular">Celular</label>
                            <input id="celular" type="tel" name="celular" value="<?php echo isset($_SESSION['form_data']['celular']) ? htmlspecialchars($_SESSION['form_data']['nome']) : ''; ?>" placeholder="(xx) xxxx-xxxx" required>
                        </div>
                    </div>

                    <div class="input-box flex-row">
                        <div class="flex flex-col">
                            <label for="senha">Senha</label>
                            <input id="senha" type="password" name="senha" placeholder="Digite sua senha" required>
                        </div>

                        <div class="flex flex-col">
                            <label for="confirmacao">Confirme sua Senha</label>
                            <input id="confirmacao" type="password" name="confirmacao" placeholder="Digite sua senha novamente" required>
                        </div>
                    </div>

                    <div class="gender-inputs">
                        <div class="gender-title">
                            <h6>Gênero</h6>
                        </div>

                        <div class="gender-group">
                            <div class="gender-input">
                                <input id="female" type="radio" name="genero" value="F" <?php echo (isset($_SESSION['form_data']['genero']) && $_SESSION['form_data']['genero'] == 'F') ? 'checked' : ''; ?>>
                                <label for="female">Feminino</label>
                            </div>

                            <div class="gender-input">
                                <input id="male" type="radio" name="genero" value="M" <?php echo (isset($_SESSION['form_data']['genero']) && $_SESSION['form_data']['genero'] == 'M') ? 'checked' : ''; ?>>
                                <label for="male">Masculino</label>
                            </div>

                            <div class="gender-input">
                                <input id="others" type="radio" name="genero" value="O" <?php echo (isset($_SESSION['form_data']['genero']) && $_SESSION['form_data']['genero'] == 'O') ? 'checked' : ''; ?>>
                                <label for="others">Outros</label>
                            </div>

                            <div class="gender-input">
                                <input id="none" type="radio" name="genero" value='N' <?php echo (isset($_SESSION['form_data']['genero']) && $_SESSION['form_data']['genero'] == 'N') ? 'checked' : ''; ?>>
                                <label for="none">Prefiro não dizer</label>
                            </div>
                        </div>
                    </div>

                    <div class="continue-button">
                        <input type="submit" value="Continuar">
                    </div>
                </form>
            </div>
        </div>
        <div class="w-1/2 flex justify-start items-start">
            <img src="assets/img/undraw_shopping_re_3wst.svg" alt="" class="w-[95%] h-[100%] object-cover">
        </div>
    </main>
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>