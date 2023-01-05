<?php
include './assets/php/conecta.php';
$sql = mysqli_query($conexao, "insert into chat (DMY) values (NOW());");
$sql = mysqli_query($conexao, "select max(id) from chat;");
while ($linha = $sql->fetch_array()) {
    $chatId = $linha['max(id)'];
}
$txt = "Oláaaaaaaaa aaaaaaaaaaaaaaa aaaaaaaa";
$sql = mysqli_query($conexao, "insert into menssagens (chat, txt, horario, m_status) values ('$chatId', '$txt', curtime(), 1);");
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <title>Chat</title>
</head>

<body>
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
        let chat = document.getElementById('idChat').innerText

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
            carregarMenssagens();
        }, 1000);
        $(document).ready(function() {
            $('#text').submit(function(e) {
                e.preventDefault();
                let txt = document.getElementById('txtChat').value
                // let chat = document.getElementById('idChat').innerText
                $.ajax({
                    url: 'assets/php/enviarMenssagem.php',
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
                    // document.getElementById('display').scrollTo(0, 100000);
                }, 1000);
            })
        })
    </script>
</body>

</html>