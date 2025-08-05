# Utilise l'image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions nécessaires (ex: PDO MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Active mod_rewrite (utile si tu as des .htaccess ou Laravel)
RUN a2enmod rewrite

# 👇 Ajoute cette ligne pour définir index.php comme page d'accueil
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Copie tous les fichiers du dossier local vers le dossier du serveur
COPY . /var/www/html/

# Autorise le port 80
EXPOSE 80
