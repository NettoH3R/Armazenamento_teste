<?php
if (isset($_FILES['arquivo'])) {
    $file = $_FILES['arquivo'];

    $nome = $_POST['nome'];

    // Verificar o tipo MIME do arquivo
    $allowedTypes = array('audio/mpeg', 'audio/mp3');
    $fileType = mime_content_type($file['tmp_name']);

    if (in_array($fileType, $allowedTypes)) {
        // O arquivo é um MP3 válido, faça o processamento aqui
        // ...
        // var_dump($file);
        
        $pasta = 'assets/arquivos/';
        
        $nome = $_POST['nome'];
        $extencao = $file['name'];
        $extencao = strtolower(pathinfo($extencao, PATHINFO_EXTENSION));
        $path = $pasta . $nome . "." . $extencao;
        echo $extencao;

        //Envia o arquivo para a pasta selecionada
        $deu_certo = move_uploaded_file($file['tmp_name'], $path);

        if($deu_certo){
            echo "Arquivo enviado com secesso <a href=\"assets/arquivos/$nome.$extencao\">Click </a>";
        }else{
            echo "<p>Falha ao Enviar o arquivo</p>";
        }

    } else {
        // O arquivo não é um MP3 válido, exiba uma mensagem de erro
        echo "Tipo de arquivo inválido. Por favor, selecione um arquivo MP3.";
    }
}


include('./includes/header.php') ?>

<form action="./insert.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="arquivo">
    <br>
    <table>Digite Nome da música:</table>
    <input type="text" name="nome">
    <br>
    <input type="submit" value="Enviar">
</form>

<?php include('./includes/footer.php') ?>