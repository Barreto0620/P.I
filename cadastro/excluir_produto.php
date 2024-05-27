<?php
session_start();
require_once('conexao.php');

if(!isset($_SESSION['admin_logado'])){ //se nao existeir um adm logado, vamos direcionar ele para pagina de login
    header('Location:login.php');
    exit(); 
}

$message = '';

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    $id = $_GET['id'];
    try{
        $stmt = $pdo->prepare("DELETE FROM PRODUTO_ESTOQUE WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM PRODUTO WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $message = "<p style='color:white;'>Produto excluído com sucesso!</p>";
        }else{
            $message = "Erro ao excluir o produto!";
    }
} catch (PDOException $e){
    $message = "<p style='color:white;'>Infelizmente ocorreu um erro, tente novamente mais tarde ! ";
}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
    <link rel="stylesheet" href="css/excluir.css">
    <link rel="stylesheet" href="css/stars_.css">
    
    <title>Produto Deletado ! | Games Space </title>
    <style>         
        body {background-image: linear-gradient(to right, #002b4b 0%, #b34a2f 100%);
            } 
    </style>
</head>
<body>
    <div id="stars"></div>

    <div class="logo_div">
        <a href="painel_admin.php"><img src="../img/logo_1.png" class="logo" alt="Logo"></a>
    </div>
    <div class="card">
        <div class="title">
            <p><?php echo $message ?> </p>
        </div>
        <div>
            <button class="btn" id="signIn" onclick="window.location.href = 'listar_produtos.php';">Voltar</button>
        </div>
    </div>
</body>
<script src="js/excluir_produto.js"></script>
</html>