# Gunakan image PHP dengan Apache
FROM php:8.0-apache

# Install ekstensi PHP yang dibutuhkan (mysqli, mbstring, dan oniguruma)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    git && \
    docker-php-ext-install mysqli mbstring

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Salin semua file proyek ke dalam container
COPY . /var/www/html/

# Set hak akses yang tepat untuk folder
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (HTTP)
EXPOSE 80

# Jalankan Apache di container
CMD ["apache2-foreground"]
