<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

require_once('conexao.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $administrador = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header('Location: listar_admin.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    try {
        $stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ATIVO = :ativo WHERE ADM_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: listar_admin.php');
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>



<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
    <link rel="stylesheet" href="../cadastro/css/editar_admin.css">
    <link rel="stylesheet" href="../cadastro/css/stars_2.css">
    <title>Login | Games Space </title>
</head>

<body>
    <header>
        <div id="stars"></div>
        <div id="stars2"></div>
        <div id="stars3"></div>
        <a href="painel_admin.php"><img class="logo" src="./img/logo_1.png" alt="Foto da loja de Games"></a>
    </header>
    <div class="container right-panel-active">
        <!-- Sign Up -->
        <div class="container__form container--signup">
            <form action="#" class="form" id="form1" method="post" enctype="multipart/form-data">
                <h2 class="form__title">Editar Administrador</h2>
                <input type="hidden" name="id" value="<?php echo $administrador['ADM_ID']; ?>">

                <input type="text" class="input" placeholder="Nome" name="nome" id="nome" required value="<?php echo $administrador['ADM_NOME']; ?>"><br>
                <input type="email" placeholder="Email" class="input" name="email" id="email" required value="<?php echo $administrador['ADM_EMAIL']; ?>"><br>

                <input type="password" placeholder="Senha" class="input" name="senha" id="senha" step="0.01" required value="<?php echo $administrador['ADM_SENHA']; ?>"><br>

                <label for="ativo">Administrador Ativo:
                <input type="checkbox" name="ativo" id="ativo" value="1" checked value="<?php echo $administrador['ADM_ATIVO']; ?>"><br>
                </label>
                <button type="submit" class="btn">Editar</button>
                <p>
                    <a href="listar_admin.php">Voltar à Lista de Administradores</a>
            </form>
        </div>
        <!-- Overlay -->
        <div class="container__overlay">
            <div class="overlay">
                <div class="overlay__panel overlay--left">
                <button class="btn_excluir" id="signIn" onclick="window.location.href = 'listar_admin.php';">X</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // retorna o metod usado para acessar a página.

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $ativo = isset($_POST['ativo']) ? 1 : 0;

        try {
            $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO)  VALUES (:nome, :email, :senha, :ativo)";

            $stmt = $pdo->prepare($sql); //Nessa linha, $stmt é um objeto que representa a instrução SQL preparada. Você pode então vincular parâmetros a essa instrução e executá-la.
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
            $stmt->execute();

            echo "<p style='text-align: center;color:green;margin-top: 1%;'> Administrador cadastrado com sucesso! </p>";
        } catch (PDOException $e) {
            echo "<p style='color=red;'> Erro ao cadastrar Usuário!" . $e->getMessage() . "</p>";
        }
    }
    ?>
</body>

</html>