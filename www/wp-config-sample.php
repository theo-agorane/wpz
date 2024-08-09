<?php

define('WPZ_DEV', false);
define('WPZ_CACHE', '24080901');

/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'wpz');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '|fn44@54/(Q6afzmMZ9B6a:ZpN(r2J4Gh;6LC7Le2)Si9/5/Om1%3Y76+B-Sh;[s');
define('SECURE_AUTH_KEY', 'm9)7QfV0bs(1(Q6(S0ZZ!E0h23;TffH#iiD%o5~t2V7*DZ/U1evIi2_O4Zb1U6v-');
define('LOGGED_IN_KEY', '/T2D52e/d;lBa:L/6nnL7Rc*H57s8fvYWh;w09gH0502y7K5&6R6~JUYNI1n~&V%');
define('NONCE_KEY', 'et@Nvt]+s&_ZP16miw@#/H/2![uAx!6+58+MNKh85q60Mq]74ua+rXr7d[R@]y5j');
define('AUTH_SALT', '8qq1ZIvZJ~j106:i5D0_7|dg7Zk6sp)h+mp6SInW67-9-ro_3T1:fHx%)720T8z_');
define('SECURE_AUTH_SALT', 'H!3|Cn9MF86Rmg0KFPTvtt64#48[7+~[1@s~Xg0:S%(|24e#!0ojMZPA_-QpUfr1');
define('LOGGED_IN_SALT', '&9U;Ii@16r6-(|]%b0cItV8O;2[2q9-%+_FK)pE8t5PI~;8;[:/g3~SHhP3z((Jx');
define('NONCE_SALT', '4ka2rY9CDYu*m0w|q02m%r6aL(A:AXzYc)65q0/XSvMV39E;-5a0AQW]5y(80w)Q');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wpz_';

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 
//define('WP_DEBUG_DISPLAY', false);
//define('WP_DEBUG_LOG', true);

define('DISALLOW_FILE_EDIT', true);
define('AUTOMATIC_UPDATER_DISABLED', true);
define('WP_AUTO_UPDATE_CORE', false);

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
