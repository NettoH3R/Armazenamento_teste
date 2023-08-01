<?php
require_once './vendor/autoload.php';

use Src\MySQLConnection\MySQLConnection;

$bd = new MySQLConnection();

$musica = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $comando = $bd->prepare('SELECT * FROM media WHERE id = :id');
    $comando->execute([':id' => $_GET['id']]);

    $musica = $comando->fetch(PDO::FETCH_ASSOC);
}


include('./includes/header.php');
?>

<h1>Editar Música</h1>

<form action="update.php" method="post">
    <input type="hidden" value="<?= $musica['id'] ?>">
    <input type="text"  value="<?= $musica['nome']?>">
    <input type="file" value="<?= $musica['arquivo']?>">
    <?= var_dump($musica['arquivo'])?>
<button type="submit">Salvar</button>
</form>

<?php include('./includes/footer.php'); ?>