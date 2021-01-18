<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/css/main.css">
    <link rel="stylesheet" href="../styles/css/forms.css">
    <link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
    <script src = "../styles/js/olhinho.js"> </script>
    <title>Biblioteca Uruguaiana</title>
</head>
<body>

<!-- PÁGINA DE CADASTRO DE ADMs -->
    <header><a href="index.php"><img src="../styles/img/back.svg" id="img-back"> </a> <h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> 
    </header>
    
    <main>       
        <strong><h2>Cadastrar novo administrador</h2></strong>
            
        <form action="cadadm.php" method="POST">
            <div class="input">
                <input type="text" name="nome" id="nome" required> 
                <label> Email: </label> 
            </div>

            <div class="input">
                <input type="password" id="senha" name="senha" size="16" required>
                <label> Senha: </label>
            </div>

            <div class="input">
                <input type="password" name="csenha" id="csenha" required>
                <img onclick="myFunction()" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII="/> 
                <label >Confirmar senha: </label>
            </div>
                
            <div>
                <button type="submit" id="submit">Cadastrar</button>
            </div>
        </form> 
    </main>
<?php
        if ($_POST) {
            
            include("../conecta.php");

            // Recebe os dados do formulário
            $nome = $_POST["nome"];
            $senha = $_POST["senha"];
            $csenha = $_POST["csenha"];
            $tabela="login";

            $sql = "SELECT * FROM $tabela WHERE usuario=\"$nome\"";
            $teste = mysqli_query($conexao, $sql);
            $teste = mysqli_num_rows($teste);

            if($teste==0){
            if($senha==$csenha){
            

                // Prepara o SQL e Insere no banco
                $sql = "INSERT INTO $tabela (usuario, senha) VALUES (\"$nome\", \"$csenha\")";
                mysqli_query($conexao, $sql);

                // Verifica o número de linhas afetadas pelo último comando
                $linhasAfetadas = mysqli_affected_rows($conexao);

                // Se conseguiu inserir...
                if ($linhasAfetadas > 0) {
                    sleep(3);
                    header("location: index.php");
                } else { // Senão...    
                    echo "<h5> Houve um erro ao registrar usuario </h5> ";
                }
            
            }
            else{
                echo "<h5> As senhas devem ser compativéis</h5> ";
            }
        } 
        else{echo "Email já cadastrado tente outro";}
    }
        ?>
        
        
    </body>
</html>