<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
	header('Location:login.php');
	exit();
}

try {
	$stmt = $pdo->prepare("SELECT PRODUTO.*,CATEGORIA.CATEGORIA_NOME,PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD
        FROM PRODUTO
        JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
        LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
        LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID");
	$stmt->execute();
	$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "<p style='color=red;'> Erro ao listar produtos: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<link rel="stylesheet" href="css/lista_produto_.css">
	<link rel="stylesheet" href="css/stars_.css">
	<title>Lista de Produtos | Games Space</title>
</head>

<body>
	<header>
		<div id="stars"></div>
		<a href="painel_admin.php"><img src="./img/voltar.png" class="xis" alt="Voltar"></a>
		<h1>Lista de Produtos</h1>
		<div class="search-container">
			<input type="text" id="searchInput" placeholder="Pesquisar...">
		</div>
	</header>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Descrição</th>
				<th>Preço</th>
				<th>Categoria</th>
				<th>Status</th>
				<th>Desconto</th>
				<th>Estoque</th>
				<th>Imagem</th>
				<th>Editar</th>
				<th>Excluir</th>
			</tr>
		</thead>
		<tbody id="table_body">
			<?php foreach ($produtos as $produto) : ?>
				<tr>
					<td><?php echo $produto['PRODUTO_ID']; ?></td>
					<td><?php echo $produto['PRODUTO_NOME']; ?></td>
					<td><?php echo $produto['PRODUTO_DESC']; ?></td>
					<td><?php echo $produto['PRODUTO_PRECO']; ?></td>
					<td><?php echo $produto['CATEGORIA_NOME']; ?></td>
					<td><?php echo $produto['PRODUTO_ATIVO'] == 1 ? 'Ativo' : 'Inativo'; ?></td>
					<td><?php echo $produto['PRODUTO_DESCONTO']; ?></td>
					<td><?php echo $produto['PRODUTO_QTD']; ?></td>
					<td><img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="Imagem do Produto" width="50"></td>
					<td><a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn">✍</a></td>
					<td><a href="#" class="action-btn delete-btn" onclick="confirmarClique(<?php echo $produto['PRODUTO_ID']; ?>)">❌</a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>
<script src="js/pesquisa.js"></script>
<script src="js/excluir_produto.js"></script>

</html>