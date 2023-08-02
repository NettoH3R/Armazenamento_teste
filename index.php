<?php 

$title = 'Inicio';

require_once './vendor/autoload.php';

use Src\MySQLConnection\MySQLConnection;
use PDO;

$bd = new MySQLConnection;

$comando = $bd->prepare('SELECT * FROM media');
$comando->execute();
$medias = $comando->fetchAll(PDO::FETCH_ASSOC);

include ('./includes/header.php')
?>

<table border="1px">
    <tr>
        <td>ID</td>
        <td>NOME</td>
        <td>MÚSICA</td>
        <td><a href="./insert.php"><button>+</button></a></td>
    </tr>

    <?php foreach($medias as $m): ?>
        <tr>
            <td><?= $m['id'] ?></td>
            <td><?= $m['nome'] ?></td>
            <td><audio src="<?= $m['arquivo'] ?>" controls></td>
            <td>
                <a href="update.php?id=<?= $m['id']?>"><button type="button">Editar</button></a>
                <a href="delete.php?id=<?= $m['id']?>"><button type="button">Excluir</button></a>
            </td>
        </tr>
    <?php endforeach ?>
</table>

<?php include('./includes/header.php'); ?>


