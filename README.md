# Games Space - Projeto Integrador SENAC

## 🌐 Visão Geral
O **Games Space** é um projeto integrador desenvolvido para consolidar conhecimentos adquiridos em **PHP, HTML, JavaScript, CSS e Banco de Dados**. O sistema implementa um **CRUD** (Create, Read, Update, Delete) completo para a administração de produtos e categorias. Este projeto foi desenvolvido por **Gabriel Barreto** e **Lusxka**.

## 🛠️ Funcionalidades Principais
O sistema permite a gestão completa de administradores, produtos e categorias, incluindo:

### 👤 CRUD de Administradores:
- Cadastro de novos administradores.
- Listagem dos administradores cadastrados.
- Atualização das informações dos administradores.
- Remoção de administradores.

### 🏢 CRUD de Produtos:
- Adição de novos produtos ao catálogo.
- Visualização detalhada dos produtos.
- Edição das informações dos produtos.
- Exclusão de produtos do sistema.

### 🌟 CRUD de Categorias:
- Criação de novas categorias.
- Listagem das categorias existentes.
- Modificação das categorias.
- Deleção de categorias.

## 💪 Tecnologias Utilizadas
- **PHP**: Desenvolvimento da lógica de servidor e manipulação de dados.
- **HTML5**: Estruturação das páginas web.
- **JavaScript**: Adição de interatividade e dinamismo.
- **CSS3**: Estilização responsiva e moderna.
- **MySQL**: Gerenciamento de banco de dados via **phpMyAdmin**.

## 📚 Estrutura do Projeto
- **/admin**: Gerenciamento de administradores.
- **/products**: Gerenciamento de produtos.
- **/categories**: Gerenciamento de categorias.
- **/css**: Arquivos de estilização (CSS).
- **/js**: Scripts JavaScript.
- **/db**: Scripts SQL para criação e manutenção do banco de dados.

## 🛠️ Instalação e Configuração
1. Clone o repositório para o seu ambiente de desenvolvimento:
   ```bash
   git clone https://github.com/seu-usuario/games-space.git
   ```
2. Configure o servidor web (Apache, Nginx, etc.) para apontar para o diretório do projeto.
3. Importe o banco de dados utilizando o phpMyAdmin ou MySQL:
   ```bash
   mysql -u seu_usuario -p sua_senha < db/games_space.sql
   ```
4. Configure a conexão com o banco de dados no arquivo `db/config.php`:
   ```php
   <?php
   $servername = "localhost";
   $username = "seu_usuario";
   $password = "sua_senha";
   $dbname = "games_space";
   ?>
   ```

## 💻 Utilização
Acesse o sistema pelo navegador no endereço configurado (exemplo: `http://localhost/games-space`). Utilize a interface administrativa para gerenciar administradores, produtos e categorias.

## 👥 Contribuidores
- **Gabriel Barreto**
- **Lusxka**

Agradecemos a todos os envolvidos no desenvolvimento do **Games Space** e esperamos que ele seja uma ferramenta eficiente para a gestão de produtos e categorias.

## 🌟 Licença
Este projeto está licenciado sob os termos da [MIT License](LICENSE).

