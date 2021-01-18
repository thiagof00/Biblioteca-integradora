<?php

// PÁGINA DE ALTERAÇÃO DE ADMs


    // Recebe o cpf do dito cujo
    @$id = $_GET['id'];
    
    include("../conecta.php");
    $tabela = "login";
    
    // Consulta o BD para obter os dados do dito cujo
    $sql = "SELECT * FROM $tabela WHERE id=".$id;
    $busca = mysqli_query($conexao,$sql);
    
    // Cria um array com os dados recebidos
    $dados = mysqli_fetch_assoc($busca);

?>
<!DOCTYPE html>

<html>
    <head>
        <title>Editar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link rel="stylesheet" href="../styles/css/change.css">
        <link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
        <script src = "../styles/js/olhinho.js"> </script>

        <title>Biblioteca Uruguaiana</title>
    </head>
    <body>

    <header> <a href="index.php"><img src="../styles/img/back.svg" id="img-back"></a> <h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>


    <main>

        <h1> Editar </h1>
        
            
            <form action="alterar.php" method="post">
                <h4> Dados da alteração </h4> 
                <input type="hidden" name="id" size="10" value="<?php echo $id; ?>">

                <div class="input">    
                    <input type="text" name="nome" size="50" maxlength="255"  required value="<?php echo $dados['usuario']; ?>">
                    <label>Email:</label>
                </div>
                <div class="input">
                    <input type="text" name="cpf" size="50" maxlength="11"  value="<?php echo $dados['senha']; ?>"> <label>Senha:</label>
                </div>

                <div class="input">
                    <input type="password" name="csenha" id="csenha" required>
                    <label >Confirmar Senha: </label>
                    <img onclick="myFunction()" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABDUlEQVQ4jd2SvW3DMBBGbwQVKlyo4BGC4FKFS4+TATKCNxAggkeoSpHSRQbwAB7AA7hQoUKFLH6E2qQQHfgHdpo0yQHX8T3exyPR/ytlQ8kOhgV7FvSx9+xglA3lM3DBgh0LPn/onbJhcQ0bv2SHlgVgQa/suFHVkCg7bm5gzB2OyvjlDFdDcoa19etZMN8Qp7oUDPEM2KFV1ZAQO2zPMBERO7Ra4JQNpRa4K4FDS0R0IdneCbQLb4/zh/c7QdH4NL40tPXrovFpjHQr6PJ6yr5hQV80PiUiIm1OKxZ0LICS8TWvpyyOf2DBQQtcXk8Zi3+JcKfNafVsjZ0WfGgJlZZQxZjdwzX+ykf6u/UF0Fwo5Apfcq8AAAAASUVORK5CYII="/> 
                </div>
                    <input type="submit" id="submit" value="Editar">
            </form>
        
        
        
        </main>
        <script src="../styles/js/alerts.js"></script>   
        <footer><a href="descprojeto.html"><img src="../styles/img/info.svg"></a> <div id ="footerText">
    Projeto de Extensão Biblioteca Integradora (PJO56-2020) - IFFar Campus Avançado Uruguaiana
</div></footer>
    </body>
</html>
<?php
    if($_POST){
        echo '<meta charset="UTF-8">';

        include("../conecta.php");

        //Recebe os dados do formulário
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $senha = $_POST["csenha"];
        $senha = $_POST['senha'];


        if($senha==$csenha){
            // Prepara o SQL e Insere no banco
            $sql = "UPDATE $tabela SET usuario=\"$nome\",senha=\"$csenha\"";
            mysqli_query($conexao, $sql);

            // Verifica o número de linhas afetas pelo último comando
            $linhasAfetadas = mysqli_affected_rows($conexao);

            // Se conseguiu alterar...
            if($linhasAfetadas > 0){
                sleep(3);
                header('Location: index.php');
            } else { // Senão...
                $erro = "Deu erro";
                sleep(3);
                echo "<div id='alert-error'>
                Algo deu errado, verifique e tente novamente!
                <div id='options'>
            <strong id='back'>alterar novamente</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
                </div>";
            }

        }
        else{
            echo "<h5> As senhas devem ser compativéis</h5> ";
        }
    }
?>