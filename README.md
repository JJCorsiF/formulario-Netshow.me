# formulario-Netshow.me

Essa é uma aplicação para envio de dados via formulário para um endereço de email previamente configurado.
Os requisitos coletados estão definidos no arquivo "./app/aplicacao/requisitos.txt".

A aplicação foi desenvolvida e testada usando o PHP 7.3.19. Utilizo também o framework PHP Codeigniter versão 3.1.*.

## Setup
Para instalar a aplicação, será necessário ter o Composer e o NPM instalados no computador.

> mkdir "netshow.me"
> 
> git clone git@github.com:JJCorsiF/formulario-Netshow.me.git ./netshow.me/
> 
> cd ./netshow.me/

### Backend
É necessário instalar as dependências com o Composer:

> cd ./app/aplicacao/
> 
> composer install

#### Testes
Para a criação dos testes, utilizei o framework Codeception:

> app/aplicacao/vendor/bin/codecept run

### Frontend
Para o Frontend, é necessário instalar as dependências com o NPM:

> cd ./../../assets/aplicacao/
> 
> npm install

#### Build
Para construir os arquivos javascripts com o Webpack, basta rodar na linha de comando:

> npm run build

## Configurando o banco de dados
A aplicação funciona com um banco de dados MySQL. O script para a criação do banco segue:

```sql
CREATE TABLE `mensagem_enviada` (
 `id_mensagem_enviada` char(36) NOT NULL,
 `id_usuario` char(36) NOT NULL,
 `url_do_anexo` varchar(255) NOT NULL,
 `ip_do_dispositivo` varchar(16) NOT NULL,
 `data_do_envio` datetime NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id_mensagem_enviada`),
 KEY `fk_usuario_mensagem_enviada` (`id_usuario`),
 CONSTRAINT `fk_usuario_mensagem_enviada` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `usuario` (
 `id_usuario` char(36) NOT NULL,
 `nome` varchar(100) NOT NULL,
 `email` varchar(100) NOT NULL,
 `telefone` varchar(20) NOT NULL,
 PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## Configurando o banco de dados
O Codeigniter utiliza o seguinte arquivo para a conexão com o banco de dados. É necessário criar um usuário MySQL com permissões básicas para o banco de dados.

> ./app/config/testing/database.php

No exemplo a seguir, a aplicação está configurada para acessar o banco MySQL 'netshow.me' em 'localhost' com o usuário 'netshow.me' e a senha 'netshow.me':

```php
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'netshow.me',
	'password' => 'netshow.me',
	'database' => 'netshow.me',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
```

## Configurando a aplicação
Para configurar a aplicação, existem 2 arquivos na pasta "./app/aplicacao/configuracao".

No arquivo "email.json", é possível configurar os emails que receberão as mensagens do formulário. Ex.:

```json
{
	"emailsDeDestino": [
		"a@b.c",
		"email2@example.com.br"
	]
}
```

No arquivo "smtp.json", é possível configurar o PHPMailer, utilizado para o envio dos emails. Ex.:

```json
{
	"emailDeOrigem": "email@example.com",
	"isSMTP": false,
	"host": "localhost",
	"username": "username",
	"password": "password"
}
```

## Acessando o formulário
Finalmente, para abrir a página com o formúlario, basta acessar a página no navegador, onde está localizado o seguinte arquivo:

> ./netshow.me/index.php

Exemplo:

> http://localhost/netshow.me/
