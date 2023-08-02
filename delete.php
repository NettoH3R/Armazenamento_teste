<?php

$title = 'Deletar musica';

require_once './vendor/autoload.php';

use Src\MySQLConnection\MySQLConnection;

$bd = new MySQLConnection();

$musica = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $comando = $bd->prepare('SELECT * FROM media WHERE id = :id');
    $comando->execute([':id' => $_GET['id']]);

    $musica = $comando->fetch(PDO::FETCH_ASSOC);
} else {
    $comando = $bd->prepare('SELECT * FROM media WHERE id = :id');
    $comando->execute([':id' => $_POST['id']]);

    $musica = $comando->fetch(PDO::FETCH_ASSOC);
    //caminho do arquivo
    $extencao = strtolower(pathinfo($musica['arquivo'], PATHINFO_EXTENSION));

    $path = 'assets/arquivos/' . $musica['nome'] . "." . $extencao;

    $comando = $bd->prepare('DELETE FROM media WHERE id = :id');
    $comando->execute([':id' => $_POST['id']]);

    unlink($path);

    header('Location:/index.php');
}

include('./includes/header.php');
?>

<h1>Remover Música</h1>
<p>Tem certeza que deseja excluir a musica "<?= $musica['nome'] ?>"</p>

<form action="delete.php" method="post">
    <input type="hidden" name="id" value="<?= $musica['id'] ?>" />

    <br />

    <button type="submit" >Excluir</button>
    <a href="index.php" ><button type="button">Voltar</button></a>
</form>

<?php include('./includes/footer.php'); ?>
