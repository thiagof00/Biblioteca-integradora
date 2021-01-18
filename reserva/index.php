<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/css/main.css">
    <link rel="stylesheet" href="../styles/css/main-reserved.css">
    <link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
        <title>Biblioteca Uruguaiana</title>
    <script type="text/javascript" src="../styles/js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../styles/js/jquery.mask.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){$('#cpf').mask('999.999.999-99');})
    </script>
        
</head>
<body>

<!-- PÁGINA PRINCIPAL DE RESERVAS -->

<?php
if(@$_GET["deleted"]){
    echo "<div id='alert-item'>
            A reserva foi excluída.
    <div id='back'>(clique para fechar)</div>
    </div>";
  }

?>

    <header><a href="../menu.html"><img src="../styles/img/back.svg" id="img-back"> </a><h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>

    <main id="main">
            
            <input type="hidden" name="diaE">
            <input type="hidden" name="mesE">
            <script src="../styles/js/Dates.js"></script>
            <div class="r"><div class="routes">
                <a href="cadastrar.php"><img src="../styles/img/add.svg"></a>
            </div> 
            <div class="routes">
            <a href="historico.php"><img src="../styles/img/history.svg" alt="historico"></a>
            </div> </div>
            
        <h2>Lista de reservas cadastradas</h2>
        <form action="../components/select.php?tabela=reservas" method="get">
        <div class="searchs">
            <input id="cpf" type="text" name="codigo" placeholder="Pesquisar pelo CPF..."></input>
            <input type="hidden" value=reservas name='tabela' ></input>
            <input type="hidden" value=id_leitores name='coluna' ></input>
            <input type="hidden" value=<?php echo"r,id,Retirada,Entrega,Leitor,Livro,Opções";?> name='dados' ></input>
           <input type="submit" value="enviar">
        </div>
            </form>
            
        <?php
            session_start();
            if($_SESSION["logado"]==false){
                header("location: ../index.php?pego=sim");
            }
            if (@$_GET['pagina']) {
                $pagina = $_GET['pagina'];
            }
            else {
                $pagina = 1;
            }
            include("../components/tabela.php");
            $dados = ["r","id","Retirada","Entrega","Leitor","Livro","Opções"];
            echo(tabela("reservas",$dados,"*",null,$pagina));
        ?>    
        <footer><a href="descprojeto.html"><img src="../styles/img/info.svg"></a> <div id ="footerText">
    Projeto de Extensão Biblioteca Integradora (PJO56-2020) - IFFar Campus Avançado Uruguaiana
    </div></footer>
    </main>
    
    <script src="../styles/js/alerts.js"></script>
    
</body>
</html>
