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
            <div class="menssagem">
                <p><?php echo $linha['txt']; ?></p>
            </div>
            <div class="data">Você - <?php echo formatarData($linha['horario']) ?></div>
        </div>
        <?php
        if ($_SESSION['posicao_chat'] == 3 && $linha['txt'] == "Perfeito, agora por favor selecione seu estado") { ?>
            <div class="estados" id="estados">
                <span class="opcao"  onclick="selecionaEstado(this)">AC</span>
                <span class="opcao"  onclick="selecionaEstado(this)">AL</span>
                <span class="opcao"  onclick="selecionaEstado(this)">AP</span>
                <span class="opcao"  onclick="selecionaEstado(this)">AM</span>
                <span class="opcao"  onclick="selecionaEstado(this)">BA</span>
                <span class="opcao"  onclick="selecionaEstado(this)">CE</span>
                <span class="opcao"  onclick="selecionaEstado(this)">DF</span>
                <span class="opcao"  onclick="selecionaEstado(this)">ES</span>
                <span class="opcao"  onclick="selecionaEstado(this)">GO</span>
                <span class="opcao"  onclick="selecionaEstado(this)">MA</span>
                <span class="opcao"  onclick="selecionaEstado(this)">MT</span>
                <span class="opcao"  onclick="selecionaEstado(this)">MS</span>
                <span class="opcao"  onclick="selecionaEstado(this)">MG</span>
                <span class="opcao"  onclick="selecionaEstado(this)">PA</span>
                <span class="opcao"  onclick="selecionaEstado(this)">PB</span>
                <span class="opcao"  onclick="selecionaEstado(this)">PR</span>
                <span class="opcao"  onclick="selecionaEstado(this)">PE</span>
                <span class="opcao"  onclick="selecionaEstado(this)">PI</span>
                <span class="opcao"  onclick="selecionaEstado(this)">RJ</span>
                <span class="opcao"  onclick="selecionaEstado(this)">RN</span>
                <span class="opcao"  onclick="selecionaEstado(this)">RS</span>
                <span class="opcao"  onclick="selecionaEstado(this)">RO</span>
                <span class="opcao"  onclick="selecionaEstado(this)">RR</span>
                <span class="opcao"  onclick="selecionaEstado(this)">SC</span>
                <span class="opcao"  onclick="selecionaEstado(this)">SP</span>
                <span class="opcao"  onclick="selecionaEstado(this)">SE</span>
                <span class="opcao"  onclick="selecionaEstado(this)">TO</span>
            </div>
        <?php }
        if ($_SESSION['posicao_chat'] == 5 && $linha['txt'] == "Qual tipo de plano você quer?") { ?>
            <div class="estados" style="margin-bottom: 30px;" id="estados">
                <span class="opcao" style="width: auto; padding-left: 5px;padding-right: 5px;" onclick="selecionaEstado(this)">Plano individual</span>
                <span class="opcao" style="width: auto; padding-left: 5px;padding-right: 5px;" onclick="selecionaEstado(this)">Plano familiar</span>
                <span class="opcao" style="width: auto; padding-left: 5px;padding-right: 5px;" onclick="selecionaEstado(this)">Plano empresarial</span>
            </div>
        <?php }
    }

    if ($linha['m_status'] == 2) {
        ?>
        <div class="menssagem-enviada">
            <div class="menssagem">
                <p><?php echo $linha['txt']; ?></p>
            </div>
            <div class="data">Você - <?php echo formatarData($linha['horario']) ?></div>
        </div>
<?php }


endwhile;


$_SESSION["canalAtivo"] = $canalAtivo;
?>