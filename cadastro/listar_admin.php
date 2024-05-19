<?php
session_start();

require_once("conexao.php");
if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM administrador");
    $stmt->execute();
    $administrador = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro:" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
	<link rel="stylesheet" href="css/stars_.css">
    <link rel="stylesheet" href="css/lista_admin_.css">
    <title>Administradores Cadastrados</title>
</head>

<body><header>
    <div id="stars"></div>
    <a href="painel_admin.php"><img src="./img/voltar.png" class="xis" alt="Voltar"></a>
    <h1>Lista de Administradores</h1>
    </header>
    <table>
        
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Ativo</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>

        <?php foreach ($administrador as $administrador) : ?>
            <tr>
                <td><?php echo $administrador['ADM_ID']; ?></td>
                <td><?php echo $administrador['ADM_NOME']; ?></td>
                <td><?php echo $administrador['ADM_EMAIL']; ?></td>
                <td><?php echo $administrador['ADM_SENHA']; ?></td>
                <td><?php echo $administrador['ADM_ATIVO']; ?></td>
                <td><a href="editar_admin.php?id=<?php echo $administrador['ADM_ID']; ?>"class="action-btn">✍</a></td>
                <td><a href="excluir_admin.php?id=<?php echo $administrador['ADM_ID']; ?>" class="action-btn delete-btn" onclick="return confirmarClique()">❌</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
<script src="js/excluir_admin.js"></script>
</html>