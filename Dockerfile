# Utilise l'image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions nécessaires (ex: PDO MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Copie tous les fichiers du dossier local vers le dossier du serveur
COPY . /var/www/html/

# Autorise le port 80
EXPOSE 80
