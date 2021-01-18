<?php
    session_start();
    if($_SESSION["logado"]==false){
        header("location: ../index.php?pego=sim");
    }
 include("../conecta.php");
    // Recebe o id do dito cujo
    @$id = $_GET['id'];
    if(@$_GET['erro']){
        echo "<h1 id=down>deu erro</h1>";
    }
    // Consulta o BD para obter os dados do dito cujo
    $sql = 'SELECT * FROM livros WHERE id='.$id;
    $busca = mysqli_query($conexao,$sql);
    
    // Cria um array com os dados recebidos
    $dados = mysqli_fetch_assoc($busca);?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <title>Editar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link rel="stylesheet" href="../styles/css/change.css">
        <link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
        <title>Biblioteca Uruguaiana</title>
    </head>
    <body>

    <!-- PÁGINA DE ALTERAÇÃO DE LIVROS -->

    <header> <a href="index.php"><img src="../styles/img/back.svg" id="img-back"></a> <h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>

        
     <main>   
            
        <h1 > Editar dados:</h1>

            
            <form action="alterar.php" method="post">
            <h4> Dados da alteração: </h4> 


                <input type="hidden" name="id" size="10" value="<?php echo $id; ?>">

                <div class="input">

                
                <input type="text" name="nomel" size="50" maxlength="255"  required value="<?php echo $dados['nomel']; ?>">
                <label>Nome</label>
                </div>

                <div class="input">
      
                <input type="text" name="cod_livro" size="50" maxlength="255" required value="<?php echo $dados['cod_livro']; ?>">
                <label> Código do Livro</label>
                </div>
                

                <div class="input">
                <input type="text" name="genero" size="50" maxlength="255"  value="<?php echo $dados['genero']; ?>"> <label>Gênero</label>

                </div>

                <div class="input">
                <input type="text" name="autor" size="50" maxlength="255"  required value="<?php echo $dados['autor']; ?>" ><label>Autor</label>
                
                </div>

                <div class="input">
                <input type="text" name="ano" size="50" maxlength="4" value="<?php echo $dados['ano']; ?>"> <label>Ano</label>

                </div>

                <div class="input">
                <input type="text" name="emestoque" size="50" maxlength="4" value="<?php echo $dados['emestoque']; ?>"> 
                <label>Quantidade de exemplares</label>
                </div>

                <div class="input">

                <input type="text" name="local" size="50" maxlength="4" value="<?php echo $dados['locali']; ?>"> 
                <label>Local</label>
                
                </div>
                
                
                <input type="submit" value="Editar" id="submit">
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
$nomel = $_POST["nomel"];
$genero = $_POST["genero"];
$ano = $_POST["ano"];
$autor = $_POST["autor"];
$emestoque= $_POST["emestoque"]; 
$local=$_POST["local"];
$cod_livro = $_POST["cod_livro"];

// Prepara o SQL e Altera no banco
$sql = "UPDATE livros SET nomel=\"$nomel\",cod_livro=\"$cod_livro\", genero=\"$genero\", ano=\"$ano\", autor=\"$autor\", emestoque=\"$emestoque\", locali=\"$local\"  WHERE id=".$id;
mysqli_query($conexao,$sql);
// Verifica o número de linhas afetas pelo último comando
$linhasAfetadas = mysqli_affected_rows($conexao);

// Se conseguiu alterar...
if($linhasAfetadas > 0){
    sleep(3);
    header('Location: index.php');
} else { // Senão...
    $erro = "Deu erro";
    sleep(2);
    echo "<div id='alert-error'>
    Algo deu errado, verifique e tente novamente!
    <div id='options'>
<strong id='back'>alterar novamente</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
    </div>";
}
}
?>