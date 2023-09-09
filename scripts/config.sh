#!/usr/bin/env bash

source scripts/includes/variables.sh

printf "\n${BLUE}Creating wp-config.php...${NC}\n"
lando wp config create \
--config-file=./wp-config.php \
--dbname=wordpress \
--dbuser=wordpress \
--dbpass=wordpress \
--dbhost=database \
--extra-php <<PHP
/*
 * Custom Content Directory
 */
if ( defined( 'WP_CLI' ) ) {
    \$_SERVER['HTTP_HOST'] = 'HTTP_HOST';
}
define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );
define( 'WP_CONTENT_URL', 'https://' . \$_SERVER['HTTP_HOST'] . '/wp-content' );

/*
 * Environment
 */
define( 'WP_ENVIRONMENT_TYPE', 'local' );

/*
 * File System
 */
define( 'WPSTART_NODE_PATH', '/var/www/.nvm/versions/node/v$NODE_VERSION/bin/node' );
define( 'WPSTART_NODE_TEMP_PATH', '/tmp' );

/*
 * Debugging
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG', true );
define( 'WPSTART_SSR_DEBUG', true );
PHP

printf "\n${BLUE}Updating ABSPATH...${NC}\n"
sed -i "s/'ABSPATH', __DIR__ . '\/'/'ABSPATH', __DIR__ . '\/wp\/'/g" wp-config.php
echo "Success: Updated ABSPATH."

printf "\n${BLUE}Creating .htaccess...${NC}\n"
cat <<EOF > .htaccess
# .htaccess from ansible template

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^(wp-admin/.*)$ /wp/\$1 [L]
    RewriteRule ^(wp-[^/]+\.php)$ /wp/\$1 [L]
    RewriteRule ^xmlrpc\.php$ /wp/xmlrpc.php [L]
    RewriteRule ^(wp-includes/.*)$ /wp/\$1 [L]
</IfModule>

# BEGIN WordPress
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
</IfModule>

# END WordPress
EOF
echo "Success: Created .htaccess."

printf "\n${GREEN}Successfully created local configuration files!${NC}\n\n"
