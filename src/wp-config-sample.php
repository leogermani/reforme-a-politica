<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'reforme-a-politica');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

define('DOMAIN_CURRENT_SITE', 'localhost/reforme-a-politica');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '&j &x+)Do?8d-#%|mBMHU}]%@,k[LQ% O{4Y}c~#h9Z1v]TR)E+w^UbjPkvIDkx7');
define('SECURE_AUTH_KEY',  'A]GK%jP{A*55ay)pS`{KMD*yPt-]Y15N)zzV-JJ}X1AMF0DKMw!k)UL_s-=s~+[f');
define('LOGGED_IN_KEY',    'ix]1t+EBq#f#I^B(ydz]-&Mc,M+82~^>b+z<=*xW-}+}}^#JQM_.p>E~?qemk=?Z');
define('NONCE_KEY',        'H0R!Wcl>9V,Z0JwHg(_Mi)HElZ@vKza(F/6wD2II{l%H=[DFi~--iYHrjpKc7EMa');
define('AUTH_SALT',        'lp3g/>d(j*6eNg/P8? _ qm%At,4w:3NOtsG>tK,:f:rPYWqNA5^r*fGi{7|@`.j');
define('SECURE_AUTH_SALT', 'n![bi^UH5vYhy/i]+Gok:(</zB?ajg&D?vzr-Kh?<.:^U,xy&7nlt@lninDfvE[t');
define('LOGGED_IN_SALT',   '_(AAAp 5ekE]Qncg||brBVGrW-yy/~$B?BiN2 =AP+1-c^4[=Qsu?3)^a-cHD0k@');
define('NONCE_SALT',       's)@0r1b7f)Iaizg--E1~#H8)=EX,S7-5j)<Y7`PdsHO?e:m0B%ne6?ddeD-L;r3M');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', true);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
