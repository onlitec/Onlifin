#!/bin/bash

# Definir o diretório do projeto
PROJECT_DIR="/var/www/html/onlifin"

echo "Iniciando ajuste de permissões..."

# Parar serviços
sudo systemctl stop php8.2-fpm
sudo systemctl stop nginx

# Remover arquivos de cache e build
sudo rm -rf $PROJECT_DIR/storage/logs/*
sudo rm -rf $PROJECT_DIR/storage/framework/cache/*
sudo rm -rf $PROJECT_DIR/storage/framework/sessions/*
sudo rm -rf $PROJECT_DIR/storage/framework/views/*
sudo rm -rf $PROJECT_DIR/bootstrap/cache/*
sudo rm -rf $PROJECT_DIR/public/build/*
sudo rm -rf $PROJECT_DIR/node_modules
sudo rm -f $PROJECT_DIR/package-lock.json

# Criar diretórios necessários
sudo mkdir -p $PROJECT_DIR/bootstrap/cache
sudo mkdir -p $PROJECT_DIR/storage/framework/cache
sudo mkdir -p $PROJECT_DIR/storage/framework/sessions
sudo mkdir -p $PROJECT_DIR/storage/framework/views
sudo mkdir -p $PROJECT_DIR/storage/logs
sudo mkdir -p $PROJECT_DIR/public/build

# Criar arquivo de log
sudo touch $PROJECT_DIR/storage/logs/laravel.log

# Ajustar propriedade dos diretórios
sudo chown -R www-data:www-data $PROJECT_DIR/storage
sudo chown -R www-data:www-data $PROJECT_DIR/bootstrap
sudo chown -R www-data:www-data $PROJECT_DIR/public
sudo chown -R $USER:$USER $PROJECT_DIR/node_modules
sudo chown -R $USER:$USER $PROJECT_DIR/public/build
sudo chown $USER:$USER $PROJECT_DIR/package-lock.json

# Ajustar permissões
sudo find $PROJECT_DIR/storage -type f -exec chmod 664 {} \;
sudo find $PROJECT_DIR/storage -type d -exec chmod 775 {} \;
sudo find $PROJECT_DIR/bootstrap -type f -exec chmod 664 {} \;
sudo find $PROJECT_DIR/bootstrap -type d -exec chmod 775 {} \;
sudo find $PROJECT_DIR/public -type f -exec chmod 664 {} \;
sudo find $PROJECT_DIR/public -type d -exec chmod 775 {} \;

# Garantir que o arquivo de log seja gravável
sudo chmod 664 $PROJECT_DIR/storage/logs/laravel.log

# Limpar caches do Laravel
cd $PROJECT_DIR
sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan view:clear
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan optimize:clear

# Reiniciar serviços
sudo systemctl start php8.2-fpm
sudo systemctl start nginx

echo "Permissões ajustadas e caches limpos com sucesso!" 