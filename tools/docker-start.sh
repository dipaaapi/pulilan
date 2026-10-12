#!/bin/sh
set -eu
mkdir -p /var/www/html/storage/uploads
chown www-data:www-data /var/www/html/storage/uploads
php /var/www/html/database/migrate.php
php /var/www/html/tools/import-attachments.php
php /var/www/html/tools/provision-runtime.php
exec apache2-foreground
