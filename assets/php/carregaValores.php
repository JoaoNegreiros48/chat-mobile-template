<?php
    session_start();
    include "conecta.php";
    $chat = $_SESSION['chatAtivo'];
    $categoria = $_SESSION['plano_selecionado'];
    $convenios = [];
    $seguradora = $_POST['id'];
    $link = '';

    $consulta = "select * from seguradora where id = '$seguradora';";
    $sql = $conexao->query($consulta);
    while ($linha = $sql->fetch_array()) {
        $nomeSeguradora = $linha['nome'];
    }
    
    $consulta = "select * from convenios where seguradora = '$seguradora';";
    $sql = $conexao->query($consulta);
    while ($linha = $sql->fetch_array()) {
        $convenio[$i] = ["id" => $linha['id'], "nome" => $linha['nome'], "seguradora" => $linha['seguradora']];

        $textoConvenio = "Convênio da seguradora $nomeSeguradora - plano: ";
        // $executar = $conexao->query("insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$texto', curtime(), 1);");

        $convenioAgora = $convenio[$i]['id'];
        $consulta = "select * from plano where convenio = '$convenioAgora';";
        $sql = $conexao->query($consulta);
        $contadorConvenios = 0;
        while ($linha = $sql->fetch_array()) {
            $planoDosConvenios[$contadorConvenios] = ["id" => $linha['id'], "convenio" => $linha['convenio'], "nome" => $linha['nome']];

            $textoPlano = $textoConvenio . $linha['nome'];
            // $executar = $conexao->query("insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$texto', curtime(), 1);");

            $plano = $linha['id'];
            $faixa_hetaria = $_SESSION['idade'];
            $query = $conexao->query("select * from valores where plano = '$plano';");
            $textoValores = $textoPlano . "<br><br>";
            while ($dados = $query->fetch_array()) {
                $textoValores = $textoValores . $dados['faixa_etaria'] . " " . $dados['preco'] . "<br>";
            }
            $textoValores = $textoValores . "<br> <span style=" . '"' . 'display:flex; flex-direction: column'  . '"' . "> Para mais informações" . "<br> " . "<a href=" . $link . " style=" . '"' . 'height: auto; width: initial; margin-left: 15px; display: block'  . '"' . "> Clique aqui</a> </span>";
            $executar = $conexao->query("insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$textoValores', curtime(), 1);");
            echo "<br>";

            $contadorConvenios++;
        }


        $i++;
    };

    $texto = "Selecione com um clique os planos que você tem interesse ou quer saber mais, após selecionar todos do seu interesse clique em finalizar, e um(a) corretor(a) entrará em contato para finalizar seu atendimento";
    $executar = $conexao->query("insert into menssagens (chat, txt, horario, m_status) values ('$chat', '$texto', curtime(), 1);");
?>