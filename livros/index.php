  <?php
    session_start();
    if($_SESSION["logado"]==false){header("location: ../index.php?pego=sim");}
    if(@$_GET["deleted"]){
      echo "<div id='alert-item'>
              O livro foi excluído.
      <div id='back'>(clique para fechar)</div>
      </div>";
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/css/main.css">
    <link rel="stylesheet" href="../styles/css/main-books.css">
    <link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
        <title>Biblioteca Uruguaiana</title>
        <script src="../styles/js/modal.js">
          
          </script>
</head>
       <!-- PAGINA PRINCIPAL DOS LIVROS -->
<body>
  
     <header><a href="../menu.html"><img src="../styles/img/back.svg" id="img-back"> </a><h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>

    <main>

            <div class="routes">
                    <a href="inserir.php"><img src="../styles/img/add-book.svg"></a>
                

            </div>


                <h2>Lista de livros cadastrados</h2>

<div class="forms">

<form action="../components/select.php" method="get">
                <div class="searchs">
                
        <input type="hidden" value=cod_livro name='coluna' ></input>
            <input type="hidden" value=livros name='tabela' ></input>
            <input type="hidden" value=<?php echo"s,id,Livro,Código,Gênero,Autor,Ano,Disponíveis,Local,Opções";?> name='dados' ></input>
            <input type="text" name="codigo" placeholder="Pesquisar pelo código..." ></input>
            
            <input type="submit" value="enviar">
                </div> 
</form>

    <!-- codigo -->
   

          <!-- Livro -->
            <form action="../components/select.php" method="get" name="caseNome">
            <div class="searchs">

           
            <input type="text" name="codigo" placeholder="Pesquisar pelo nome..." ></input>
            <input type="hidden" value=livros name='tabela' ></input>
            <input type="hidden" value=nomel name='coluna' ></input>    
            <input type="hidden" value=<?php echo"s,id,CDD,Livro,Autor,Gênero,Ano,Disponíveis,Local,Opções";?> name='dados' ></input>
            
           <input type="submit" value="enviar">
            </div> 
            </form>
            
            <!-- ano -->
             <form action="../components/select.php" method="get" name="caseAno">
             <div class="searchs">


            <input type="text" name="codigo" placeholder="Pesquisar pelo ano..." ></input>
            <input type="hidden" value=livros name='tabela' ></input>
            <input type="hidden" value=ano name='coluna' ></input>    
            <input type="hidden" value=<?php echo"s,id,Código,Livro,Autor,Gênero,Ano,Disponíveis,Local,Opções";?> name='dados' ></input>
            <input type="submit" value="enviar">
          </div>
            </form> 
           
            <!-- autor -->
             <form action="../components/select.php" method="get" name="caseAutor">
             <div class="searchs">
               <input type="text" name="codigo" placeholder="Pesquisar pelo autor..." ></input>
            <input type="hidden" value=livros name='tabela' ></input>
            <input type="hidden" value=autor name='coluna' ></input>    
            <input type="hidden" value=<?php echo"s,id,Código,Livro,Autor,Gênero,Ano,Disponíveis,Local,Opções";?> name='dados' ></input>
            <input type="submit" value="enviar">
             </div>
            </form> 
           
             <!-- Genero -->
            <form action="index.php" method="get" id="pesquisar_genero">
              <div class="searchs">

              
     
            <input type="text" name="genero" id="genero" placeholder="Pesquisar por gênero"></input>
            
            <input type="submit" value="enviar"> 
             <?php
                 if(@$_GET['genero'])
                    {
                     echo ("<button class='btnsearch' name='enviar'type='submit' value='Todos' form='pesquisar_genero'>Voltar para todos</button>");
                   }
                ?>
            </div>
            </form>
            
</div>

  <?php
    if(@$_GET['genero']){
      $b=$_GET['genero'];
        $a="genero";
    }
    else{$a="*"; $b=null;}

    include("../components/tabela.php");
    if (@$_GET['pagina']) {
      $pagina = $_GET['pagina'];
    }
    else {
      $pagina = 1;
    }
    $dados = ["id","CDD","Livro","Autor","Gênero","Ano","Em estoque","Local","Opções"];
    echo(tabela("livros",$dados,$a,$b,$pagina));
        //$tabela,$dados,$coluna,$codigo
    
    
  ?>
  
    <footer><a href="descprojeto.html"><img src="../styles/img/info.svg"></a> <div id ="footerText">
    Projeto de Extensão Biblioteca Integradora (PJO56-2020) - IFFar Campus Avançado Uruguaiana
</div></footer>          
    </main>
    

    
        
    <script src="../styles/js/alerts.js"></script>
</body>
</html>
