<?php

// PÁGINA QUE FAZ A CONEXÃO COM O BANCO DE DADOS

// Dados de conexão   
$bdServidor = "localhost";
$bdUsuario = "root";
$bdSenha = ""; // senha vazia 
$bdBanco = "biblioteca";

// Faz a conexão com o banco de dados        
$conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

// Se houver problemas, notifica o usuário
if (mysqli_connect_error($conexao)) {
    echo "Problemas para conectar no banco. Erro: ";
    echo mysqli_connect_error();
    die();
}