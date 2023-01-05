<?php
    $servidor = "localhost";
    $usuario = "root";
    $pass = "";
    $bd = "chat";

    $conexao = new mysqli($servidor, $usuario, $pass, $bd);

    function formatarData($data){
        return date('h:i a', strtotime($data));
    }
    function formatarData2($data){
        return date('d/m/Y', strtotime($data));
    }
?>