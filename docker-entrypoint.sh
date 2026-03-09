#!/bin/bash
set -e

# Configurer le port d'Apache basé sur la variable d'environnement (requis par Render)
export PORT=${PORT:-8000}
sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Exécuter les migrations de base de données
echo "Exécution des migrations..."
php artisan migrate --force

# Nettoyer et mettre en cache les configurations pour la production
echo "Optimisation de Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer le serveur Apache au premier plan
exec apache2-foreground
