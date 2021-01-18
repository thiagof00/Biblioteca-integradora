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
        $('#cel').mask('(99) 99999-9999');
        })
        </script>  
<link rel="icon" type="imagem/png" href="../styles/img/iconeuru.png" />
        <title>Biblioteca Uruguaiana</title>
</head>
<body>

<!-- PÁGINA DE CADASTRO DE USUÁRIOS -->

<header><a href="index.php"><img src="../styles/img/back.svg" id="img-back"> </a> <h1>BIBLIOTECA INTEGRADORA - URUGUAIANA</h1> 
</header>

<main>
        
            
                <h2><strong>Formulário de leitores</h2></strong>

            <form action="cadastrar.php" method="post">
                            <br>
                        <div class="info">
                            <h4>Dados do leitor:</h4>
                        
                    
                            

                <div class="input">
                    <input autofocus type="text" name="nome" required > 
                    <label> Nome do leitor</label>
                    </div>

                    <div class="input">
                    
                    <input id="rg" type="text" name="rg" maxlength="10" required>
                            <label> RG do leitor (somente números) </label>
                            
                    </div>

                    <div class="input">
                    
                    <input id="cpf" type="text" name="cpf"  required>
                            <label> CPF do leitor (somente números) </label>
                        
                    </div>

                    <div class="input">
                    
                            <input id="cel" type="text" name="fone" required>
                            <label> Telefone (somente números)</label>
                    </div>

                    <div class="input">
                    
                            <input type="text" name="endereco" required>
                            <label> Endereço</label>
                    </div>
                <button type="submit" id="submit"> Enviar</button>
                    </div>
                    
            
            </form>  
</main>

<?php
        session_start();
        if($_SESSION["logado"]==false){
                header("location: ../index.php?pego=sim");
        }
    if ($_POST) {
            
    include("../conecta.php");
        
        
        // Recebe os dados do formulário
        $nome = $_POST["nome"];
        $rg= $_POST["rg"];
        $cpf= $_POST["cpf"];
        $fone= $_POST["fone"];
        $endereco= $_POST["endereco"];
        
        $sql = "SELECT * FROM leitores WHERE cpf=\"$cpf\"";
        $teste = mysqli_query($conexao, $sql);
        $linhasAfetadas = mysqli_num_rows($teste);
                
        if($linhasAfetadas==0){
                // Prepara o SQL e Insere no banco
                $sql = "INSERT INTO leitores (nome, rg, cpf, fone, endereco) VALUES (\"$nome\",\"$rg\",\"$cpf\",\"$fone\",\"$endereco\")";
                mysqli_query($conexao, $sql);

                // Verifica o número de linhas afetadas pelo último comando
                $linhasAfetadas = mysqli_affected_rows($conexao);

                // Se conseguiu inserir...
                if ($linhasAfetadas > 0) {
                echo "<div id='alert-item'>
                O usuário foi cadastrado com sucesso!
                <div id='options'>
                <strong id='back'>Registrar outro</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
                </div> ";
                
        
                }
                else { // Senão...    
                        echo "<div id='alert-error'>
                        Algo deu errado, verifique e tente novamente!
                        <div id='options'>
                <strong id='back'>Registrar outro usuário</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
                        </div>";
                        }
        }
        else { // Senão...    
                echo "<div id='alert-error'>
                CPF do usuario ja cadastrado!, verifique e tente novamente!
                <div id='options'>
        <strong id='back'>Registrar outro usuário</strong> <a href='index.php'><strong>Tela inicial</strong></a></div>
                </div>";
                }
}      


            ?>

<script src="../styles/js/alerts.js"> </script> 
<footer><a href="descprojeto.html"><img src="../styles/img/info.svg"></a> <div id ="footerText">
    Projeto de Extensão Biblioteca Integradora (PJO56-2020) - IFFar Campus Avançado Uruguaiana
</div></footer>
</body>
</html>
            