<?php
session_start();
include "conecta.php";

if(!isset($_SESSION["selecionados"])){
    $array = [];    
    array_push($array, $_POST['selecionado']);
} else{
    $array = $_SESSION["selecionados"];
    array_push($array, $_POST['selecionado']);
}
$_SESSION['selecionados'] = $array;
var_dump($_SESSION['selecionados']);

?>