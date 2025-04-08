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

echo " WordPress configuration completed successfully!"


# Part 2: .htaccess Configuration
echo "Configuring .htaccess..."
cat > /var/www/html/.htaccess << 'EOL'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]

# HTTP to HTTPS redirect (behind ALB)
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Standard WordPress rewrites
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
EOL

# Set permissions
chown -R www-data:www-data /var/www/html
chmod 644 /var/www/html/.htaccess
chmod 640 /var/www/html/wp-config.php

# Start Apache
exec apache2-foreground