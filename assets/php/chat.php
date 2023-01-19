<?php
error_reporting(0);
session_start();
include "conecta.php";
$canalAtivo = $_POST['canalAtivo'];

$consulta = "SELECT * FROM menssagens where chat = '$canalAtivo';";
$executar = $conexao->query($consulta);
while ($linha = $executar->fetch_array()) :

    if ($linha['m_status'] == 1 && !str_contains($linha['txt'], 'não exibir seguradora ')) {
         
        if ($_SESSION['posicao_chat'] == 6 && str_contains($linha['txt'], 'Convênio da seguradora')) { ?>
            <div class="menssagem-recebida" onclick="selecionaConvenio(this)">
                <div class="menssagem">
                    <p><?php echo $linha['txt']; ?></p>
                </div>
                <div class="data">Bot - <?php echo formatarData($linha['horario']) ?></div>
            </div>
            <div class="estados" style="margin-bottom: 30px;" id="estados">
                <span class="opcao" style="width: auto; padding-left: 5px;padding-right: 5px;" onclick="finaliza()">Finalizar</span>
                
            </div>
        <?php } else{?>
        <div class="menssagem-recebida">
            <div class="menssagem">
                <p><?php echo $linha['txt']; ?></p>
            </div>
            <div class="data">Bot - <?php echo formatarData($linha['horario']) ?></div>
        </div>
        <?php }
        if ($_SESSION['posicao_chat'] == 3 && $linha['txt'] == "Qual tipo de plano você quer?") { ?>
            <div class="estados" style="margin-bottom: 30px;" id="estados">
                <span class="opcao" style="width: auto; padding-left: 5px;padding-right: 5px;" onclick="selecionaTipoPlano(this)">Plano Individual</span>
                <span class="opcao" style="width: auto; padding-left: 5px;padding-right: 5px;" onclick="selecionaTipoPlano(this)">Plano Familiar</span>
                <span class="opcao" style="width: auto; padding-left: 5px;padding-right: 5px;" onclick="selecionaTipoPlano(this)">Plano Empresarial</span>
                <span class="opcao" style="width: auto; padding-left: 5px;padding-right: 5px;" onclick="selecionaTipoPlano(this)">Plano Adesão</span>
            </div>
        <?php }
        if ($_SESSION['posicao_chat'] == 4 && $linha['txt'] == "Perfeito, agora por favor selecione seu estado") { ?>
            <div class="estados" id="estados">
                <span class="opcao" onclick="selecionaEstado(this)">AC</span>
                <span class="opcao" onclick="selecionaEstado(this)">AL</span>
                <span class="opcao" onclick="selecionaEstado(this)">AP</span>
                <span class="opcao" onclick="selecionaEstado(this)">AM</span>
                <span class="opcao" onclick="selecionaEstado(this)">BA</span>
                <span class="opcao" onclick="selecionaEstado(this)">CE</span>
                <span class="opcao" onclick="selecionaEstado(this)">DF</span>
                <span class="opcao" onclick="selecionaEstado(this)">ES</span>
                <span class="opcao" onclick="selecionaEstado(this)">GO</span>
                <span class="opcao" onclick="selecionaEstado(this)">MA</span>
                <span class="opcao" onclick="selecionaEstado(this)">MT</span>
                <span class="opcao" onclick="selecionaEstado(this)">MS</span>
                <span class="opcao" onclick="selecionaEstado(this)">MG</span>
                <span class="opcao" onclick="selecionaEstado(this)">PA</span>
                <span class="opcao" onclick="selecionaEstado(this)">PB</span>
                <span class="opcao" onclick="selecionaEstado(this)">PR</span>
                <span class="opcao" onclick="selecionaEstado(this)">PE</span>
                <span class="opcao" onclick="selecionaEstado(this)">PI</span>
                <span class="opcao" onclick="selecionaEstado(this)">RJ</span>
                <span class="opcao" onclick="selecionaEstado(this)">RN</span>
                <span class="opcao" onclick="selecionaEstado(this)">RS</span>
                <span class="opcao" onclick="selecionaEstado(this)">RO</span>
                <span class="opcao" onclick="selecionaEstado(this)">RR</span>
                <span class="opcao" onclick="selecionaEstado(this)">SC</span>
                <span class="opcao" onclick="selecionaEstado(this)">SP</span>
                <span class="opcao" onclick="selecionaEstado(this)">SE</span>
                <span class="opcao" onclick="selecionaEstado(this)">TO</span>
            </div>
        <?php }
        if ($_SESSION['posicao_chat'] == 5 && str_contains($linha['txt'], 'Certo seu estado é')) { ?>
            <form>
                <?php
                $estado_selecionado = $_SESSION['estado_selecionado'];
                $tipoPlano = $_SESSION['plano_selecionado'];
                $consulta = "select distinct rede_credenciada.nome from rede_credenciada, seguradora where rede_credenciada.seguradora = seguradora.id and rede_credenciada.estado = '$estado_selecionado' and tipo = '$tipoPlano' order by rede_credenciada.nome;";
                $sql = $conexao->query($consulta);
                ?>
                <select id="cidades" onclick="paraAtualizazao()">
                    <option value="">Selecione sua cidade</option>
                    <?php
                    
                    while ($linha = $sql->fetch_array()) {?>                    
                        <option value="<?php echo $linha['nome'];?>"><?php echo $linha['nome'];?></option>
                    <?php } ?>
                </select>
                <a onclick="loadCidade()"><span class="material-symbols-outlined" style="font-size: 32px;">send</span></a>
            </form>
        <?php }
        
    } else if (str_contains($linha['txt'], 'não exibir seguradora ')) { ?>
        <div class="seguradoras" style="margin-bottom: 30px;" id="estados">
            <?php
                $seguradora = str_replace("não exibir seguradora ", "", $linha['txt']);
                $consulta = "select * from seguradora where id = $seguradora;";
                $sql = $conexao->query($consulta);
                while ($linha = $sql->fetch_array()) {
            ?>
            <span class="opcao" onclick="selecionaSeguradora(<?php echo $linha['id']?>)">
                <img style="width: 200px; heigth: 100px; border-radius: 10px" src="./assets/logos/<?php echo $linha['logo']?>" alt="">
                <p style="color: var(--titulo); margin-bottom: 10px; opacity: 80%"><?php echo $linha['nome']?></p>
            </span>
            <?php } ?>
            
        </div>
    <?php }

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