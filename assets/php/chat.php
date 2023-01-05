<?php
session_start();
include "conecta.php";
$canalAtivo = $_POST['canalAtivo'];

$consulta = "SELECT * FROM menssagens where chat = '$canalAtivo';";
$executar = $conexao->query($consulta);
while ($linha = $executar->fetch_array()) :

        if ($linha['m_status'] == 1) {
        ?>
            <div class="menssagem-recebida">
                <div class="menssagem"><?php echo $linha['txt']; ?></div>
                <div class="data">Você - <?php echo formatarData($linha['horario']) ?></div>
            </div>
            <?php
        } ?>
        <?php 
        if ($linha['m_status'] == 2) {
        ?>
            <div class="menssagem-enviada">
                <div class="menssagem"><?php echo $linha['txt']; ?></div>
                <div class="data">Você - <?php echo formatarData($linha['horario']) ?></div>
            </div>
<?php }
    
endwhile;


$_SESSION["canalAtivo"] = $canalAtivo;
?>