#!/bin/sh
set -e

cd /var/www/html

# Port dari platform (Koyeb/Render menyuntikkan PORT); default 80
PORT="${PORT:-80}"
printf 'Listen %s\n' "$PORT" > /etc/apache2/ports.conf

# Wajib dijalankan SEBELUM apache start (env sudah tersedia di tahap ini)
php artisan config:cache
php artisan view:cache
php artisan storage:link || true

# Migrasi + sekali seed jika database masih kosong
php artisan migrate --force
php artisan db:seed-if-empty

exec apache2-foreground
