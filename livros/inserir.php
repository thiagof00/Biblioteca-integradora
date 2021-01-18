<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link rel="stylesheet" href="../styles/css/forms.css">
        
        <link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
        <title>Biblioteca Uruguaiana</title>
        
     
</head>
<!-- PAGINA DE INSERIR LIVROS NO SISTEMA -->
 
<body>

<?php
        session_start();
        if($_SESSION["logado"]==false){
                header("location: ../index.php?pego=sim");
        }
    if ($_POST) {
            
    include("../conecta.php");
        

        // Recebe os dados do formulário
        $nomel = $_POST["nomel"];
        $codigo = $_POST["cod_livro"];
        $genero= $_POST["genero"];
        $autor= $_POST["autor"];
        $ano= $_POST["ano"];
        $emestoque= $_POST["emestoque"];
        $local= $_POST["local"];

        //testar se há um livro no banco com o mesmo código
        $sql = "SELECT cod_livro FROM livros where cod_livro=\"$codigo\" ";
        $teste = mysqli_query($conexao, $sql);
        $teste = $teste->fetch_assoc();

        if($teste==null){
                // Prepara o SQL e Insere no banco
                $sql = "INSERT INTO livros (nomel,cod_livro, genero, autor, ano, emestoque, locali) VALUES (\"$nomel\",\"$codigo\",\"$genero\",\"$autor\",\"$ano\",\"$emestoque\",\"$local\" )";
                mysqli_query($conexao, $sql);

                // Verifica o número de linhas afetadas pelo último comando
                $linhasAfetadas = mysqli_affected_rows($conexao);


                // Se conseguiu inserir...
                if ($linhasAfetadas > 0) {
                echo "<div id='alert-item'>
                O livro $nomel foi registrado com sucesso! 
                <div id='options'>
                <strong id='back'>Registrar outro livro</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
                </div> ";
                sleep(2);
                }
                else { // Senão...    
                        echo "<div id='alert-error'>
                        Algo deu errado, verifique e tente novamente!
                        <strong id='back'>Registrar outro livro</strong>
                        </div>";
                        }
        }
        else{echo "<div id='alert-error'>
                Algo deu errado, já existem um livro cadastrato com esse código, verifique e tente novamente!
                <strong id='back'>Registrar outro livro</strong>
                </div>";}

        }
            ?>

<header> <a href="index.php"><img src="../styles/img/back.svg" id="img-back"></a> <h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>

<main>
        <h2><strong>Formulário de Registro de Livros</h2></strong>

            <form action="inserir.php" method="post">
                <!--Dados Livro-->
           

            <br>
        <div class="info">
            <h4>Dados do Livro:</h4>
           
       
             

    <div class="input">
            <input autofocus type="text" name="nomel" rows="5" size="50" maxlength="255" required > 
            <label> Nome do livro </label>
    </div>

    <div class="input">
      
            <input type="text" name="ano" rows="5"  size="50" maxlength="255"  required>
            <label> Ano </label>
    </div>

    <div class="input">
      
            <input type="text" name="cod_livro" rows="5"  size="50" maxlength="255" required >
            <label> Código do Livro</label>
    </div>

    <div class="input">
      
            <input type="text" name="genero" rows="5" size="50"  maxlength="255" >
            <label> Gênero </label>
    </div>

    <div class="input">
      
            <input type="text" name="autor" rows="5"  size="50" maxlength="255" required>
            <label> Autor </label>
    </div>

    <div class="input">
      
            <input type="text" name="emestoque" size="50" maxlength="255" required>
            <label> Quantidade de exemplares </label>
    </div>

    <div class="input">
      
            <input type="text" name="local" size="50" maxlength="255" required>
            <label> Seção / Prateleira </label>
    </div>
   
<button type="submit" id="submit"> Enviar</button>
    </div>
    
        
        </form>  
</main>
          <script src="../styles/js/alerts.js">
          
          </script>

<footer><a href="descprojeto.html"><img src="../styles/img/info.svg"></a> <div id ="footerText">
    Projeto de Extensão Biblioteca Integradora (PJO56-2020) - IFFar Campus Avançado Uruguaiana
</div></footer>
</body>
</html>
            