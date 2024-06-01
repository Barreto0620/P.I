<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
	header('Location:login.php');
	exit(); // se não houver permissão do usuário, interrompe o programa e não mostra as demais informações.
}

try {
	$stmt = $pdo->prepare("SELECT * FROM CATEGORIA"); // Seleciona todas as colunas da tabela CATEGORIA
	$stmt->execute();
	$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna um array associativo com os resultados da consulta
} catch (PDOException $e) {
	echo "<p style='color=red;'> Erro ao listar categorias: " . $e->getMessage() . "</p>"; // getMessage deixa a mensagem de erro mais resumida.
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lista de Categorias</title>
</head>

<body>
	<!DOCTYPE html>
	<html lang="pt-br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<link rel="stylesheet" href="css/lista_categorias.css">
		<link rel="stylesheet" href="css/stars_.css">
		<title>Lista de Produtos | Games Space</title>

	</head>

	<body>

		<section class="bg-stars">
			<span class="star"></span>
			<span class="star"></span>
			<span class="star"></span>
			<span class="star"></span>


			<header>
				<div id="stars"></div>
				<a href="painel_admin.php"><img src="./img/voltar.png" class="xis" alt="Voltar"></a>
				<h1>Lista de Categorias</h1>
			</header>

			<table>
				<thead> <!-- irá deixar o HTML de forma semantica  -->
					<tr>
						<th> ID </th>
						<th> Nome </th>
						<th> Descrição </th>
						<th> Status </th>
						<th>Editar</th>
						<th>Excluir</th>
					</tr>
				</thead>


				<?php foreach ($categorias as $categoria) : // jogando de produtos para produto.
				?>
					<tr>
						<td><?php echo $categoria['CATEGORIA_ID']; ?></td>
						<td><?php echo $categoria['CATEGORIA_NOME']; ?></td>
						<td><?php echo $categoria['CATEGORIA_DESC']; ?></td>
						<td><?php echo $categoria['CATEGORIA_ATIVO'] == 1 ? 'Ativo' : 'Inativo'; ?></td>
						<td>
							<a href="editar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn">✍</a>
						</td>
						<td>
							<a href="#" class="action-btn delete-btn" onclick="confirmarClique(<?php echo $categoria['CATEGORIA_ID']; ?>)">❌</a>
						</td>
					</tr>
				<?php endforeach; ?>

		</section>
	</body>
	<script src="js/excluir_categoria.js"></script>

	</html>