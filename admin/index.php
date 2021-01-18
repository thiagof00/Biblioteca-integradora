<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/css/main.css">
    <link rel="stylesheet" href="../styles/css/main-users.css">
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
<body>
    <!-- PÁGINA PRINCIPAL DE ADMs -->
    <header><a href="../menu.html"><img src="../styles/img/back.svg" id="img-back"> </a><h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>

    <main>
        <div class="routes">
            <a href="cadadm.php"><img src="../styles/img/usuario.svg"  alt=""></a>

        </div>
        
  
<?php
        

        include("../components/tabela.php");
        $dados = ["id","Usuário","Senha","Opções"];
        if (@$_GET['pagina']) {
            $pagina = $_GET['pagina'];
        }
        else {
            $pagina = 1;
        }
        session_start();
        if($_SESSION['id']==1){
        echo(tabela("login",$dados,"*",null,$pagina));}
        else{echo(tabela("login",$dados,"id",$_SESSION['id'],$pagina));}

        ?>
        
        
    </main>

    <footer><a href="descprojeto.html"><img src="../styles/img/info.svg"></a> <div id ="footerText">
    Projeto de Extensão Biblioteca Integradora (PJO56-2020) - IFFar Campus Avançado Uruguaiana
</div></footer>

    <script src="../styles/js/backgroundDatasOfTables.js"></script>
    </body>
</html>
