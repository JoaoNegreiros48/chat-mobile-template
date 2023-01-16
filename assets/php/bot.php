<?php
session_start();
include './conecta.php';
$txt = $_POST['texto'];
$chat = $_POST['chatAtivo'];
$m_status = $_POST['m_status'];
$posicao = $_SESSION['posicao_chat'];

function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}


// $_SESSION['chat'] = $chat;

$consulta = "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), $m_status);";
$executar = $conexao->query($consulta);

if($posicao == 1){
    $nome = $txt;
    $txt = "Certo $nome, qual seu telefone?";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");
    $_SESSION['posicao_chat'] = 2;
}
if($posicao == 2){
    $nome = $txt;
    $txt = "Perfeito, agora por favor selecione seu estado";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");
    $_SESSION['posicao_chat'] = 3;
}
if($posicao == 3){
    $estado =  str_replace("Certo seu estado é ", "", $txt);
    $estado =  str_replace(" agora me conta, qual sua cidade?", "", $estado);
    
    $_SESSION['posicao_chat'] = 4;
}
if($posicao == 4){
    $cidade =  $txt;
    $cidade = tirarAcentos($cidade);
    $cidade = strtolower($cidade);

    $txt = "Agora vamos descobrir qual o melhor convênio para você";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");
    $txt = "Qual tipo de plano você quer?";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");
    $_SESSION['posicao_chat'] = 5;
}
?>