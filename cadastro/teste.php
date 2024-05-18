<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
	header('Location:login.php');
	exit();
}

try {
	$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
	$stmt_categoria->execute();
	$categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "<p style='color=red;'> Erro ao buscar categorias" . $e->getMessage() . "</p>";
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/teste_.css">
	<link rel="stylesheet" href="./css/stars_3.css">
	<title>Cadastro de Produtos</title>
</head>

<body>
	<div class="block">
	</div>
	<div id="stars"></div>
	<div id="stars2"></div>
	<div id="stars3"></div>
	<header>
		<a href="painel_admin.php"><img class="logo" src="./img/logo_1.png" alt="Foto da loja de Games"></a>
	</header>

	<script>
		//irá adicionar um novo campo de imagem URL
		function adicionarImagem() {
			const containerImagens = document.getElementById('containerImagens');
			const novoDiv = document.createElement('div');
			novoDiv.className = 'imagem-input';

			const novoInputURL = document.createElement('input');
			novoInputURL.type = "text";
			novoInputURL.name = 'imagem_url[]';
			novoInputURL.placeholder = 'URL da Imagem';
			novoInputURL.required = true;

			const novoInputOrdem = document.createElement('input');
			novoInputOrdem.type = "number";
			novoInputOrdem.name = 'imagem_ordem[]';
			novoInputOrdem.placeholder = 'Ordem da Imagem';
			novoInputOrdem.min = "1";
			novoInputOrdem.required = true;

			novoDiv.appendChild(novoInputURL);
			novoDiv.appendChild(novoInputOrdem);

			containerImagens.appendChild(novoDiv);
		}
	</script>

	<div class="register-box">
		<!-- multistep form -->

		<form action="" method="post" id="msform" class="form" enctype="multipart/form-data">
			<!-- progressbar -->
			<ul id="progressbar">
				<li class="active">Descrição</li>
				<li>Valor</li>
				<li>Imagem</li>
			</ul>
			<!-- fieldsets -->

			<fieldset>
				<h2 class="fs-title">Cadastrar Produtos</h2>
				<h3 class="fs-subtitle">Por favor, insira seu produto</h3>

				<label for="nome"></label>
				<input type="text" name="nome" id="nome" placeholder="Nome" required>
				<label for="descricao"></label>
				<input type="text" name="descricao" id="descricao" placeholder="Descrição" required>

				<label for="categoria_id"></label>
				<select name="categoria_id" id="categoria_id" required>
					<?php foreach ($categorias as $categoria) : ?>
						<option value="<?php echo $categoria['CATEGORIA_ID']; ?>"> <?php echo $categoria['CATEGORIA_NOME']; ?></option>
					<?php endforeach; ?>

				</select>

				<input type="button" name="next" class="next action-button" value="Proximo"/>

			</fieldset>

			<fieldset class="button-container"> <!-- Adicionando classe para container de botões -->
				<h2 class="fs-title">Definir o Valor</h2>

				<h3 class="fs-subtitle">Por favor, defina o valor</h3>

				<label for="preco"></label>
				<input type="number" name="preco" id="preco" step="0.01" placeholder="Preço" required />

				<label for="quantidade"></label>
				<input type="number" name="quantidade[]" id="quantidade" step="1.00" placeholder="Quantidade" />


				<label for="desconto"></label>
				<input type="number" name="desconto" id="desconto" step="0.01" placeholder="Desconto" />


				<input type="button" name="previous" class="previous action-button" value="Anterior" />
				<input type="button" name="next" class="next action-button" value="Proximo" />
			</fieldset>
			<fieldset>
				<h2 class="fs-title">Defina a Imagem</h2>
				<h3 class="fs-subtitle">Por favor, escolha as imagens</h3>
				<label for="imagem"></label>
				<div id="containerImagens">
					<input type="text" name="imagem_url[]" placeholder="Adicionar Imagem">
					<input type="number" name="imagem_ordem[]" placeholder="Ordem Imagem" min="1">
				</div>

				<button type="button" onclick="adicionarImagem()"> Adicionar mais Imagens</button>

			<div class="ativo_span">	
				<label for="ativo"></label>
				<span>Ativo:</span>
				<input type="checkbox" name="ativo" id="ativo" value="1" checked>
        	</div>

				

				<input type="button" name="previous" class="previous action-button" value="Anterior" />
				<button type="submit" class="action-button">Cadastrar</button>
			</fieldset>
			<?php

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {   //$_SERVER['REQUEST_METHOD'] retorna o metodo usado para acessar a pagina

				//criar um formulario com os nomes dessas variaveis
				$nome = $_POST['nome'];
				$descricao = $_POST['descricao'];
				$preco = $_POST['preco'];
				$desconto = $_POST['desconto'];
				$categoria_id = $_POST['categoria_id'];
				$ativo = isset($_POST['ativo']) ? 1 : 0;
				$imagem_urls = $_POST['imagem_url'];
				$imagem_ordens = $_POST['imagem_ordem'];
				$quantidade = $_POST['quantidade'];

				try {
					$sql = "INSERT INTO PRODUTO 
			(PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) 
			VALUES (:nome, :descricao, :preco, :desconto, :categoria_id, :ativo)";

					$stmt = $pdo->prepare($sql);

					$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
					$stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
					$stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
					$stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
					$stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
					$stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
					$stmt->execute();

					//pegando o id do ultimo produto inserido
					$produto_id = $pdo->lastInsertID();


					//Inserindo imagens no BD
					foreach ($imagem_urls as $index => $url) {
						$ordem = $imagem_ordens[$index];
						$sql_imagem = "INSERT INTO PRODUTO_IMAGEM (IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM)
					VALUES (:imagem_url, :produto_id, :imagem_ordem)";

						$stmt_imagem = $pdo->prepare($sql_imagem);

						$stmt_imagem->bindParam(':imagem_url', $url, PDO::PARAM_STR);
						$stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
						$stmt_imagem->bindParam(':imagem_ordem', $ordem, PDO::PARAM_STR);
						$stmt_imagem->execute();
					}
					echo "<p style='color:green;'> Produto cadastrado com sucesso!</p>";

					foreach ($quantidade as $quantidades) {
						$sql_quantidade = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD)
					VALUES (:produto_id, :quantidade)";

						$stmt_quantidade = $pdo->prepare($sql_quantidade);

						$stmt_quantidade->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
						$stmt_quantidade->bindParam(':quantidade', $quantidades, PDO::PARAM_STR);
						$stmt_quantidade->execute();
					}
				} catch (PDOException $e) {
					echo "<p style='color:red;'> Erro ao cadastrar o produto: " . $e->getMessage() . "</p>";
				}
			}

			?>
		</form>
	</div>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
	<script src="./js/teste_1.js"></script>

</body>


</html>