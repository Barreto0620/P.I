# README - Projeto de API

# Introdução

Bem-vindo ao README do projeto bimestral da disciplina de Linguagem de Script para WEB. Aqui, você encontrará informações essenciais sobre a criação de uma API em Node.js, combinada com um frontend em HTML, para a visualização de dados de viagens. Este documento foi elaborado para fornecer instruções detalhadas sobre a configuração, execução e utilização do projeto, além de destacar os principais elementos presentes no código-fonte.

---

# Requisitos

### API em Node.js

A API RESTful é desenvolvida em Node.js utilizando o framework Express.js para o gerenciamento de rotas e manipulação de dados. O código-fonte está disponível no arquivo `index.js`.

Para instalar o framework Express.js utilizando o npm (Node Package Manager), você pode seguir estes passos:

1. Certifique-se de ter o Node.js instalado em seu sistema. Você pode baixá-lo e instalá-lo a partir do site oficial: [Node.js](https://nodejs.org/).
2. Abra o terminal ou prompt de comando.
3. Navegue até o diretório do seu projeto.
4. Execute o seguinte comando para inicializar um novo projeto Node.js e criar um arquivo `package.json`, que é onde as informações sobre as dependências do projeto serão armazenadas:
    
    ```bash
    npm init -y
    
    ```
    
5. Agora, você pode instalar o Express.js usando o seguinte comando:
    
    ```bash
    npm install express
    
    ```
    

Após executar esses comandos, o Express.js será instalado no seu projeto e as dependências serão gerenciadas pelo npm. Você pode então importar o Express.js nos seus arquivos JavaScript conforme necessário. Por exemplo, em seu arquivo `index.js`, você pode importar o Express.js da seguinte maneira:

```jsx
const express = require('express');

```

Isso permitirá que você use o Express.js para criar seu servidor web e definir rotas para sua API.

---

### Banco de Dados JSON

Um arquivo JSON é utilizado como banco de dados para simular dados fictícios relacionados a destinos de viagens. Cada arquivo JSON representa um continente, e contém informações sobre diferentes destinos nesse continente. Aqui está um exemplo de estrutura para um arquivo JSON representando destinos na América:

**Exemplo: `America.json`**

```json
[
  {
    "descricao": "Viagem para o Parque Nacional de Yellowstone, EUA.",
    "img": "<https://brasiltravelnews.com.br/wp-content/uploads/2021/09/yellowstone-parc-national.jpg>",
    "pais": "Estados Unidos",
    "dia_da_viagem": "Fechado",
    "ponto_turistico": "Parque Nacional de Yellowstone",
    "temporada": "Verão",
    "moeda": "Dólar americano (USD)",
    "valor_da_viagem": 300.00,
    "avaliacao": 4.5
  }
]

```

Este arquivo contém informações sobre três destinos de viagem na América. Cada objeto no array representa um destino e possui os seguintes atributos:

- `descricao`: Breve descrição da viagem.
- `img`: URL da imagem do destino.
- `pais`: País onde está localizado o destino.
- `dia_da_viagem`: Status da viagem (aberto ou fechado).
- `ponto_turistico`: Principal ponto turístico do destino.
- `temporada`: Estação do ano ideal para visitar o destino.
- `moeda`: Moeda oficial utilizada no país do destino.
- `valor_da_viagem`: Valor médio da viagem para o destino.
- `avaliacao`: Avaliação média do destino por viajantes.

---

### Frontend em HTML

O frontend em HTML se conecta à API para exibir os dados de viagens de forma amigável ao usuário. Abaixo está um exemplo de código HTML que demonstra como você pode criar uma página para exibir os destinos de viagem:

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinos de Viagem - América</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclua aqui o arquivo CSS para estilização -->
</head>

<body>
    <h1>Destinos de Viagem - América</h1>
    <div id="america-list" class="destinations">
        <!-- Os destinos de viagem serão adicionados dinamicamente aqui pelo JavaScript -->
    </div>

    <script src="script.js"></script> <!-- Inclua aqui o arquivo JavaScript para interação com a API -->
</body>

</html>

```

Neste exemplo uma página é criada para exibir os destinos de viagem na América. A div com o ID `america-list` será preenchida dinamicamente pelo JavaScript com os dados dos destinos de viagem obtidos da API.

---

### Configuração e Execução do Projeto

1. **Configuração da API:**
    
    Para configurar e executar a API do projeto, siga estas etapas:
    
    - **Instalação do Node.js:**
    Certifique-se de ter o Node.js instalado em seu sistema. Você pode baixá-lo e instalá-lo a partir do site oficial: [Node.js](https://nodejs.org/).
    - **Clone o Repositório:**
    Baixe ou clone o repositório do projeto em seu computador local.
        
        ```bash
        git clone <https://github.com/seu-usuario/nome-do-repositorio.git>
        
        ```
        
    - **Navegue até o Diretório do Projeto:**
    Abra um terminal e navegue até o diretório do projeto clonado usando o comando `cd`.
        
        ```bash
        cd nome-do-repositorio
        
        ```
        
    - **Instale as Dependências do Projeto:**
    Utilize o comando `npm install` para instalar todas as dependências do projeto listadas no arquivo `package.json`.
        
        ```bash
        npm install
        
        ```
        
    - **Execute a API:**
    Após a instalação das dependências, você pode iniciar a API executando o arquivo `index.js` com o Node.js.
        
        ```bash
        node index.js
        
        ```
        
    - **Acesso à API:**
    Após iniciar a API, ela estará disponível em `http://localhost:8080`.
        
        Você pode acessar os endpoints da API adicionando o caminho correspondente ao nome do continente desejado. Por exemplo:
        
        - http://localhost:8080/Africa
        - http://localhost:8080/Oceania
        - http://localhost:8080/Europa
        - http://localhost:8080/America
        - http://localhost:8080/Asia
        
        ---
        

# Funcionalidades das Telas

### Funções

O código JavaScript responsável por manipular os dados da API e exibi-los na página é uma função que utiliza `fetch` para obter os dados e `forEach` para iterar sobre eles e criar elementos HTML dinamicamente.

O trecho de código para a função de busca e exibição dos dados da API é:

```jsx
fetch("<http://localhost:8080/America>")
  .then((response) => response.json())
  .then((data) => {
    const americaList = document.getElementById("america-list");
    data.forEach((America) => {
      const americaDiv = document.createElement("div");
      americaDiv.innerHTML = `
      <div class="container_paises">
      <img src="${America.img}" alt="${America.pais}">
      <div class="text_desc">
      <h2 class="nome_pais">${America.pais}</h2>
      <p><strong>Data do Próximo Vôo:</strong> ${America.dia_da_viagem}</p>
      <p><strong>Ponto Turístico:</strong> ${America.ponto_turistico}</p>
      <p><strong>Temporada:</strong> ${America.temporada}</p>
      <p><strong>Moeda Oficial:</strong> ${America.moeda}</p>
      <p><strong>Por que Visitar:</strong> ${America.descricao}</p>
      <p><strong>Avaliação do País:</strong> ${America.avaliacao}</p>
      <p><strong>Valor da viagem:</strong> ${America.valor_da_viagem}</p>
      <button onclick="alert('Passagem esgotada')">Comprar Passagem</button>
      </div>
      </div>`;
      americaList.appendChild(americaDiv);
    });
  })
  .catch((error) => console.error("Erro ao carregar os países:", error));

function removeAccents(str) {
  return str.normalize("NFD").replace(/[\\u0300-\\u036f]/g, "");
}
```

---

### Alertas

Um alerta é exibido ao clicar no botão "Comprar Passagem", informando que a passagem está esgotada. O trecho de código responsável por isso é:

```jsx
<button onclick="alert('Passagem esgotada')">Comprar Passagem</button>

```

---

### Gráficos

Para incluir gráficos, adicione o seguinte código HTML onde deseja exibir o gráfico:

```html
<div class="chart">
    <canvas id="meuGrafico"></canvas>
</div>

```

---

### Inputs

A barra de pesquisa permite a filtragem de destinos por nome, conforme o usuário digita na barra de pesquisa. O trecho de código para o campo de entrada é:

```html
<input type="text" id="searchInput" placeholder="Pesquise um destino..." onkeyup="search_bar()">

```

---

### Redirecionamentos

Os botões de redirecionamento direcionam o usuário para as páginas correspondentes de cada continente. Os botões estão presentes na página inicial de cada continente e são implementados da seguinte forma:

```html
<button onclick="window.location.href = '../africa/africa.html'">África</button>
<button onclick="window.location.href = '../oceania/oceania.html'">Oceania</button>
<button onclick="window.location.href = '../europa/europa.html'">Europa</button>
<button onclick="window.location.href = '../asia/asia.html'">Ásia</button>

```

---

# **Participações**

- Gabriele Lopes
- Gabriel Victor Barreto de Oliveira
- Geovanna Cardoso da Cunha
- Giovanna Piccinato
- Lucas Ryan

---