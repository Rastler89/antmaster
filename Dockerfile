FROM php:8.2-apache

# Habilitar mod_rewrite de Apache para usar .htaccess
RUN a2enmod rewrite

# Instalar dependencias para las extensiones de PHP y la extensión pdo_mysql
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
  && docker-php-ext-install pdo pdo_mysql \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Copiar el código fuente
COPY . /var/www/html/

# Configurar permisos para Apache
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/
