# Games Space - Projeto Integrador

## Visão Geral
Este repositório contém o projeto integrador **Games Space**, desenvolvido para consolidar conhecimentos adquiridos em PHP, HTML, JavaScript, CSS, e Banco de Dados. O projeto consiste na criação de um sistema CRUD (Create, Read, Update, Delete) para administração de produtos e categorias. Este projeto foi desenvolvido por **Gabriel Barreto** e **Lusxka**.

## Funcionalidades Principais
O sistema permite a gestão completa de administradores, produtos e categorias. As principais funcionalidades incluem:

1. **CRUD de Administradores**: 
   - Criação de novos administradores.
   - Leitura das informações dos administradores existentes.
   - Atualização de dados dos administradores.
   - Remoção de administradores.

2. **CRUD de Produtos**:
   - Adição de novos produtos ao catálogo.
   - Visualização detalhada dos produtos cadastrados.
   - Edição das informações dos produtos.
   - Exclusão de produtos do sistema.

3. **CRUD de Categorias**:
   - Criação de novas categorias de produtos.
   - Listagem das categorias existentes.
   - Modificação das categorias.
   - Deleção de categorias.

## Tecnologias Utilizadas
- **PHP**: Para o desenvolvimento da lógica de servidor e manipulação de dados.
- **HTML**: Estruturação das páginas web.
- **JavaScript**: Interatividade e dinamismo das páginas.
- **CSS**: Estilização e design do site.
- **Banco de Dados (MySQL)**: Armazenamento de dados, gerenciado através do **phpMyAdmin**.

## Estrutura do Projeto
- **/admin**: Contém as páginas e scripts para a gestão de administradores.
- **/products**: Contém as páginas e scripts para a gestão de produtos.
- **/categories**: Contém as páginas e scripts para a gestão de categorias.
- **/css**: Arquivos de estilização (CSS).
- **/js**: Scripts JavaScript.
- **/db**: Scripts SQL para criação e manutenção do banco de dados.

## Instalação e Configuração
1. Clone o repositório para o seu ambiente de desenvolvimento:
   ```bash
   git clone https://github.com/seu-usuario/games-space.git
   ```
2. Configure o servidor web (Apache, Nginx, etc.) para apontar para o diretório do projeto.
3. Importe o banco de dados usando o phpMyAdmin ou diretamente pelo MySQL:
   ```bash
   mysql -u seu_usuario -p sua_senha < db/games_space.sql
   ```
4. Configure o arquivo de conexão com o banco de dados (`db/config.php`) com as suas credenciais:
   ```php
   <?php
   $servername = "localhost";
   $username = "seu_usuario";
   $password = "sua_senha";
   $dbname = "games_space";
   ?>
   ```

## Utilização
Acesse o sistema via navegador no endereço configurado (por exemplo, `http://localhost/games-space`). Utilize as interfaces de administração para gerenciar administradores, produtos e categorias conforme necessário.

## Contribuidores
- **Gabriel Barreto**
- **Lusxka**

Agradecemos a todos os envolvidos no desenvolvimento deste projeto e esperamos que ele sirva como uma ferramenta eficiente para a gestão de conteúdos do **Games Space**.

## Licença
Este projeto está licenciado sob os termos da [MIT License](LICENSE).
