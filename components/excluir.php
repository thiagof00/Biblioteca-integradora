<link rel="stylesheet" href="../styles/css/main.css">  
<?php

// ARQUIVO QUE FAZ TODAS AS TAREFAS DE EXLUIR DO SISTEMA

    session_start();
    if($_SESSION["logado"]==false){
    header("location: ../index.php?pego=sim");
    }

    include("../conecta.php"); 
    echo '<meta charset="UTF-8">';

    //caso especial de reserva
    if(@$_GET['id_livros']){
    $tabela = $_GET["tabela"];
    $id_livros = $_GET["id_livros"];
    $id = $_GET["id"];

    $sql = "SELECT nomel FROM livros WHERE id = \"$id_livros\"";
    $nomel = mysqli_query($conexao,$sql);
    $nomel = $nomel -> fetch_assoc();
    $nomel = $nomel['nomel'];

    $sql = "SELECT datasr,dataret FROM $tabela WHERE id = \"$id\"";
    $data = mysqli_query($conexao,$sql);
    $data = $data -> fetch_assoc();
    $datasr = $data['datasr'];
    $dataret = $data['dataret'];

    $sql = "SELECT id_leitores FROM $tabela WHERE id = \"$id\"";
    $id_leitores = mysqli_query($conexao,$sql);
    $id_leitores = $id_leitores -> fetch_assoc();
    $id_leitores = $id_leitores['id_leitores'];


    $sql = "SELECT nome FROM leitores WHERE id = \"$id_leitores\"";
    $nome = mysqli_query($conexao,$sql);
    $nome = $nome -> fetch_assoc();
    $nome = $nome['nome'];

    //pega a informação que tem no estoque
    $sql = "SELECT emestoque FROM livros WHERE id= \"$id_livros\"";
    $resultado = mysqli_query($conexao,$sql);
    $dados = $resultado->fetch_assoc();
    $a = $dados['emestoque']+1;
    //atualiza a quantidade
    $sql = "UPDATE livros SET emestoque=\"$a\" WHERE id= \"$id_livros\"";
    mysqli_query($conexao,$sql);
    $linhasAfetadas = mysqli_affected_rows($conexao);

    // Se conseguiu transferir...
    if($linhasAfetadas > 0){
        echo "<div id='alert-item'>
        Excluído com sucesso !
        </div> ";

        // Prepara o SQL e  do banco
        $sql = "INSERT INTO historico (datasr, dataret, leitores, livros) VALUES (\"$datasr\",\"$dataret\",\"$nome\",\"$nomel\")"; 
        mysqli_query($conexao,$sql);
        //Verifica o número de linhas afetadas pelo último comando
        $linhasAfetadas = mysqli_affected_rows($conexao);
        if($linhasAfetadas > 0){
            $sql = "DELETE FROM reservas WHERE id=".$id;
            mysqli_query($conexao,$sql);
        }
        sleep(2);
        header("location: ../reserva");
    } 

    else { // Senão...
        echo "<h3> Houve um erro ao finalizar reserva. </h3> ";
        echo "<hr>";

    }  

    }
    else{
    // livros e leitores
    $id = $_GET["id"];
    $tabela = $_GET["tabela"];
    $ok=true;
    if($id == 1 and $tabela == "login"){
        echo "<div id='alert-error'>
        Para esse usuario foi atribuído a função de admin geral, por favor altere os dados se for realmente necessario um novo admin geral
        </div>";
        echo '<br><a href="../admin/alterar?id = '.$id.'"> Alterar</a><br>';
        echo'<a href="../admin/index.php">Voltar a página principal</a>';
    }
    else{
        if($tabela == "login"){
            $sql = "SELECT FROM $tabela WHERE id=".$id;
            $nomel = mysqli_query($conexao,$sql);
            // Prepara o SQL e ui do banco
            $sql = "DELETE FROM $tabela WHERE id=".$id;
            mysqli_query($conexao,$sql);
        
            // Verifica o número de linhas afetas pelo último comando
            $linhasAfetadas = mysqli_affected_rows($conexao);
        
            // Se conseguiu excluir...
            if($linhasAfetadas > 0){
                echo "<div id='alert-item'>
                    Excluído com sucesso !
                    </div> ";

            sleep(2);
            header("location: ../admin?deleted=sim");
            }
            else { // Senão...
                echo "<h2> Houve um erro a tentar excluir. </h2> ";
            } 
        }
        //verifica se tem alguma reserva em transe antes de excluir o leitor
        if($tabela=="leitores"){
            $sql = "SELECT id_leitores FROM reservas WHERE id_leitores = \"$id\"";
            $id_leitores = mysqli_query($conexao, $sql);
            $id_leitores = $id_leitores -> fetch_assoc();
            $id_leitores = $id_leitores['id_leitores'];

            $sql = "SELECT nome FROM leitores WHERE id = \"$id_leitores\"";
            $nome = mysqli_query($conexao, $sql);
            $linhasAfetadas = mysqli_num_rows($nome);
            
            if($linhasAfetadas>0){
                $ok=false;}
            else{
                $ok=true;}
        }
        //verifica se tem alguma reserva em transe antes de excluir o livro
        if($tabela=="livros"){
            $sql = "SELECT id_livros FROM reservas WHERE id_livros = \"$id\"";
            $id_livros = mysqli_query($conexao, $sql);
            $id_livros = $id_livros -> fetch_assoc();
            $id_livros = $id_livros['id_livros'];
            
            $sql = "SELECT nomel FROM livros Where id = \"$id_livros\"";
            $nomel = mysqli_query($conexao, $sql);
            $linhasAfetadas = mysqli_num_rows($nomel);
            
            if($linhasAfetadas>0){
                $ok=false;}
            else{
                $ok=true;}
        }

        if($ok==true){
            $sql = "SELECT FROM $tabela WHERE id=".$id;
            $nomel = mysqli_query($conexao,$sql);
            // Prepara o SQL e ui do banco
            $sql = "DELETE FROM $tabela WHERE id=".$id;
            mysqli_query($conexao,$sql);
        
            // Verifica o número de linhas afetas pelo último comando
            $linhasAfetadas = mysqli_affected_rows($conexao);
        
            // Se conseguiu excluir...
            if($linhasAfetadas > 0 and $tabela=="livros"){
                echo "<div id='alert-item'>
                    Excluído com sucesso !
                    </div> ";

            sleep(2);
            header("location: ../livros?deleted=sim");
            } 
            if($linhasAfetadas > 0 and $tabela=="leitores"){
                echo "<div id='alert-item'>
                Excluído com sucesso !
                </div> ";

                sleep(2);
                header("location: ../usuarios?deleted=sim");
            } 
            else { // Senão...
                echo "<h2> Houve um erro a tentar excluir. </h2> ";
            } 
            // Rodapé
                echo '<hr> ';
                echo '<a href="../menu.html">Voltar a página principal</a> | <a href="index.php">Voltar a lista de leitores</a> ';
            }
        else{
            if($tabela=="leitores"){echo "
                <div id='infoExcLeitor'>
                <h1 class='rocket'>
                Impossivel realizar a ação o usuário ainda possui reservas
                </h1>
                <a href='../usuarios/index.php'>
                <button  class='botao'>Voltar a pagina principal</button></a>
                </div>";}
            if($tabela=="livros"){echo "<a href='../livros/index.php'><button  class='botao'>Voltar a pagina principal</button><h1 class='rocket'>Impossivel realizar a ação o livro ainda possui uma ou mais reservas</h1></a>";}}
    }

    }

?>

<link rel="stylesheet" href="../styles/css/main.css">       
<script src="../styles/js/alerts.js"></script>