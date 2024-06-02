<?php
    session_start();

    if(!isset($_SESSION['admin_logado'])){
        header("Location:login.php");
        exit();
    }

    require_once('conexao.php');
    
    $mensagem = "<p style='color=white;'>Categoria excluida com sucesso!";

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
    <link rel="stylesheet" href="css/excluir_categoria.css">
    <link rel="stylesheet" href="css/estrelas_.css">
    <title>Categoria Excluida ! | Games Space</title>
</head>

<body>
    <div id="stars"></div>

    <div class="logo_div">
        <a href="listar_categoria.php"><img src="../img/logo_1.png" class="logo" alt="Logo"></a>
    </div>
    <div class="card">
        <div class="title">

            <?php
            if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
                $id = $_GET['id'];
                try{
                    $stmt = $pdo->prepare('DELETE FROM CATEGORIA WHERE CATEGORIA_ID = :id');
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
        
                    if($stmt->rowCount() > 0){
                        $mensagem = "Categoria excluída com sucesso!";
                    } else {
                        $mensagem = "Infelizmente, houve um erro! Tente novamente mais tarde.";
                    }
                } catch (PDOException $e){
                    echo "<p style='color=white;'>Infelizmente, houve um erro! Tente novamente mais tarde.";
                }
            }
            ?>
        </div>
        <div>
            <button class="btn" id="signIn" onclick="window.location.href = 'listar_categoria.php';">Voltar</button>
        </div>
    </div>
</body>

</html>