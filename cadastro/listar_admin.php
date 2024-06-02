<?php
session_start();

require_once("conexao.php");
if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR");
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
    <link rel="stylesheet" href="css/estrelas_.css">
    <link rel="stylesheet" href="css/lista_admin_.css">
    <title>Administradores Cadastrados | Games Space</title>
</head>

<body>
    <header>
        <div id="stars"></div>
        <a href="painel_admin.php"><img src="./img/voltar.png" class="xis" alt="Voltar"></a>
        <h1>Lista de Administradores</h1>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Pesquisar...">
        </div>
    </header>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Status</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>

        <tbody id="table_body"> <!-- Adicione tbody para os resultados da pesquisa -->
            <?php foreach ($administrador as $administradores) : ?>
                <tr>
                    <td><?php echo $administradores['ADM_ID']; ?></td>
                    <td><?php echo $administradores['ADM_NOME']; ?></td>
                    <td><?php echo $administradores['ADM_EMAIL']; ?></td>
                    <td><?php echo $administradores['ADM_SENHA']; ?></td>
                    <td><?php echo $administradores['ADM_ATIVO'] == 1 ? 'Ativo' : 'Inativo'; ?></td>
                    <td><a href="editar_admin.php?id=<?php echo $administradores['ADM_ID']; ?>" class="action-btn">✍</a></td>
                    <td><a href="#" class="action-btn delete-btn" onclick="confirmarClique(<?php echo $administradores['ADM_ID']; ?>)">❌</a></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
<script src="js/pesquisa.js"></script>
<script src="js/excluir_admin.js"></script>

</html>