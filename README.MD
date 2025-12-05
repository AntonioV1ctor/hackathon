# Sabores do Turismo

## Descrição do Projeto
O **Sabores do Turismo** é uma plataforma web voltada para o turismo gastronômico no estado de Mato Grosso do Sul. O objetivo principal é conectar turistas e moradores locais aos melhores restaurantes da região, permitindo a descoberta de novos sabores, a visualização de detalhes sobre os estabelecimentos e o gerenciamento de experiências gastronômicas pessoais.

O sistema oferece recursos como busca avançada de restaurantes, mapa interativo, gerador de roteiros gastronômicos e um perfil de usuário para marcar locais visitados.

## Tecnologias Utilizadas
A principal stack tecnológica do projeto é composta pelas seguintes tecnologias:

- **PHP 8**: Utilizado no desenvolvimento do backend, oferecendo performance otimizada e recursos modernos.
- **MySQL**: Banco de dados relacional para armazenamento de dados.
- **HTML5**: Estrutura semântica da interface.
- **Tailwind CSS**: Framework CSS para estilização responsiva e moderna.
- **Leaflet.js**: Biblioteca JavaScript para mapas interativos (Mapa Geral e Roteiros).

## Pré-requisitos
Para rodar este projeto localmente, você precisará de:
- **XAMPP** (ou qualquer servidor web com PHP e MySQL)
- **PHP 8.0** ou superior
- **MySQL**

## Instalação e Configuração

1.  **Clonar o Repositório**
    ```bash
    git clone https://github.com/AntonioV1ctor/hackathon.git
    ```

2.  **Mover para o Diretório Web**
    Mova a pasta do projeto para o diretório raiz do seu servidor web.
    - No XAMPP: `C:\xampp\htdocs\hackathon`

3.  **Configurar o Banco de Dados**
    - Abra o phpMyAdmin (geralmente em `http://localhost/phpmyadmin`).
    - Crie um banco de dados chamado `saboresdoturismo`.
    - Importe os arquivos SQL na seguinte ordem:
      1. `Config/db/estrutura/1-estrutura.sql` (Criação das tabelas)
      2. `Config/db/estrutura/2-update_perfil.sql` (Atualização da tabela de usuários)
      3. `Config/db/carga/1-carga.sql` (Carga inicial de dados)

4.  **Configurar a Conexão**
    Verifique e ajuste as credenciais do banco de dados no arquivo:
    `Config/database.php`
    ```php
    // Exemplo de configuração
    private $host = "localhost";
    private $dbName = "saboresdoturismo";
    private $user = "root";
    private $password = ""; // Ajuste conforme sua senha
    ```

## Como Usar
1.  Inicie os serviços **Apache** e **MySQL** no painel de controle do XAMPP.
2.  Acesse o projeto no seu navegador:
    [http://localhost/hackathon](http://localhost/hackathon)

## Funcionalidades Principais

### Para Usuários
- **Explorar Restaurantes**: Listagem com filtros por cidade, categoria e avaliação.
- **Mapa Gastronômico**: Visualização de todos os restaurantes em um mapa interativo.
- **Gerador de Roteiro**: Crie um roteiro personalizado selecionando cidades e refeições.
- **Perfil**: Gerencie seus dados e marque restaurantes que já visitou.

### Para Administradores
- **Gestão de Restaurantes**: Cadastrar, editar e remover restaurantes.
- **Dashboard**: Visão geral do sistema.

## Sistema de Autenticação
O sistema implementa autenticação segura com:
- Login com email e senha.
- Hash de senhas para segurança.
- Controle de sessão com expiração automática por inatividade.

## Integrantes
- **Adercio Barbuio**
- **Antônio Victor**
- **Rhyan Komm**