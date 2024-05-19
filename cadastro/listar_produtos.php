<?php 
	session_start();
	require_once('conexao.php');

if(!isset($_SESSION['admin_logado'])){
	header('Location:login.php');
	exit(); // se nao houver a permissão do usuario, irá parar o programa e nao aparecerá as demais informações.
}

try {
	$stmt = $pdo->prepare("SELECT PRODUTO.*,CATEGORIA.CATEGORIA_NOME,PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD
	FROM PRODUTO
	JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
	LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
	LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID");
	$stmt -> execute();
	$produtos = $stmt ->fetchAll(PDO::FETCH_ASSOC); // irá voltar no formato de um array associativo - onde cada coluna será uma chave. ex: [id=1, nome=logo,]...
} catch(PDOException $e){
	echo "<p style='color=red;'> Erro ao listar produtos: " . $e->getMessage() . "</p>"; // getMessage irá deixar a msg de erro mais resumida.
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
	<link rel="stylesheet" href="css/lista_produto.css">
	<link rel="stylesheet" href="css/stars_.css">
	<title>Lista de Produtos</title>

</head>
<body>
<header>
    <div id="stars"></div>
    <a href="painel_admin.php"><img src="./img/voltar.png" class="xis" alt="Voltar"></a>
    <h1>Lista de Produtos</h1>
    </header>

	<table>
		<thead> <!-- irá deixar o HTML de forma semantica  -->
			<tr>
				<th> ID </th>
				<th> Nome </th>
				<th> Descrição </th>
				<th> Preço </th>
				<th> Categoria </th>
				<th> Ativo </th>
				<th> Desconto </th>
				<th> Estoque </th>
				<th> Imagem </th>
				<th>Editar</th>
                <th>Excluir</th>
			</tr>
		</thead>
		<?php foreach($produtos as $produto): // jogando de produtos para produto.?>
		<tr>
			<td><?php echo $produto['PRODUTO_ID']; ?></td>
			<td><?php echo $produto['PRODUTO_NOME']; ?></td>
			<td><?php echo $produto['PRODUTO_DESC']; ?></td>
			<td><?php echo $produto['PRODUTO_PRECO']; ?></td>
			<td><?php echo $produto['CATEGORIA_NOME']; ?></td>
			<td><?php echo $produto['PRODUTO_ATIVO']; ?></td>
			<td><?php echo $produto['PRODUTO_DESCONTO']; ?></td>
			<td><?php echo $produto['PRODUTO_QTD']; ?></td>
			<td><img src="<?php echo $produto['IMAGEM_URL']; ?>" 
			alt="Imagem do Produto" width="50"></td>
			<td><a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID'];?>" class="action-btn">✍</a></td>  <!-- irá buscar o link via GET para que busque essa pasta e apareça a mensagem  -->	
			<td><a href="excluir_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn delete-btn" onclick="return confirmarClique()">❌</a></td>
		</tr>
		<?php endforeach;?>
	</table>
	
</body>
<script src="js/excluir_produto.js"></script>

</html>