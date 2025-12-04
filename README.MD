# Hackathon Voucher Desenvolvedor MS

## Descrição do Projeto
O **Hackathon Voucher Desenvolvedor MS** é uma solução inovadora criada durante o hackathon, com o objetivo de simplificar a distribuição e o gerenciamento de vouchers para desenvolvedores no estado de Mato Grosso do Sul. O sistema visa oferecer uma plataforma intuitiva, eficiente e escalável, utilizando tecnologias modernas e de fácil manutenção.

## Tecnologias Utilizadas
A principal stack tecnológica do projeto é composta pelas seguintes tecnologias:

- **PHP 8**: Utilizado no desenvolvimento do backend, oferecendo performance otimizada e recursos modernos para a construção de aplicações robustas.
- **MySQL**: Banco de dados relacional para armazenamento de dados de vouchers, usuários e transações, garantindo integridade e eficiência.
- **HTML5**: Estrutura básica da interface, garantindo uma base semântica e acessível.
- **Tailwind CSS**: Framework CSS utilitário que acelera o desenvolvimento da interface, oferecendo flexibilidade e design responsivo com poucas linhas de código.

## Sistema de Autenticação e Sessões

O sistema implementa um robusto mecanismo de autenticação com controle de expiração de sessões:

### Funcionalidades
- **Login seguro**: Autenticação com email, senha e pergunta de segurança
- **Expiração automática**: Sessões expiram após 2 horas de inatividade
- **Renovação automática**: Sessão é renovada automaticamente se houver atividade dentro de 30 minutos
- **Proteção de rotas**: Páginas administrativas exigem autenticação válida
- **Indicador visual**: Mostra tempo restante da sessão no navbar
- **Proteção automática**: Logout forçado quando sessão expira

### Arquitetura
- **SessaoService**: Classe responsável por gerenciar sessões com timestamps de expiração
- **AutenticacaoService**: Classe para validação de acesso e permissões
- **init.php**: Arquivo de inicialização que verifica expiração em todas as páginas

## Integrantes
- **Adercio Barbuio**  
- **Antônio Victor** 
- **Rhyan Komm** 