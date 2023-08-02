<?php
require_once './vendor/autoload.php';

use Src\MySQLConnection\MySQLConnection;

$bd = new MySQLConnection();

$musica = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $comando = $bd->prepare('SELECT * FROM media WHERE id = :id');
    $comando->execute([':id' => $_GET['id']]);

    $musica = $comando->fetch(PDO::FETCH_ASSOC);
} else {
    //pega o antigo nome do arquivo
    $comando = $bd->prepare('SELECT * FROM media WHERE id = :id');
    $comando->execute([':id' => $_POST['id']]);

    $musica = $comando->fetch(PDO::FETCH_ASSOC);

    var_dump($nome);
    //muda para o novo nome
    $comando = $bd->prepare('UPDATE media SET nome = :nome WHERE id = :id');
    $comando->execute([':nome' => $_POST['nome'], ':id' => $_POST['id']]);
    //pega o novo nome do arquivo
    $comando = $bd->prepare('SELECT * FROM media WHERE id = :id');
    $comando->execute([':id' => $_POST['id']]);
    
    $musicaNovoNome = $comando->fetch(PDO::FETCH_ASSOC);

    $extencao = strtolower(pathinfo($musica['arquivo'], PATHINFO_EXTENSION));

    $pathAntigo = 'assets/arquivos/' . $musica['nome'] . "." . $extencao;
    $pathNovo = 'assets/arquivos/' . $musicaNovoNome['nome'] . "." . $extencao;
    
    if (rename($pathAntigo,$pathNovo)){

        $comando = $bd->prepare('UPDATE media SET caminho = :caminho WHERE id = :id');
        $comando->execute([':caminho' => $pathNovo, ':id' => $_POST['id']]);

        header('Location:/index.php');
    }else{
        echo('falha ao enviar o arquivo!!!');
    }
}

include('./includes/header.php');
?>

<h1>Editar Música</h1>

<form action="update.php" method="post">
    <input type="hidden" value="<?= $musica['id'] ?>" name="id">
    <input type="text" value="<?= $musica['nome'] ?>" name="nome">
    <button type="submit">Salvar</button>
</form>

<?php include('./includes/footer.php'); ?>