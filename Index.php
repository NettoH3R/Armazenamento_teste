<?php 

require_once './vendor/autoload.php';

use src\MySQLConnection\MySQLConnection;
use PDO;

$bd = new MySQLConnection;

$comando = $bd->prepare('SELECT * FROM media');
$comando->execute();
$medias = $comando->fetchAll(PDO::FETCH_ASSOC);

include ('./includes/header.php')
?>

<table>
    <tr>
        <td>ID</td>
        <td>NOME</td>
        <td>MÚsica</td>
    </tr>

    <?php foreach($generos as $g): ?>
        <tr>
            <td><?= $g['id'] ?></td>
            <td><?= $g['nome'] ?></td>
        </tr>
    <?php endforeach ?>
</table>

<?php include('./includes/header.php'); ?>


