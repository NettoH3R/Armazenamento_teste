<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') :

    include('./includes/header.php') ?>

    <form action="./insert.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="arquivo">
        <br>
        <table>Digite Nome da música:</table>
        <input type="text" name="nome">
        <br>
        <input type="submit" value="Enviar">
    </form>

<?php
    include('./includes/footer.php');

endif;


require_once './vendor/autoload.php';
//banco de dados
use Src\MySQLConnection\MySQLConnection;
//estabelece conexão com o banco
$bd = new MySQLConnection();


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

        //Consulta os arquivos do banco de dados 
        $comando = $bd->prepare('SELECT * FROM media');
        $comando->execute();
        $medias = $comando->fetchAll(PDO::FETCH_ASSOC);

        //Verifica se já não existe um arquivo com esse nome
        foreach ($medias as $m) {
            if ($m['arquivo'] == $path) {
                die('Já existe um arquivo com esse nome!!');
            }
        }

        //Envia o arquivo para a pasta selecionada
        $deu_certo = move_uploaded_file($file['tmp_name'], $path);

        if ($deu_certo) {
            echo "Arquivo enviado com secesso <a href=\"index.php\">Click Aqui</a> para ver ele";


            //Salva no banco de dados
            $comando = $bd->prepare('INSERT INTO media(nome, arquivo ) VALUES (:nome, :caminho)');
            $comando->execute([':nome' => $nome, 'caminho' => $path]);
        } else {
            echo "<p>Falha ao Enviar o arquivo</p>";
        }
    } else {
        // O arquivo não é um MP3 válido, exiba uma mensagem de erro
        echo "Tipo de arquivo inválido. Por favor, selecione um arquivo MP3.";
    }
}
