<?php
    $servidor = "localhost";
    $usuario = "root";
    $pass = "";
    $bd = "omnisegure";

    // $servidor = "localhost";
    // $usuario = "omnisegu_Omni";
    // $pass = "{ljoVC3b~kya";
    // $bd = "omnisegu_omnisegureFinal";

    $conexao = new mysqli($servidor, $usuario, $pass, $bd);

    function formatarData($data){
        return date('h:i a', strtotime($data));
    }
    function formatarData2($data){
        return date('d/m/Y', strtotime($data));
    }
?>