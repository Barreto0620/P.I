<?php
//uma sessão é iniciada e verifica-se se um administrador está logado. Se não estiver, ele é redirecionado para a página de login.
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

//o script faz uma conexão com o banco de dados, usando os detalhes de configuração especificados em conexao.php
require_once('conexao.php');

//busca categoria
try{
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria ->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "<p style='color:red;'> Erro ao buscar categorias:" .$e->getMessage()."</p>";
}

// Se a página foi acessada via método GET, o script tenta recuperar os detalhes do produto com base no ID passado na URL.
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            // Consulta para recuperar os detalhes do produto
            $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME, PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_IMAGEM.IMAGEM_ORDEM, PRODUTO_ESTOQUE.PRODUTO_QTD 
            FROM PRODUTO 
            INNER JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
            LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
            LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID
            WHERE PRODUTO.PRODUTO_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            // Consulta para recuperar as imagens do produto específico
            $stmt_imagem = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :id");
            $stmt_imagem->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_imagem->execute();
            $imagem_url = $stmt_imagem->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header('Location: listar_produtos.php');
        exit();
    }
}


// Se o formulário de edição foi submetido, a página é acessada via método POST, e o script tenta atualizar os detalhes do produto no banco de dados com as informações fornecidas no formulário.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $categoria_id = $_POST['categoria_id'];
    $produto_qtd = $_POST['qtd'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $imagem_url = $_POST['imagem_url'];
    $imagem_ordem = $_POST['imagem_ordem'];


    try {


        if (isset($_POST['imagem_url']) && isset($_POST['imagem_ordem'])) {
            foreach ($_POST['imagem_url'] as $index => $url) {
                if (!empty($url) && isset($_POST['imagem_ordem'][$index])) {
                    $ordem = $_POST['imagem_ordem'][$index];
                    $imagem_id = $_POST['imagem_id'][$index]; // Certifique-se de incluir campos ocultos com imagem_id em seu formulário
            
                    // Atualizar cada entrada de imagem
                    $stmt_imagem = $pdo->prepare("UPDATE PRODUTO_IMAGEM SET IMAGEM_ORDEM = :imagem_ordem, IMAGEM_URL = :imagem_url WHERE PRODUTO_ID = :id AND IMAGEM_ID = :imagem_id");
                    
                    $stmt_imagem->bindParam(':imagem_url', $url, PDO::PARAM_STR);
                    $stmt_imagem->bindParam(':imagem_ordem', $ordem, PDO::PARAM_INT);
                    $stmt_imagem->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt_imagem->bindParam(':imagem_id', $imagem_id, PDO::PARAM_INT);
                    $stmt_imagem->execute();
                }
            }
        }
        

        $stmtProdutoEstoque = $pdo->prepare("UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :qtd WHERE PRODUTO_ID = :id");
        $stmtProdutoEstoque->bindParam(':qtd',$produto_qtd,PDO::PARAM_STR);
        $stmtProdutoEstoque->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtProdutoEstoque->execute();

        $stmt = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, PRODUTO_DESCONTO = :desconto, CATEGORIA_ID = :categoria_id,  PRODUTO_ATIVO = :ativo WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: listar_produtos.php');
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
    <link rel="stylesheet" href="css/editar_produto.css">
    <link rel="stylesheet" href="css/stars_.css">
    <title>Editar Produto | Games Space</title>
</head>

<body>
    <div class="block">
    </div>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <header>
        <a href="listar_produtos.php"><img class="logo" src="./img/logo_1.png" alt="Foto da loja de Games"></a>
    </header>
    <!-- Essa linha cria um campo de entrada (input) oculto no formulário. Um campo de entrada oculto é usado quando você quer incluir um dado no formulário que não precisa ser visível ou editável pelo usuário, mas que precisa ser enviado junto com os outros dados quando o formulário é submetido. -->

    <div class="register-box">
        <form action="editar_produto.php" method="post" id="msform" class="form">
            <!-- progressbar -->
            <ul id="progressbar">
                <li class="active">Descrição</li>
                <li>Valor</li>
                <li>Imagem</li>
            </ul>
            <!-- fieldsets -->

            <input type="hidden" name="id" value="<?php echo $produto['PRODUTO_ID']; ?>">

            <fieldset>

                <h2 class="fs-title">Editar Produto</h2>
                <h3 class="fs-subtitle">Editando a descrição do produto</h3>


                <label for="nome"></label>
                <input type="text" name="nome" id="nome" placeholder="Nome" value="<?php echo $produto['PRODUTO_NOME']; ?>">


                <label for="descricao"></label>
                <input type="text" name="descricao" id="descricao" placeholder="Descrição" value="<?php echo $produto['PRODUTO_DESC']; ?>">

                <label for="categoria_nome"></label>
                <select name="categoria_id" id="categoria_id" required>
                    <?php foreach ($categorias as $categoria) : ?>
                        <option value="<?= $categoria['CATEGORIA_ID'] ?>">
                            <?= $categoria['CATEGORIA_NOME'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="button" name="next" class="next action-button" value="Proximo" />

            </fieldset>


            <fieldset class="button-container">

                <h2 class="fs-title">Definir o Valor</h2>

                <h3 class="fs-subtitle">Por favor, defina o valor</h3>


                <label for="preco"></label>
                <input type="number" name="preco" id="preco" step="0.01" placeholder="Preço" value="<?php echo $produto['PRODUTO_PRECO']; ?>">


                <label for="qtd"></label>
                <input type="number" name="qtd" id="qtd" step="1.00" placeholder="Estoque" value="<?php echo $produto['PRODUTO_QTD']; ?>">

                <label for="desconto"></label>
                <input type="number" name="desconto" id="desconto" step="0.01" placeholder="Desconto" value="<?php echo $produto['PRODUTO_DESCONTO']; ?>">

                <input type="button" name="previous" class="previous action-button" value="Anterior" />
                <input type="button" name="next" class="next action-button" value="Proximo" />

            </fieldset>
            <fieldset>
                <h2 class="fs-title">Defina a Imagem</h2>
                <h3 class="fs-subtitle">Por favor, escolha as imagens</h3>

                <div id="containerImagens"></div>
                <div class="imagem-section">



                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $id = $_POST['id'];
                    }

                    $stmt = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $imagem_url = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($imagem_url as $imagem) {
                        // $valorPadrao = isset($_GET['valor']) ? $_GET['valor'] : "Valor Padrão";
                        echo "<input type='hidden' name='imagem_id[]' value='{$imagem['IMAGEM_ID']}'>";
                        echo '<input type="text" name="imagem_url[]" placeholder="Adicionar" value="' . $imagem['IMAGEM_URL'] . '">';
                        echo '<input type="text" name="imagem_ordem[]" placeholder="Ordem" value="' . $imagem['IMAGEM_ORDEM'] . '">';
                    }

                    ?>
                </div>
                <div class="ativo_span">
                    <label for="ativo"></label>
                    <span>Ativo:</span>
                    <input type="checkbox" name="ativo" id="ativo" value="1" checked>
                </div>



                <input type="button" name="previous" class="previous action-button" value="Anterior" />

                <button type="submit" class="action-button">Editar</button>
            </fieldset>

        </form>
    </div>

    <div>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="./js/teste_1.js"></script>
</body>

</html>