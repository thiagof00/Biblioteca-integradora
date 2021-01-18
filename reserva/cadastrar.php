<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link rel="stylesheet" href="../styles/css/forms.css">
                <script type="text/javascript" src="../styles/js/jquery-3.4.1.js"></script>
                <script type="text/javascript" src="../styles/js/jquery.mask.min.js"></script>
                <script type="text/javascript">
                        $(document).ready(function(){ 
                        
                        $('#cpf').mask('999.999.999-99');
                        
                        
                        
                        })
                        </script>  

<link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
        <title>Biblioteca Uruguaiana</title>
        
</head>
   <!-- PAGINA DE CADASTRO DE RESERVAS NO SISTEMA -->
<body>
<?php
        session_start();
        if($_SESSION["logado"]==false){
                header("location: ../index.php?pego=sim");
        }
    if ($_POST) {
            
    include("../conecta.php");
        

        // Recebe os dados do formulário
        $cod_livro = $_POST["cod_livro"];
        $cpf = $_POST["cpf"];
        $data = $_POST["data"];

        //Pega a data do dia ATUAL
        date_default_timezone_set('America/Sao_Paulo');
        $l=date('d/m/y');
        
        //tira os numeros do seculo da data de entrega ex: 2021 = 21
        $da=explode("-",$data);
        $datahoje=[$da[2],$da[1],$da[0]];
        $anoSeperado=str_split($datahoje[2]);
        $ano = [$anoSeperado[0],$anoSeperado[1]];
        $ano=implode("",$ano);
        $dataEint=[$da[2],$da[1],$ano];
        // g = dia/mes/ano DATA DE ENTREGA QUE VEM DO FORMULARIO
        $dataE=implode("/",$dataEint);

        //pega a informação que tem no estoque
        $sql = "SELECT emestoque FROM livros  WHERE cod_livro=".$cod_livro;
        $resultado = (mysqli_query($conexao,$sql));
        $dados = $resultado->fetch_assoc();
        $a= $dados['emestoque'];
        if($dados['emestoque']>0){
                $sql = "SELECT id FROM livros where cod_livro = \"$cod_livro\"";
                        $livros = mysqli_query($conexao, $sql);
                $sql = "SELECT id FROM leitores where cpf = \"$cpf\"";
                        $leitores = mysqli_query($conexao, $sql);

                $id_livros = $livros->fetch_assoc(); 
                $id_leitores = $leitores -> fetch_assoc();

                $id1=$id_livros["id"];
                $id2=$id_leitores["id"];

                // Prepara o SQL e Insere no banco
                $sql = "INSERT INTO reservas (id_livros,id_leitores,datasr, dataret) VALUES (\"$id1\",\"$id2\",\"$dataE\",\"$l\")";
                mysqli_query($conexao, $sql);
                
        
                // Verifica o número de linhas afetadas pelo último comando
                $linhasAfetadas = mysqli_affected_rows($conexao);
                

                // Se conseguiu inserir...
                if ($linhasAfetadas > 0) {
                        //pega a informação que tem no estoque
                        $sql = "SELECT emestoque FROM livros  WHERE id=".$id1;
                        $resultado = (mysqli_query($conexao,$sql));
                        $dados = $resultado->fetch_assoc();
                        $a= $dados['emestoque']-1;
                        //atualiza a quantidade
                        $sql = "UPDATE livros SET emestoque=\"$a\" WHERE id=".$id1;
                        mysqli_query($conexao,$sql);
                        echo "<div id='alert-item'>
                a reserva com o cpf $cpf foi um feita com sucesso! 
                <div id='options'>
                <strong id='back'>Registrar outra reserva</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
                </div> ";
                sleep(2);
                }
                else { // Senão...    
                        echo "<div id='alert-error'>
                        Algo deu errado, verifique e tente novamente!
                        <div id='options'>
                <strong id='back'>Registrar outra reserva</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
                        </div> ";
                        }
        }
        else{echo"não ah esse livro em estoque no momento";}

        }
            ?> 

<header> <a href="index.php"><img src="../styles/img/back.svg" id="img-back"></a> <h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>

<main>
        <h2><strong>Formulário de reserva</h2></strong>

            <form action="cadastrar.php" method="post">
                <!--Dados Livro-->
           

           
        <div class="info">
            <h4>Dados da reserva:</h4>
           
       
             

    <div class="input">
            <input autofocus type="text" name="cod_livro" rows="5" size="50" maxlength="255" required > 
            <label> Código do livro (CDD)</label>
    </div>
    
    <div class="input">
      
            <input id="cpf" type="text" name="cpf" rows="5"  size="50" maxlength="255" required>
            <label> CPF do leitor (somente números) </label>
    </div>

    <div class="input">
      
            <input type="date" name="data" size="11" maxlength="255">
            <label> Data de Entrega (Fim) </label>
    </div>

   
<button type="submit" id="submit"> Enviar </button>
    </div>
    
        
        </form>  
</main>
<script src="../styles/js/alerts.js"> </script>

<footer><a href="descprojeto.html"><img src="../styles/img/info.svg"></a> <div id ="footerText">
    Projeto de Extensão Biblioteca Integradora (PJO56-2020) - IFFar Campus Avançado Uruguaiana
</div></footer>
</body>
</html>

