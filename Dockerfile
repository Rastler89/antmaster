FROM php:8.2-apache

# Habilitar mod_rewrite de Apache para usar .htaccess
RUN a2enmod rewrite

# Instalar dependencias para las extensiones de PHP, pdo_mysql / gd, cron y curl
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    cron \
    curl \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql gd zip \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Copiar el código fuente
COPY . /var/www/html/

# Configurar permisos para Apache
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

# Configuración de Cron
COPY docker/cron-reminders /etc/cron.d/cron-reminders
RUN chmod 0644 /etc/cron.d/cron-reminders && crontab /etc/cron.d/cron-reminders

# Configurar Script de Inicio
RUN chmod +x /var/www/html/docker/entrypoint.sh
ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
