<?php
session_start();

include './conecta.php';
$chat = $_SESSION['chatAtivo'];
$nome = $_SESSION['nome_cliente'];
$telefone = $_SESSION['telefone_cliente'];
$selecionadas = $_SESSION['selecionados'];
$selecionadas = implode("Convênio da", $selecionadas);;


$consulta = "select * from chat where id = $chat;";
$executar = $conexao->query($consulta);
while ($linha = $executar->fetch_array()) {
    $usuarioVenda = $linha['corretor'];
}

$consulta = "insert into vendas (corretor, nomeCliente, telefone, email, selecionadas, dataVenda, statusNegociacao) values ($usuarioVenda, '$nome', '$telefone', '', '$selecionadas', CURDATE(), 'Em negociação');";
$executar = $conexao->query($consulta);

session_destroy();