# SierraTecnologia Telefonica

**SierraTecnologia Telefonica** integration services telefonica and providers for users required by various SierraTecnologia packages. Validator functionality, and basic controller included out-of-the-box.

[![Packagist](https://img.shields.io/packagist/v/sierratecnologia/telefonica.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/sierratecnologia/telefonica)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/sierratecnologia/telefonica.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/sierratecnologia/telefonica/)
[![CI](https://github.com/SierraTecnologia/Telefonica/actions/workflows/ci.yml/badge.svg)](https://github.com/SierraTecnologia/Telefonica/actions/workflows/ci.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen.svg?style=flat-square)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code%20Style-PSR--12-blue.svg?style=flat-square)](https://www.php-fig.org/psr/psr-12/)
[![License](https://img.shields.io/packagist/l/sierratecnologia/telefonica.svg?label=License&style=flat-square)](https://github.com/sierratecnologia/telefonica/blob/master/LICENSE)

---

## Índice

- [Introdução](#introdução)
- [Instalação](#instalação)
- [Arquitetura e Estrutura Interna](#arquitetura-e-estrutura-interna)
- [Principais Componentes e Responsabilidades](#principais-componentes-e-responsabilidades)
- [Uso Prático](#uso-prático)
- [Integração com o Ecossistema SierraTecnologia](#integração-com-o-ecossistema-sierratecnologia)
- [Extensão e Customização](#extensão-e-customização)
- [Exemplos Reais](#exemplos-reais)
- [Ferramentas de Qualidade](#ferramentas-de-qualidade)
- [Guia de Contribuição](#guia-de-contribuição)

---

## Introdução

### O que é a biblioteca Telefonica

A **Telefonica** é uma biblioteca PHP desenvolvida pela SierraTecnologia para gerenciamento completo de informações de contato em aplicações Laravel. Ela fornece uma infraestrutura robusta para armazenamento, validação e manipulação de dados telefônicos, e-mails, e informações de pessoas e organizações.

### Objetivo e Filosofia do Projeto

O objetivo principal da Telefonica é centralizar e padronizar o gerenciamento de dados de contato em aplicações empresariais, eliminando a necessidade de reimplementar funcionalidades comuns de cadastro e validação de telefones, e-mails e informações pessoais.

**Princípios fundamentais:**
- **Reutilização**: Componentes prontos para uso em qualquer projeto Laravel
- **Extensibilidade**: Arquitetura baseada em Traits e relações polimórficas
- **Integração**: Compatibilidade nativa com o ecossistema SierraTecnologia
- **Padronização**: Convenções consistentes de código e estrutura

### Benefícios de Uso

- **Redução de código repetitivo**: Models, migrations e controllers prontos
- **Validação integrada**: Validação de telefones via `propaganistas/laravel-phone`
- **Relações polimórficas**: Associe telefones e e-mails a qualquer entidade
- **Interface administrativa**: Views e controllers para gestão de dados
- **Integração com Population**: Suporte a características físicas e identidade

### Encaixe no Ecossistema SierraTecnologia

A Telefonica é um componente fundamental do ecossistema, servindo como base para:
- **Population**: Gestão de características populacionais
- **Crypto**: Criptografia de dados sensíveis
- **Locaravel**: Integração com endereços e geolocalização

---

## Instalação

### Requisitos Mínimos

- PHP 7.2+ ou 8.0+
- Laravel 7.x, 8.x, 9.x, 10.x ou 11.x
- Composer 2.x

### Instalação via Composer

```bash
composer require sierratecnologia/telefonica
```

### Publicação de Configurações

```bash
# Publicar arquivo de configuração
php artisan vendor:publish --tag=sitec-config

# Publicar views (opcional)
php artisan vendor:publish --tag=sitec-views

# Publicar traduções (opcional)
php artisan vendor:publish --tag=sitec-lang
```

### Execução das Migrations

```bash
php artisan migrate
```

### Registro do Service Provider

O Service Provider é registrado automaticamente via Laravel Package Discovery. Caso necessário, registre manualmente no `config/app.php`:

```php
'providers' => [
    // ...
    Telefonica\TelefonicaProvider::class,
],

'aliases' => [
    // ...
    'Telefonica' => Telefonica\Facades\Telefonica::class,
],
```

---

## Arquitetura e Estrutura Interna

### Estrutura de Diretórios

```
src/
├── Cacheable/           # Cache de queries Eloquent
├── Console/             # Comandos Artisan
├── Contracts/           # Interfaces e abstrações
├── Exceptions/          # Tratamento de exceções
├── Facades/             # Facades Laravel
├── Http/
│   ├── Controllers/     # Controllers (Admin, Master, Painel)
│   ├── Policies/        # Políticas de autorização
│   └── Requests/        # Form Requests
├── Interfaces/          # Contratos de implementação
├── Models/
│   ├── Actors/          # Person, Business
│   └── Digital/         # Phone, Email, Account, etc.
├── Observers/           # Observers de eventos
├── Repositories/        # Padrão Repository
├── Resources/           # API Resources
├── Scopes/              # Query Scopes
├── Services/            # Lógica de negócio
└── Traits/              # Traits reutilizáveis
```

### Padrões Arquiteturais

A Telefonica adota uma arquitetura em camadas inspirada em DDD (Domain-Driven Design):

1. **Camada de Apresentação**: Controllers, Views, Resources
2. **Camada de Aplicação**: Services, Requests, Policies
3. **Camada de Domínio**: Models, Traits, Observers
4. **Camada de Infraestrutura**: Repositories, Cacheable

### Comunicação Entre Camadas

```
Controller → Service → Repository → Model
     ↓           ↓          ↓         ↓
  Request    Validation   Cache   Database
```

### Convenções SierraTecnologia

- **Namespaces**: `Telefonica\{Camada}\{Componente}`
- **Models**: Chaves primárias podem ser `code` (string) ou `id` (integer)
- **Relações**: Uso extensivo de relações polimórficas (`morphToMany`, `morphedByMany`)
- **Traits**: Composição de funcionalidades via Traits

---

## Principais Componentes e Responsabilidades

### Models

#### Phone (`Telefonica\Models\Digital\Phone`)

Gerencia números telefônicos com suporte a relações polimórficas.

```php
use Telefonica\Models\Digital\Phone;

// Criar telefone
$phone = Phone::create(['number' => '21999999999']);

// Associar a uma pessoa
$person->phones()->attach($phone);

// Buscar telefones de um usuário
$user->phones()->get();
```

#### Email (`Telefonica\Models\Digital\Email`)

Gerencia endereços de e-mail com chave primária composta.

```php
use Telefonica\Models\Digital\Email;

// Criar e-mail
$email = Email::create([
    'email' => 'contato@empresa.com',
    'address' => 'contato',
    'domain' => 'empresa.com'
]);

// Associar a entidades
$person->emails()->attach($email);
```

#### Person (`Telefonica\Models\Actors\Person`)

Representa pessoas físicas com validação de CPF e integração completa.

```php
use Telefonica\Models\Actors\Person;

$person = Person::create([
    'code' => 'joao-silva',
    'name' => 'João Silva',
    'cpf' => '12345678900',
    'birthday' => '1990-01-15'
]);

// Adicionar contatos
$person->phones()->attach($phone);
$person->emails()->attach($email);
```

#### Business (`Telefonica\Models\Actors\Business`)

Representa empresas e organizações.

```php
use Telefonica\Models\Actors\Business;

$business = Business::create([
    'code' => 'minha-empresa',
    'name' => 'Minha Empresa LTDA',
    'description' => 'Descrição da empresa'
]);
```

### Traits

#### HasContacts

Adiciona relações de contato a qualquer Model.

```php
use Telefonica\Traits\HasContacts;

class Customer extends Model
{
    use HasContacts;
}

// Uso
$customer->phones()->attach($phone);
$customer->emails()->attach($email);
$customer->addresses()->attach($address);
$customer->sitios()->attach($sitio);
```

#### AsHuman

Adiciona características humanas e relações populacionais.

```php
use Telefonica\Traits\AsHuman;

class User extends Model
{
    use AsHuman;
}

// Uso
$user->setTag('vip');
$user->setSkill('programacao');
$user->productions()->attach($production);
```

#### AsOrganization

Adiciona funcionalidades organizacionais.

```php
use Telefonica\Traits\AsOrganization;

class Company extends Model
{
    use AsOrganization;
}
```

### Services

#### TelefonicaService

Serviço principal para operações da biblioteca.

```php
use Telefonica\Services\TelefonicaService;

$service = app(TelefonicaService::class);
```

#### PersonService

Serviço especializado para operações com pessoas.

```php
use Telefonica\Services\PersonService;

$personService = app(PersonService::class);
```

---

## Uso Prático

### Exemplo Completo: Sistema de Cadastro

```php
<?php

namespace App\Http\Controllers;

use Telefonica\Models\Actors\Person;
use Telefonica\Models\Actors\Business;
use Telefonica\Models\Digital\Phone;
use Telefonica\Models\Digital\Email;

class CadastroController extends Controller
{
    public function store(Request $request)
    {
        // Criar pessoa
        $person = Person::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'birthday' => $request->birthday
        ]);

        // Criar e associar telefone
        $phone = Phone::create(['number' => $request->phone]);
        $person->phones()->attach($phone);

        // Criar e associar e-mail
        $email = Email::create([
            'email' => $request->email,
            'address' => explode('@', $request->email)[0],
            'domain' => explode('@', $request->email)[1]
        ]);
        $person->emails()->attach($email);

        return response()->json([
            'message' => 'Cadastro realizado com sucesso',
            'person' => $person->load(['phones', 'emails'])
        ]);
    }
}
```

### Validação de Telefones

A biblioteca utiliza `propaganistas/laravel-phone` para validação:

```php
use Illuminate\Support\Facades\Validator;

$validator = Validator::make($request->all(), [
    'phone' => 'required|phone:BR'
]);
```

### Uso dos Traits em Models Existentes

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Telefonica\Traits\HasContacts;
use Telefonica\Traits\AsHuman;

class User extends Authenticatable
{
    use HasContacts, AsHuman;

    // Agora o User tem acesso a:
    // $user->phones()
    // $user->emails()
    // $user->addresses()
    // $user->setTag()
    // $user->setSkill()
}
```

### Rotas Administrativas

A biblioteca registra rotas automaticamente para gestão:

```php
// Rotas disponíveis após instalação:
// admin.telefonica.phones.index
// admin.telefonica.phones.create
// admin.telefonica.phones.store
// admin.telefonica.phones.edit
// admin.telefonica.phones.update
// admin.telefonica.phones.destroy

// painel.telefonica.persons.index
// painel.telefonica.persons.create
// ...
```

---

## Integração com o Ecossistema SierraTecnologia

### Dependências do Ecossistema

```json
{
    "require": {
        "sierratecnologia/population": "^0.4.0",
        "sierratecnologia/crypto": "^0.4.0"
    }
}
```

### Integração com Population

```php
// AsHuman trait integra com Population para características físicas
$person->pircings();      // Piercings
$person->pintinhas();     // Pintas
$person->tatuages();      // Tatuagens
$person->productions();   // Produções
$person->personagens();   // Personagens
```

### Integração com Locaravel

```php
// HasContacts inclui integração com endereços
$person->addresses();     // Endereços (Locaravel)
```

### Padrões de Versionamento

- **Versionamento Semântico**: MAJOR.MINOR.PATCH
- **Branch principal**: `master` ou `main`
- **Branch estável**: `stable`

### CI/CD da SierraTecnologia

O projeto utiliza GitHub Actions para:
- Testes automatizados (PHPUnit)
- Análise estática (PHPStan)
- Verificação de estilo (PHPCS/PSR-12)
- Integração contínua em múltiplas versões PHP/Laravel

---

## Extensão e Customização

### Criando Novos Models de Contato

```php
<?php

namespace App\Models;

use Pedreiro\Models\Base;

class SocialMedia extends Base
{
    protected $fillable = ['platform', 'username', 'url'];

    public function persons()
    {
        return $this->morphedByMany(
            \Telefonica\Models\Actors\Person::class,
            'socialmediaable'
        );
    }
}
```

### Estendendo Traits Existentes

```php
<?php

namespace App\Traits;

use Telefonica\Traits\HasContacts;

trait HasExtendedContacts
{
    use HasContacts;

    public function socialMedias()
    {
        return $this->morphToMany(\App\Models\SocialMedia::class, 'socialmediaable');
    }
}
```

### Substituindo Classes via Container

```php
// Em AppServiceProvider
$this->app->bind(
    \Telefonica\Services\TelefonicaService::class,
    \App\Services\CustomTelefonicaService::class
);
```

### Customizando Views

```bash
php artisan vendor:publish --tag=sitec-views
```

Edite os arquivos em `resources/views/vendor/telefonica/`.

### Customizando Configurações

```php
// config/sitec/telefonica.php
return [
    // Suas configurações customizadas
];
```

---

## Exemplos Reais

### Caso 1: Sistema de CRM

**Antes (sem Telefonica):**
```php
// Código repetitivo em cada projeto
Schema::create('customer_phones', ...);
Schema::create('customer_emails', ...);

class Customer extends Model {
    public function phones() { ... }
    public function emails() { ... }
}
```

**Depois (com Telefonica):**
```php
use Telefonica\Traits\HasContacts;

class Customer extends Model {
    use HasContacts;
    // Pronto! Todas as relações disponíveis
}
```

### Caso 2: Validação de Telefones Internacionais

```php
use Propaganistas\LaravelPhone\PhoneNumber;

$phone = new PhoneNumber($request->phone, 'BR');

if ($phone->isValid()) {
    $formatted = $phone->formatE164(); // +5521999999999

    Phone::create(['number' => $formatted]);
}
```

### Caso 3: Integração com Menu Administrativo

A Telefonica registra automaticamente itens de menu:

```php
// Configuração em TelefonicaProvider
public static $menuItens = [
    [
        'text' => 'Universo',
        'icon' => 'fas fa-fw fa-globe-americas',
        'section' => 'admin',
    ],
    'Universo' => [
        [
            'text' => 'Pessoas',
            'route' => 'painel.telefonica.persons.index',
        ],
        [
            'text' => 'Telefones',
            'route' => 'admin.telefonica.phones.index',
        ],
    ],
];
```

### Benefícios Mensuráveis

- **Redução de 70%** no código de cadastro de contatos
- **Padronização** entre todos os projetos SierraTecnologia
- **Manutenção centralizada** de funcionalidades comuns
- **Testes automatizados** garantem qualidade

---

## Ferramentas de Qualidade

### Executando Testes Localmente

```bash
# Instalar dependências de desenvolvimento
composer install

# Executar PHPUnit
composer test
# ou
vendor/bin/phpunit

# Executar com cobertura
composer test-coverage
# ou
vendor/bin/phpunit --coverage-html coverage
```

### Análise Estática com PHPStan

```bash
# Executar PHPStan
vendor/bin/phpstan analyse src/ --level=5

# Com arquivo de configuração
vendor/bin/phpstan analyse --configuration=phpstan.neon
```

### Verificação de Estilo com PHPCS

```bash
# Verificar código
vendor/bin/phpcs --standard=PSR12 src/

# Corrigir automaticamente
vendor/bin/phpcbf --standard=PSR12 src/
```

### Formatação com PHP-CS-Fixer

```bash
# Formatar código
composer format
# ou
vendor/bin/php-cs-fixer fix --allow-risky=yes
```

### GitHub Actions

O projeto utiliza CI automatizado com:

- **Testes**: PHP 8.2/8.3 com Laravel 10/11
- **PHPStan**: Nível 5 de análise
- **PHPCS**: Padrão PSR-12

Veja `.github/workflows/ci.yml` para detalhes.

---

## Guia de Contribuição

### Como Contribuir

1. **Fork** o repositório
2. **Clone** seu fork: `git clone https://github.com/seu-usuario/telefonica.git`
3. **Crie uma branch**: `git checkout -b feature/minha-feature`
4. **Desenvolva** e teste suas alterações
5. **Commit**: `git commit -m "feat: adiciona nova funcionalidade"`
6. **Push**: `git push origin feature/minha-feature`
7. **Pull Request**: Abra um PR para o repositório principal

### Padrões de Commit

Utilize [Conventional Commits](https://www.conventionalcommits.org/):

- `feat:` Nova funcionalidade
- `fix:` Correção de bug
- `docs:` Documentação
- `style:` Formatação
- `refactor:` Refatoração
- `test:` Testes
- `chore:` Manutenção

### Branch Naming

- `feature/` - Novas funcionalidades
- `fix/` - Correções de bugs
- `docs/` - Documentação
- `refactor/` - Refatorações

### Executando Verificações Locais

```bash
# Instalar dependências
composer install

# Executar todos os testes
composer test

# Verificar estilo
vendor/bin/phpcs --standard=PSR12 src/

# Análise estática
vendor/bin/phpstan analyse src/ --level=5

# Formatar código
composer format
```

### Issues e Pull Requests

- **Issues**: [GitHub Issues](https://github.com/sierratecnologia/telefonica/issues)
- **Pull Requests**: Sempre associe a uma issue
- **Code Review**: Aguarde aprovação antes do merge

### Política de Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

### Autores e Contato

- **SierraTecnologia**: [https://sierratecnologia.com.br](https://sierratecnologia.com.br)
- **Ricardo Rebello Sierra**: [contato@ricardosierra.com.br](mailto:contato@ricardosierra.com.br)
- **Suporte**: [help@sierratecnologia.com.br](mailto:help@sierratecnologia.com.br)

---

## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](https://bit.ly/sierratecnologia-slack)
- [Help on Email](mailto:help@sierratecnologia.com.br)
- [Follow on Twitter](https://twitter.com/sierratecnologia)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [help@sierratecnologia.com.br](help@sierratecnologia.com.br). All security vulnerabilities will be promptly addressed.


## About SierraTecnologia

SierraTecnologia is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Rio de Janeiro, Brazil since June 2008. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That's how we do our share of advancing humanity.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2008-2024 SierraTecnologia, Some rights reserved.
