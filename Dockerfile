# Utilisation de l'image officielle PHP avec Apache
FROM php:8.1-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Afficher les fichiers avant la copie (pour débogage)
#RUN echo "Avant copie :" && ls -la /var/www/html

# Modifier les permissions des fichiers
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Copier les fichiers du projet dans le conteneur
#COPY . .

# Copier les fichiers du sous-répertoire Projetkarl dans le conteneur
COPY . .


# Afficher les fichiers après la copie (pour débogage)
RUN echo "Après copie :" && ls -la /var/www/html

# Modifier les permissions des fichiers
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Exposer le port 80 pour Apache
EXPOSE 80

# Lancer Apache en mode foreground pour éviter que le conteneur ne s’arrête
CMD ["apache2-foreground"]
