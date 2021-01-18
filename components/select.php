<!-- ARQUIVO QUE FAZ O TRABALHO DE SELEÇÃO DO SISTEMA -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/css/main.css">
    <link rel="stylesheet" href="../styles/css/main-users.css">
    <script src="js/biblio.js"></script>
    <link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
        <title>Biblioteca Uruguaiana</title>
</head>
<body>
    


    <main>
  
   
<?php
    session_start();
    if($_SESSION["logado"]==false){
        header("location: ../index.php?pego=sim");
    }
    include("../components/tabela.php");
    include("../conecta.php");
    
        $coluna=$_GET["coluna"];
        $codigo=$_GET["codigo"];
        $tabela=$_GET["tabela"];
        $dados =$_GET["dados"];

        if($coluna=="nomel" or $coluna=="autor"){
            $codigo2=str_split($codigo);
            $c = count($codigo2);
            unset($codigo);
            $codigo[0]="%";
            $codigo[1]="_";
            for ($i=2; $i <= $c; $i++) { 
                $codigo[$i]=$codigo2[$i-1];
            }
            $codigo[]="%";
            $codigo = implode("",$codigo);   
        }
        switch ($tabela) {
            case 'livros':
                echo" <header><a href='../livros/index.php'><img src='../styles/img/back.svg' id='img-back'> </a><h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>'";
            break;
            case 'leitores':
                echo" <header><a href=../usuarios/index.php><img src='../styles/img/back.svg' id='img-back'> </a><h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>'";
            break;
            default:
            echo" <header><a href='../reserva/index.php'><img src='../styles/img/back.svg' id='img-back'> </a><h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> </header>";
            break;
        }

        $dados = explode(",",$dados);

        if($dados[0]=="r"){
            $sql = "SELECT * FROM leitores WHERE cpf = \"$codigo\"";
                $resultado = mysqli_query($conexao, $sql);
            $id = $resultado->fetch_assoc();
            $codigo=$id['id'];
            
        }  
        if (@$_GET['pagina']) {
            $pagina = $_GET['pagina'];
        }
        else {
            $pagina = 1;
        }
         
        echo(tabela($tabela,$dados,$coluna,$codigo,$pagina));
?>
       
    </main>
    </body>
</html>
