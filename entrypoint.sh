#!/bin/bash
# Retrieve the secret from AWS Secrets Manager
SECRET_JSON=$(aws secretsmanager get-secret-value --secret-id eksproject-db-secret --query SecretString --output text)
# Check if the secret was retrieved successfully
if [ $? -ne 0 ] || [ -z "$SECRET_JSON" ]; then
  echo " Error: Failed to retrieve secret from AWS Secrets Manager"
  exit 1
fi
# Parse the secret JSON
export WORDPRESS_DB_HOST=$(echo "$SECRET_JSON" | jq -r .host)
export WORDPRESS_DB_USER=$(echo "$SECRET_JSON" | jq -r .username)
export WORDPRESS_DB_PASSWORD=$(echo "$SECRET_JSON" | jq -r .password)
export WORDPRESS_DB_NAME=$(echo "$SECRET_JSON" | jq -r .dbname)
# Validate values
if [ -z "$WORDPRESS_DB_HOST" ] || [ -z "$WORDPRESS_DB_USER" ] || [ -z "$WORDPRESS_DB_PASSWORD" ] || [ -z "$WORDPRESS_DB_NAME" ]; then
  echo " Error: One or more database credentials are missing."
  exit 1
fi
# Check DB connection
echo " Testing database connection..."
if ! mysql -h "$WORDPRESS_DB_HOST" -u "$WORDPRESS_DB_USER" -p"$WORDPRESS_DB_PASSWORD" "$WORDPRESS_DB_NAME" -e "exit"; then
  echo " Error: Unable to connect to database."
  exit 1
fi

# Update wp-config.php with the database credentials
echo " Updating wp-config.php with database credentials..."

# Replace placeholders with actual values
sed -i "s/%%DB_NAME%%/$WORDPRESS_DB_NAME/g" /var/www/html/wp-config.php
sed -i "s/%%DB_USER%%/$WORDPRESS_DB_USER/g" /var/www/html/wp-config.php
sed -i "s/%%DB_PASSWORD%%/$WORDPRESS_DB_PASSWORD/g" /var/www/html/wp-config.php
sed -i "s/%%DB_HOST%%/$WORDPRESS_DB_HOST/g" /var/www/html/wp-config.php

# Set permissions
chown www-data:www-data /var/www/html/wp-config.php
chmod 640 /var/www/html/wp-config.php


echo "Writing .htaccess file..."

cat <<EOF > /var/www/html/.htaccess

# BEGIN HTTPS Redirection Plugin
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{SERVER_PORT} !^443$
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
# END HTTPS Redirection Plugin

# BEGIN LSCACHE
## LITESPEED WP CACHE PLUGIN - Do not edit the contents of this block! ##
<IfModule LiteSpeed>
RewriteEngine on
CacheLookup on
RewriteRule .* - [E=Cache-Control:no-autoflush]
RewriteRule litespeed/debug/.*\.log$ - [F,L]
RewriteRule \.litespeed_conf\.dat - [F,L]

### marker ASYNC start ###
RewriteCond %{REQUEST_URI} /wp-admin/admin-ajax\.php
RewriteCond %{QUERY_STRING} action=async_litespeed
RewriteRule .* - [E=noabort:1]
### marker ASYNC end ###

### marker CACHE RESOURCE start ###
RewriteRule wp-content/.*/[^/]*(responsive|css|js|dynamic|loader|fonts)\.php - [E=cache-control:max-age=3600]
### marker CACHE RESOURCE end ###

### marker DROPQS start ###
CacheKeyModify -qs:fbclid
CacheKeyModify -qs:gclid
CacheKeyModify -qs:utm*
CacheKeyModify -qs:_ga
### marker DROPQS end ###

</IfModule>
## LITESPEED WP CACHE PLUGIN - Do not edit the contents of this block! ##
# END LSCACHE
# BEGIN NON_LSCACHE
## LITESPEED WP CACHE PLUGIN - Do not edit the contents of this block! ##
## LITESPEED WP CACHE PLUGIN - Do not edit the contents of this block! ##
# END NON_LSCACHE

# BEGIN WordPress
# The directives (lines) between "BEGIN WordPress" and "END WordPress" are
# dynamically generated, and should only be modified via WordPress filters.
# Any changes to the directives between these markers will be overwritten.
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>

# END WordPress

# php -- BEGIN cPanel-generated handler, do not edit
# Set the “ea-php82” package as the default “PHP” programming language.
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php82___lsphp .php .php8 .phtml
</IfModule>
# php -- END cPanel-generated handler, do not edit
EOF

chown www-data:www-data /var/www/html/.htaccess
chmod 644 /var/www/html/.htaccess

echo " WordPress configuration completed successfully!"

# Start Apache
exec apache2-foreground