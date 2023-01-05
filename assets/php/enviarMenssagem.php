<?php
include './conecta.php';
$txt = $_POST['texto'];
$chat = $_POST['chatAtivo'];
$m_status = $_POST['m_status'];

// $_SESSION['chat'] = $chat;

$consulta = "insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$txt', curtime(), $m_status);";
$executar = $conexao->query($consulta);

?>