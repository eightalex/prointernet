<?php
define('WP_CACHE', true); // WP-Optimize Cache
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'admin_pronet');
/** MySQL database username */
define('DB_USER', 'admin_pronet');
/** MySQL database password */
define('DB_PASSWORD', 'pdhEE0677yYJIz2n');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '7wSlpFRISAAcw*re%3KZE*@5ktVU9teV!oEqzaFA21lMJTPiCbOD@oQvy*SAFgIT');
define('SECURE_AUTH_KEY',  'U@rV8q1B7CKUkn(0K*t%W&hI9X2VF#asru^uY0s(3rrUh8ogDT(*6@Todi%lB)!b');
define('LOGGED_IN_KEY',    'nE@j)Um%Ez5%P45LoPI65U0@kX0qomT11zY1Nvxid%mo7!6Ah8)9KCD9tx8sGrql');
define('NONCE_KEY',        'ChaB7OgymIKj@QXJD^bt)W53t54&gxkri#qoonRav1YqzEd!9R%0nI!OhL@KrIN!');
define('AUTH_SALT',        'FYX)&*BC)!lE)*#MCy48)6fmMNKraG*jHBBAnfn1tll%bw#xr5e%6W@zXfD3RbbR');
define('SECURE_AUTH_SALT', '!uHswBm*VK5l8Z*xY^ltoAGA9H)BMK^ybCYTI(jv0yBBb6^Z7j0lYDewL5PQ*jzK');
define('LOGGED_IN_SALT',   'j&3&nx0wV*q@#VfU8kK2^5%J9**!bX2ZQ1xT3*Hq^o&iE9%JH4(EAdTNd3kY(DZl');
define('NONCE_SALT',       'OssDs&5GkcTGOgN%5YT)qa1ndJsF&HwG8qL9A#%OGIse43mIFlkKtalnXE6MYv%E');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define( 'WP_ALLOW_MULTISITE', true );
define ('FS_METHOD', 'direct');
