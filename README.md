### Estocai
🧮 Sistema de Controle de Estoque

Sistema completo de controle de estoque desenvolvido com Laravel e Filament Admin Panel, com recursos de dashboard, alertas, movimentações, relatórios, permissões de usuário e muito mais.

🚀 Funcionalidades

- ✅ Autenticação com controle de acesso (admin e funcionário)
- 📊 Dashboard com:
  - Valor total em estoque
  - Valor total de produtos
  - Gráficos de entradas e saídas por mês
  - Evolução do estoque
  - Alerta de estoque mínimo
- 📦 Cadastro de categorias e produtos
- 🔄 Registro de movimentações (entradas e saídas)
- 📆 Filtros por período para geração de relatórios
- 📁 Exportação de relatórios em PDF e Excel
- 👥 Gestão de usuários (admin pode criar/remover usuários)
- 🔐 Proteção por nível de acesso (admin vs funcionário)


🧱 Tecnologias Utilizadas

- Laravel 10+
- Filament PHP (v3)
- MySQL (via Railway)
- PHP 8.x
- Laravel Excel (Maatwebsite)
- DomPDF
- TailwindCSS (via Filament)
- Chart.js (para gráficos no dashboard)
- Railway (deploy)

📦 Instalação Local

Pré-requisitos: PHP 8.1+, Composer, MySQL ou SQLite, Node.js (opcional)

git clone https://github.com/seu-usuario/seu-repo.git
cd seu-repo
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve

Acesse em: http://localhost:8000

📄 Exemplo de .env

APP_NAME=Estoque
APP_ENV=local
APP_KEY=base64:...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=estoque
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public

🛠️ Planejamentos futuros

- [ ] Log de atividades do sistema (quem fez o quê)
- [ ] Notificações por e-mail para alertas de estoque

📸 Imagens do Sistema


👨‍💻 Autor

Desenvolvido por Cauê
Entre em contato:

- LinkedIn: https://linkedin.com/in/seu-link
- GitHub: https://github.com/seu-usuario

📝 Licença

Este projeto está sob a licença MIT.  
Sinta-se livre para usar, estudar e melhorar!
