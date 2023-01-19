<?php
include './assets/php/conecta.php';
session_start();
$corretor = $_GET['id'];
$data_atual = date('Y-m-d H:i:s');

$sql = mysqli_query($conexao, "insert into chat (corretor, DMY, tag) values (1 , '$data_atual', 'Iniciado');");

$sql = mysqli_query($conexao, "select * from chat where corretor = $corretor and DMY = '$data_atual';");
while ($linha = $sql->fetch_array()) {
    $chatId = $linha['id'];
}
$txt = "Olá meu nome é (Nome do corretor). <br><br> Estou aqui para te ajudar a encontrar o melhor seguro para você. <br><br> Para isso terei que fazer algumas perguntas";
$sql = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chatId', '$txt', curtime(), 1);");

$txt = "Qual seu nome?";
$sql = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chatId', '$txt', curtime(), 1);");

$_SESSION['posicao_chat'] = 1;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/styles.css">

    <!-- fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

    <!-- Icones -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <!-- CDN Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Chat</title>
</head>

<body>
    <div id="selecionado">
        <p>SELECIONADO</p>
    </div>
    <p id="idChat" style="display: none;"><?php echo $chatId ?></p>
    <form id="text">
        <input id="txtChat" type="text" placeholder="Enviar menssagem">
        <button><span class="material-symbols-outlined" style="font-size: 32px;">send</span></button>
    </form>

    <h3>Nome da corretora</h3>

    <div class="info">
        <p class="texto">Nome do corretor</p>
        <p class="subtitulo">Um especialista em seguros saúde</p>
    </div>



    <div id="display" class="display">
        <!-- <div class="menssagem-recebida">
            <div class="menssagem">Texto teste</div>
            <div class="data">Nome do corretor - 9:30</div>
        </div>
        <div class="menssagem-enviada">
            <div class="menssagem">PTexto teste Texto teste Texto teste Texto teste Texto teste Texto teste </div>
            <div class="data">Você - 9:30</div>
        </div> -->
    </div>

    <script>
        atualizar = 1;

        function paraAtualizazao() {
            atualizar = 0
        }
        let chat = document.getElementById('idChat').innerText
        // Buscar estado do chat

        function verificaEstado() {
            $.ajax({
                url: 'assets/php/carregaEstado.php',
                method: 'GET',
                data: {
                    canalAtivo: chat
                },
                async: false,
            }).done(function(result) {
                estado = result
            });

            if (estado == 2) {
                document.getElementById('txtChat').type = 'tel'
                document.getElementById('txtChat').placeholder = 'exemplo: 15998658022'
            }
            if (estado == 3) {
                document.getElementById('text').style = 'display:none'
            }
            if (estado == 4) {

                document.getElementById('text').style = 'display:none'
            }
            if (estado == 5) {
                document.getElementById('text').style = 'display:none'
            }
            if (estado == 6) {
                document.getElementById('text').style = 'display:none'
            }
        }
        setInterval(function() {
            verificaEstado();
        }, 800);

        function selecionaTipoPlano(el) {
            $.ajax({
                url: 'assets/php/bot.php',
                method: 'POST',
                data: {
                    texto: 'Você optou por buscar ' + el.innerText,
                    chatAtivo: chat,
                    m_status: 1
                }
            }).done(function(result) {
                document.getElementById('txtChat').value = ""
            });
            setTimeout(function() {
                // console.log('menssagens')
                document.getElementById('display').scrollTo(0, 1000);
            }, 800);
        }

        function selecionaEstado(el) {
            document.getElementById('text').style = 'display:flex'
            document.getElementById('txtChat').placeholder = 'Enviar menssagem'
            document.getElementById('txtChat').type = 'text'
            document.getElementById('estados').style = 'display:none'
            $.ajax({
                url: 'assets/php/bot.php',
                method: 'POST',
                data: {
                    texto: 'Certo seu estado é ' + el.innerText + ' agora me conta, qual sua cidade?',
                    chatAtivo: chat,
                    m_status: 1
                }
            }).done(function(result) {
                document.getElementById('txtChat').value = ""
            });
            setTimeout(function() {
                // console.log('menssagens')
                document.getElementById('display').scrollTo(0, 1000);
            }, 800);
        }

        function loadCidade() {
            let select = document.getElementById('cidades').value
            $.ajax({
                url: 'assets/php/bot.php',
                method: 'POST',
                data: {
                    texto: 'A cidade selecionada foi ' + select,
                    chatAtivo: chat,
                    m_status: 1
                }
            }).done(function(result) {
                atualizar = 1;
                document.getElementById('text').style = 'display:flex'
            });

            setTimeout(function() {
                // console.log('menssagens')
                document.getElementById('display').scrollTo(0, 1000);
            }, 800);
        }

        function selecionaSeguradora(el){
            $.ajax({
                url: 'assets/php/carregaValores.php',
                method: 'POST',
                data: {
                    id: el,
                }
            }).done(function(result) {
                atualizar = 1;
                document.getElementById('text').style = 'display:flex'
            });
        }

        function selecionaConvenio(el){
            document.getElementById('selecionado').style = 'display:flex'
            setTimeout(function() {
                document.getElementById('selecionado').style = "display: none;"
            }, 1000);

            $.ajax({
                url: 'assets/php/selecionaConvenio.php',
                method: 'POST',
                data: {
                    selecionado: el.innerText,
                }
            }).done(function(result) {
                console.log(result)
            });
        }

        function finaliza(){
            $.ajax({
                url: 'assets/php/bot.php',
                method: 'POST',
                data: {
                    texto: 'Sua simulação foi finalizada, logo entraremos em contato para finalizarmos seu atendimento',
                    chatAtivo: chat,
                    m_status: 1
                }
            }).done(function(result) {
                
            });
            $.ajax({
                url: 'assets/php/finaliza.php',
                method: 'POST',
                data: {
                    senha: '',
                }
            }).done(function(result) {
                
            });
        }

        // chat

        function carregarMenssagens() {
            $.ajax({
                url: 'assets/php/chat.php',
                method: 'POST',
                data: {
                    canalAtivo: chat
                },
                async: false,
            }).done(function(result) {
                document.getElementById('display').innerHTML = result;
            });
        }
        setInterval(function() {
            if (atualizar == 1) {
                carregarMenssagens();
            }
        }, 800);
        $(document).ready(function() {
            $('#text').submit(function(e) {
                e.preventDefault();
                let txt = document.getElementById('txtChat').value
                // let chat = document.getElementById('idChat').innerText
                $.ajax({
                    url: 'assets/php/bot.php',
                    method: 'POST',
                    data: {
                        texto: txt,
                        chatAtivo: chat,
                        m_status: 2
                    }
                }).done(function(result) {
                    document.getElementById('txtChat').value = ""
                });

                setTimeout(function() {
                    // console.log('menssagens')
                    document.getElementById('display').scrollTo(0, 1000);
                }, 800);
            })
        })
    </script>
</body>

</html>