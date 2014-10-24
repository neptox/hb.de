<?php
/**
 * In dieser Datei werden die Grundeinstellungen für WordPress vorgenommen.
 *
 * Zu diesen Einstellungen gehören: MySQL-Zugangsdaten, Tabellenpräfix,
 * Secret-Keys, Sprache und ABSPATH. Mehr Informationen zur wp-config.php gibt es
 * auf der {@link http://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Informationen für die MySQL-Datenbank bekommst du von deinem Webhoster.
 *
 * Diese Datei wird von der wp-config.php-Erzeugungsroutine verwendet. Sie wird ausgeführt,
 * wenn noch keine wp-config.php (aber eine wp-config-sample.php) vorhanden ist,
 * und die Installationsroutine (/wp-admin/install.php) aufgerufen wird.
 * Man kann aber auch direkt in dieser Datei alle Eingaben vornehmen und sie von
 * wp-config-sample.php in wp-config.php umbenennen und die Installation starten.
 *
 * @package WordPress
 */

/**  MySQL Einstellungen - diese Angaben bekommst du von deinem Webhoster. */
/**  Ersetze database_name_here mit dem Namen der Datenbank, die du verwenden möchtest. */


define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/webspace/04/85842/hof-biergarten.de/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', '85842_0');

/** Ersetze username_here mit deinem MySQL-Datenbank-Benutzernamen */
define('DB_USER', '85842_0.usr1');

/** Ersetze password_here mit deinem MySQL-Passwort */
define('DB_PASSWORD', 'Erlinator1');

/** Ersetze localhost mit der MySQL-Serveradresse */
define('DB_HOST', 'localhost');

/** Der Datenbankzeichensatz der beim Erstellen der Datenbanktabellen verwendet werden soll */
define('DB_CHARSET', 'utf8');

/** Der collate type sollte nicht geändert werden */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden KEY in eine beliebige, möglichst einzigartige Phrase.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle KEYS generieren lassen.
 * Bitte trage für jeden KEY eine eigene Phrase ein. Du kannst die Schlüssel jederzeit wieder ändern,
 * alle angemeldeten Benutzer müssen sich danach erneut anmelden.
 *
 * @seit 2.6.0
 */
define('AUTH_KEY',         ';j-k-Q,r`j+K&#+u<`C<@0){SD_cC?FI-:81P+fh_4LIe$r6QpO:3@N)0r>K-D!;');
define('SECURE_AUTH_KEY',  'sJ5A-Y,8,YGGt/RSw?[ R%eL1 q7-5OcXCC3nzj{%y:D`AR5.RZygV-X)T+4pPix');
define('LOGGED_IN_KEY',    'R<-|wnG&>v-7Xi;^S@ih]* y<dFSP28HsgeCn8-(f)&|g(a;2IWE2GS4wtU8!zuC');
define('NONCE_KEY',        ';J(PaC2i}fU4_w6`0ZMy-|qWC-k,x0<Epcs7<byW`5d3q4~YV8YwK0dx$hVjz/52');
define('AUTH_SALT',        'Lzf(J//L3U((fpm({Bwzq?-kd/j`r4:/(u<+|5k2Q-}2.(t%jYD-0j)mcN&9iatg');
define('SECURE_AUTH_SALT', '<+78+vl!/t61-(y^N=M*fsekeo>.1%&GofX7ZngD{JMd*!&kxPl3yrSM|o&gsh(J');
define('LOGGED_IN_SALT',   '} ?W[b7+J/7rIm>h<!Q<b.k+z+${t*>Lb|zql|} ~q%;gA59qsqdw~q]RaIK-).+');
define('NONCE_SALT',       'KgQ5Z@,$mP/{Z6k7Q<Fz(~DlQFb@N|$DDkl_.3i>K&#3ZET1y@MR9764A+*!Q^/6');

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 *  Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 *  verschiedene WordPress-Installationen betreiben. Nur Zahlen, Buchstaben und Unterstriche bitte!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* WooCommerce Aenderung */

define( 'WP_MEMORY_LIMIT', '96M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
