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

<!-- PÁGINA PRINCIPAL DE USUÁRIOS -->

<?php
if(@$_GET["deleted"]){
      echo "<div id='alert-item'>
              Excluído com sucesso!
      <div id='back'>(clique para fechar)</div>
      </div>";
    }
?>
    <header><a href="../menu.html"><img src="../styles/img/back.svg" id="img-back"> </a><h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>

    <main>
    
        <div class="routes">
        <a href="cadastrar.php"><img src="../styles/img/usuario.svg"  alt=""></a>
        </div>

        <h2>Lista de leitores cadastrados</h2>

        <form action="../components/select.php" method="get">
            <div class="searchs">
                <input id="cpf" type="text" name="codigo" placeholder="Pesquisar pelo CPF..."></input>
                <input type="hidden" value=leitores name='tabela' ></input>
                <input type="hidden" value=cpf name='coluna' ></input>
                <input type="hidden" value=<?php echo"s,id,RG,Nome,CPF,Endereco,Telefone,Opções";?> name='dados' ></input>
                <input type="submit" value="enviar">
            </div>
        </form>
        <?php
            session_start();
            if($_SESSION["logado"]==false){
                header("location: ../index.php?pego=sim");
            }
            include("../components/tabela.php");
            if (@$_GET['pagina']) {
                $pagina = $_GET['pagina'];
            }
            else {
                $pagina = 1;
            }
            
            $dados = ["id","RG","Nome","CPF","Endereço","Telefone","Opções"];
            echo(tabela("leitores",$dados,"*",null,$pagina));

        ?>
        
        <footer><a href="descprojeto.html"><img src="../styles/img/info.svg"></a> <div id ="footerText">
    Projeto de Extensão Biblioteca Integradora (PJO56-2020) - IFFar Campus Avançado Uruguaiana
</div></footer>
        </main>

<script src="../styles/js/alerts.js"></script>

</body>
</html>