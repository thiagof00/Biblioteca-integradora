<!DOCTYPE html>
<html lang="pt=br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/css/main.css">
    <link rel="stylesheet" href="styles/css/login.css">
    <link rel="icon" type="imagem/png" href="styles/img/iconeuru.png" />
        <title>Biblioteca Uruguaiana</title>
</head>
<body>
    <!-- PÁGINA DE LOGIN -->
<?php

    // if para caso o acesso pela url tenha sido sem ter feito o login
        if(@$_GET["pego"]){
            echo "<h1 id='aviso'>Por favor realize o login de segurança!</h1>";
        }
        if ($_POST) {
            
            include("conecta.php");
            
            // Recebe os dados do formulário
            $usuario = $_POST['email'];
            $senha = $_POST['senha'];
            $tabela="login";
            
            // Prepara o SQL e consulta o banco de dados
            $sql = "SELECT * FROM $tabela WHERE usuario='$usuario' and senha='$senha'";
            $resultado = mysqli_query($conexao, $sql);
            
            // Verifica se retornou alguma coisa do banco...
            $verifica = mysqli_affected_rows($conexao);
            
            // Se retornou algo...
            if($verifica){
                session_start();
                $id = $resultado->fetch_assoc(); 

                $_SESSION['id'] = $id['id'];
                $_SESSION['logado'] = true;
                // Redireciona para a página de inicio
                header('location: menu.html');
            } else {
                // Senão...
                echo "<div id='alert-error'>
                
                Algo deu errado, verifique e tente novamente! 
                <div id='back'>(clique para fechar)</div>
                </div>";
            }}
    ?> 



<div class="img">
        <img src="styles/img/iconeuru.png" alt="bandeira Uruguaiana">
    </div>
    
    <form action="index.php" method="POST">
        <h1>BIBLIOTECA URUGUAIANA</h1>

        
        <div class="info">
            <div class="input">
                <input type="email" name="email" required>
                <label for="email">Email</label>
            </div>
            <div class="input">
                <input type="password" name="senha" required>
                <label for="senha">Senha</label>
            </div>

            <button type="submit">ENTRAR</button>
        </div>
    </form> 
        <script src="styles/js/alerts"></script>

</body>
</html> 