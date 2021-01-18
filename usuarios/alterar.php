<?php
    
        session_start();
        if($_SESSION["logado"]==false){
            header("location: ../index.php?pego=sim");
        }
        // Recebe o cpf do dito cujo
        $id = $_GET['id'];
        
        include("../conecta.php");
        
        // Consulta o BD para obter os dados do dito cujo
        $sql = 'SELECT * FROM leitores WHERE id='.$id;
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
        <script type="text/javascript" src="../styles/js/jquery-3.4.1.js"></script>
        <script type="text/javascript" src="../styles/js/jquery.mask.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){ 
        
        $('#cpf').mask('999.999.999-99');
        $('#cel').mask('(99) 99999-9999');
        })
        </script>  
        <title>Biblioteca Uruguaiana</title>
    </head>
    <body>

    <!-- PÁGINA DE ALTERAÇÃO DE USUÁRIOS -->

    <header> <a href="index.php"><img src="../styles/img/back.svg" id="img-back"></a> <h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>


    <main>

        <h1> Editar dados: </h1>
        
            
            <form action="alterar.php?id=<?php echo $id; ?>" method="post">
                <h4> Dados da alteração: </h4> 
                <input type="hidden" name="id" size="10" value="<?php echo $id; ?>">

           
            <div class="input">
                    <input type="text" name="errege" size="50"  maxlength="10"  value="<?php echo $dados['rg']; ?>"> <label>RG:</label>

            </div>
            <div class="input">    
                <input type="text" name="nome" size="50" maxlength="255"  required value="<?php echo $dados['nome']; ?>">
                <label>Nome:</label>
            </div>


            <div class="input">
                <input id="cpf" type="text" name="cpf" size="50" maxlength="15"  value="<?php echo $dados['cpf']; ?>"> <label>CPF:</label>

            </div>

            <div class="input">
                <input type="text" name="endereco" size="50" maxlength="255" value="<?php echo $dados['endereco']; ?>"> <label>Endereço:</label>
            </div>

            <div class="input">
              <input id="cel" type="text" name="telefone" size="50" maxlength="255"  required value="<?php echo $dados['fone']; ?>" ><label>Telefone:</label>
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
        $cpf = $_POST["cpf"];
        $errege = $_POST["errege"];
        $fone = $_POST["telefone"];
        $endereco = $_POST["endereco"];

        // Prepara o SQL e Altera no banco
        $sql = "UPDATE leitores SET  rg=\"$errege\",nome=\"$nome\",endereco=\"$endereco\", fone=\"$fone\", cpf=\"$cpf\" WHERE id=".$id;
        mysqli_query($conexao,$sql);

        // Verifica o número de linhas afetas pelo último comando
        $linhasAfetadas = mysqli_affected_rows($conexao);
        var_dump($linhasAfetadas);

        // Se conseguiu alterar...
        if($linhasAfetadas > 0){
            sleep(3);   
            header("location: index.php");
        } 
        else { // Senão...
            sleep(3);
            echo "<div id='alert-error'>
            Algo deu errado, verifique e tente novamente!
            <div id='options'>
        <strong id='back'></a>alterar novamente</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
            </div>";
        }
    }
?>