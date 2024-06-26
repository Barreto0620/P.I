<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header('Location:login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
    <link rel="stylesheet" href="./css/cadastrar_categorias.css">
    <link rel="stylesheet" href="css/estrelas_.css">
    <title>Cadastro de Categoria | Games Space</title>
</head>

<body>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <header>
            <a href="painel_admin.php"><img class="logo" src="./img/logo_1.png" alt="Foto da loja de Games"></a>
        </header>
    
<div class="conteiner">
    <form action="" class="form" method="post" enctype="multipart/form-data">
        <div class="form-title"><span>Cadastrar Categoria</span></div>
        <div class="title-2"><span>DELTA</span></div>
        <div class="input-container">
            <input type="text" class="input-mail" name="nome" id="nome" placeholder="Nome" required></input>
            <p></p>
            <textarea name="descricao" class="input-desc" id="descricao" placeholder="Descrição" required></textarea>
            <span> </span>
        </div>

        <section class="bg-stars">
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
        </section>

        <div class="input-container">
            <label>
            <span class="ativo_span">Ativo:</span>
            <input type="checkbox" class="input-pwd" name="ativo" id="ativo" value="1" checked>
            </label>
        </div>

        <button type="submit" class="submit"> Cadastrar Categoria</button>
    </form>
</div>

<?php
try {
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color=red;'> Erro ao buscar categorias" . $e->getMessage() . "</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    try {
        $sql = "INSERT INTO CATEGORIA 
			(CATEGORIA_NOME, CATEGORIA_DESC, CATEGORIA_ATIVO) 
			VALUES (:nome, :descricao, :ativo)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        $categoria_id = $pdo->lastInsertID();
    } catch (PDOException $e) {
        echo "<p style='color:red;'> Erro ao cadastrar a categoria: " . $e->getMessage() . "</p>";
    }

    echo "<p style='text-align: center;font-size: 20px;color:green;margin-top: 1%;'> Categoria cadastrada com sucesso!</p>";
}
?>

</body>

</html>
