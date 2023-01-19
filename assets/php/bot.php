<?php
session_start();
include './conecta.php';
$txt = $_POST['texto'];
$chat = $_POST['chatAtivo'];
$m_status = $_POST['m_status'];
$posicao = $_SESSION['posicao_chat'];
$_SESSION['chatAtivo'] = $chat;

function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

$consulta = "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), $m_status);";
$executar = $conexao->query($consulta);

if($posicao == 1){
    $nome = $txt;
    $_SESSION['nome_cliente'] = $nome;
    $query = mysqli_query($conexao, "UPDATE chat SET destinatario = '$nome' WHERE id = $chat;");
    $txt = "Certo $nome, qual seu telefone?";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");
    $_SESSION['posicao_chat'] = 2;
}
if($posicao == 2){
    $_SESSION['telefone_cliente'] = $txt;
    $txt = "Agora vamos descobrir qual o melhor convênio para você";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");
    $txt = "Qual tipo de plano você quer?";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");

    $_SESSION['posicao_chat'] = 3;
}
if($posicao == 3){
    $tipoPlano =  str_replace("Você optou por buscar Plano ", "", $txt);
    if($tipoPlano == 'Adesão'){
        $tipoPlano = 'Adesão Individual';
    }
    $_SESSION['plano_selecionado'] = $tipoPlano;

    $txt = "Perfeito, agora por favor selecione seu estado";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");
    
    $_SESSION['posicao_chat'] = 4;
}
if($posicao == 4){
    $estado =  str_replace("Certo seu estado é ", "", $txt);
    $estado =  str_replace(" agora me conta, qual sua cidade?", "", $estado);
    $_SESSION['estado_selecionado'] = $estado;

    $_SESSION['posicao_chat'] = 5;
}
if($posicao == 5){
    $tipoPlano = $_SESSION['plano_selecionado'];
    $cidade =  str_replace("A cidade selecionada foi ", "", $txt);
    $_SESSION['cidade_selecionado'] = $cidade;

    $txt = "As seguradoras disponíveis para você são as seguintes";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");

    $consulta = "select distinct seguradora.logo, seguradora.nome, seguradora.id from rede_credenciada, seguradora where rede_credenciada.seguradora = seguradora.id and rede_credenciada.nome = '$cidade' and tipo = '$tipoPlano' order by rede_credenciada.nome;";
    $sql = $conexao->query($consulta);
    while ($linha = $sql->fetch_array()) {
        $txt = "não exibir seguradora " . $linha['id'];
        $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");
    }

    $txt = "Para ver os preços clique na seguradora desejada, você pode clicar em mais de uma para verificar todas as opções";
    $consulta = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), 1);");

    $_SESSION['posicao_chat'] = 6;
}
?>