<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
	header('Location: login.php');
	exit();
}

try {
	$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
	$stmt_categoria->execute();
	$categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "<p style='color: red;'>Erro ao buscar categorias: " . $e->getMessage() . "</p>";
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" sizes="32x32" href="./img/logo_1.png">
	<link rel="stylesheet" href="css/cadastrar_produto.css">
	<link rel="stylesheet" href="css/estrelas_.css">
	<title>Cadastro de Produtos | Games Space</title>
</head>

<body>
	<div class="block"></div>
	<div id="stars"></div>
	<div id="stars2"></div>
	<div id="stars3"></div>
	<header>
		<a href="painel_admin.php"><img class="logo" src="./img/logo_1.png" alt="Foto da loja de Games"></a>
	</header>

	<script>
		// Função para adicionar um novo campo de imagem URL
		function adicionarImagem() {
			const containerImagens = document.getElementById('containerImagens');
			const novoDiv = document.createElement('div');
			novoDiv.className = 'imagem-input';

			const novoInputURL = document.createElement('input');
			novoInputURL.type = "text";
			novoInputURL.name = 'imagem_url[]';
			novoInputURL.placeholder = 'Adicionar';
			novoInputURL.required = true;

			const novoInputOrdem = document.createElement('input');
			novoInputOrdem.type = "number";
			novoInputOrdem.name = 'imagem_ordem[]';
			novoInputOrdem.placeholder = 'Ordem';
			novoInputOrdem.min = "1";
			novoInputOrdem.required = true;

			const botaoRemover = document.createElement('button');
			botaoRemover.type = "button";
			botaoRemover.className = 'remove-button';
			botaoRemover.textContent = "❌";
			botaoRemover.onclick = function() {
				containerImagens.removeChild(novoDiv);
			};

			novoDiv.appendChild(novoInputURL);
			novoDiv.appendChild(novoInputOrdem);
			novoDiv.appendChild(botaoRemover);

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
				<textarea name="descricao" class="input-desc" id="descricao" placeholder="Descrição" required></textarea>
				<label for="categoria_id"></label>
				<select name="categoria_id" id="categoria_id" required>
					<?php foreach ($categorias as $categoria) : ?>
						<option value="<?php echo $categoria['CATEGORIA_ID']; ?>"> <?php echo $categoria['CATEGORIA_NOME']; ?></option>
					<?php endforeach; ?>
				</select>
				<input type="button" name="next" class="next action-button" value="Próximo" />
			</fieldset>
			<fieldset class="button-container">
				<h2 class="fs-title">Definir o Valor</h2>
				<h3 class="fs-subtitle">Por favor, defina o valor</h3>
				<label for="preco"></label>
				<input type="number" name="preco" id="preco" step="0.01" placeholder="Preço" required />
				<label for="quantidade"></label>
				<input type="number" name="quantidade[]" id="quantidade" step="1.00" placeholder="Quantidade" />
				<label for="desconto"></label>
				<input type="number" name="desconto" id="desconto" step="0.01" placeholder="Desconto" />
				<input type="button" name="previous" class="previous action-button" value="Anterior" />
				<input type="button" name="next" class="next action-button" value="Próximo" />
			</fieldset>
			<fieldset>
				<h2 class="fs-title">Defina a Imagem</h2>
				<h3 class="fs-subtitle">Por favor, escolha as imagens</h3>
				<label for="imagem"></label>
				<div id="containerImagensWrapper">
					<div id="containerImagens">
						<div class="imagem-input">
							<input type="text" name="imagem_url[]" placeholder="Adicionar">
							<input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1">
						</div>
					</div>
				</div>
				<button type="button" class="buttonImagens" onclick="adicionarImagem()"> Adicionar mais Imagens</button>
				<div class="ativo_span">
					<label for="ativo"></label>
					<span>Ativo:</span>
					<input type="checkbox" name="ativo" id="ativo" value="1" checked>
				</div>
				<input type="button" name="previous" class="previous action-button" value="Anterior" />
				<button type="submit" class="action-button">Cadastrar</button>
			</fieldset>

			<?php

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$nome = $_POST['nome'];
				$descricao = $_POST['descricao'];
				$preco = $_POST['preco'];
				$desconto = $_POST['desconto'];
				$categoria_id = $_POST['categoria_id'];
				$ativo = isset($_POST['ativo']) ? 1 : 0;
				$imagem_urls = $_POST['imagem_url'];
				$imagem_ordens = $_POST['imagem_ordem'];
				$quantidade = $_POST['quantidade'];

				// Validação do preço
				if ($preco > 99999999.99 || $preco < 0) {
					echo "<p style='color: red;'>Erro: O preço deve estar entre 0 e 99999999.99</p>";
				} else {
					try {
						$sql = "INSERT INTO PRODUTO (PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) 
					VALUES (:nome, :descricao, :preco, :desconto, :categoria_id, :ativo)";

						$stmt = $pdo->prepare($sql);
						$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
						$stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
						$stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
						$stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
						$stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
						$stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
						$stmt->execute();

						$produto_id = $pdo->lastInsertId();

						foreach ($imagem_urls as $index => $url) {
							$ordem = $imagem_ordens[$index];
							$sql_imagem = "INSERT INTO PRODUTO_IMAGEM (IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM) 
							   VALUES (:imagem_url, :produto_id, :imagem_ordem)";

							$stmt_imagem = $pdo->prepare($sql_imagem);
							$stmt_imagem->bindParam(':imagem_url', $url, PDO::PARAM_STR);
							$stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
							$stmt_imagem->bindParam(':imagem_ordem', $ordem, PDO::PARAM_INT);
							$stmt_imagem->execute();
						}

						foreach ($quantidade as $quantidades) {
							$sql_quantidade = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) 
								   VALUES (:produto_id, :quantidade)";

							$stmt_quantidade = $pdo->prepare($sql_quantidade);
							$stmt_quantidade->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
							$stmt_quantidade->bindParam(':quantidade', $quantidades, PDO::PARAM_INT);
							$stmt_quantidade->execute();
						}

						echo "<p style='color: green;'>Produto cadastrado com sucesso!</p>";
					} catch (PDOException $e) {
						echo "<p style='color: red;'>Erro ao cadastrar o produto: " . $e->getMessage() . "</p>";
					}
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