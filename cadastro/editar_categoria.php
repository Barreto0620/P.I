<?php
//uma sessão é iniciada e verifica-se se um administrador está logado. Se não estiver, ele é redirecionado para a página de login.
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

//o script faz uma conexão com o banco de dados, usando os detalhes de configuração especificados em conexao.php
require_once('conexao.php');

// Se a página foi acessada via método GET, o script tenta recuperar os detalhes do produto com base no ID passado na URL.
if ($_SERVER['REQUEST_METHOD'] == 'GET') { //A superglobal $_SERVER é um array que contém informações sobre cabeçalhos, caminhos e locais de scripts. O REQUEST_METHOD é um dos índices deste array e é usado para determinar qual método de requisição foi utilizado para acessar a página, seja ele GET, POST, PUT, entre outros
    
    if (isset($_GET['id'])) { //$_GET é uma superglobal em PHP, o que significa que ela está disponível em qualquer lugar do seu script, sem necessidade de definição ou importação global. Ela contém dados enviados através da URL (também conhecidos como parâmetros de query string). Quando um usuário acessa uma URL como http://exemplo.com/pagina.php?id=123, o valor 123 é passado para o script pagina.php através do método GET, e você pode acessá-lo com $_GET['id'].
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM CATEGORIA WHERE CATEGORIA_ID = :id");//Quando você executa uma consulta SELECT no banco de dados usando PDO e utiliza o método fetch(PDO::FETCH_ASSOC), o resultado é um array associativo, onde cada chave do array é o nome de uma coluna da tabela no banco de dados, e o valor associado a essa chave é o valor correspondente daquela coluna para o registro selecionado
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); //PDO::PARAM_INT especifica que o valor é um inteiro. Isso é útil para o PDO saber como tratar o valor antes de enviá-lo ao banco de dados.  Especificar o tipo de dado pode melhorar o desempenho e a segurança da sua aplicação. É uma constante da classe PDO que representa o tipo de dado inteiro para ser usado com métodos como bindParam()
            $stmt->execute();
            $adm = $stmt->fetch(PDO::FETCH_ASSOC);//$produto é um array associativo que contém os detalhes do produto que foi recuperado do banco de dados. Por exemplo, se a tabela de produtos tem colunas como ID, NOME, DESCRICAO, PRECO, e URL_IMAGEM, então o array $produto terá essas chaves, e você pode acessar os valores correspondentes usando a sintaxe de colchetes, 
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header('Location: listar_categoria.php');
        exit();
    }
}

// Se o formulário de edição foi submetido, a página é acessada via método POST, e o script tenta atualizar os detalhes do produto no banco de dados com as informações fornecidas no formulário.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $ativo = isset($_POST['ativo'])? 1 : 0;

    try {
        $stmt = $pdo->prepare("UPDATE CATEGORIA SET CATEGORIA_NOME = :nome, CATEGORIA_DESC = :descricao, CATEGORIA_ATIVO = :ativo WHERE CATEGORIA_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: listar_categoria.php');
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
    <link rel="stylesheet" href="./css/editar_categoria.css">
    <title>Editar Categoria | Games Space</title>
</head>

<body>
    <header>
            <a href="listar_categoria.php"><img class="logo" src="./img/logo_1.png" alt="Foto da loja de Games"></a>
        </header>

<div class="conteiner">
    <form action="" class="form" method="post" enctype="multipart/form-data">
        <div class="form-title"><span>Editar Categoria</span></div>
        <div class="title-2"><span>DELTA</span></div>
        <div class="input-container">
    <input type="hidden" name="id" value="<?php echo $adm['CATEGORIA_ID']; ?>"> 
    <!-- Essa linha cria um campo de entrada (input) oculto no formulário. Um campo de entrada oculto é usado quando você quer incluir um dado no formulário que não precisa ser visível ou editável pelo usuário, mas que precisa ser enviado junto com os outros dados quando o formulário é submetido. -->
    <label for="nome"></label>
    <input type="text" name="nome" id="nome" placeholder="Nome" value="<?php echo $adm['CATEGORIA_NOME']; ?>"><br>
    <label for="descricao"></label>
    <textarea name="descricao" id="descricao" class="input-desc" placeholder="Descrição"><?php echo $adm['CATEGORIA_DESC']; ?></textarea>
    <label for="ativo">
    <span class="ativo_span">Ativo:</span>
    <input type="checkbox" name="ativo" id="ativo" checked value="<?php echo $adm['CATEGORIA_ATIVO']; ?>"><br>
    </label>
    <button type="submit" class="submit">Editar</button>
</form>
</body>
</html>

