#!/bin/bash

# Definir o diretório do projeto
PROJECT_DIR="/var/www/html/onlifin"

echo "Ajustando permissões..."

# Criar diretórios necessários
sudo mkdir -p $PROJECT_DIR/bootstrap/cache
sudo mkdir -p $PROJECT_DIR/storage/logs
sudo mkdir -p $PROJECT_DIR/storage/framework/cache
sudo mkdir -p $PROJECT_DIR/storage/framework/sessions
sudo mkdir -p $PROJECT_DIR/storage/framework/views

# Criar arquivo de log se não existir
sudo touch $PROJECT_DIR/storage/logs/laravel.log

# Ajustar propriedade dos diretórios
sudo chown -R www-data:www-data $PROJECT_DIR/storage
sudo chown -R www-data:www-data $PROJECT_DIR/bootstrap
sudo chown -R www-data:www-data $PROJECT_DIR/public

# Ajustar permissões específicas
sudo find $PROJECT_DIR/storage -type f -exec chmod 664 {} \;
sudo find $PROJECT_DIR/storage -type d -exec chmod 775 {} \;
sudo find $PROJECT_DIR/bootstrap -type f -exec chmod 664 {} \;
sudo find $PROJECT_DIR/bootstrap -type d -exec chmod 775 {} \;
sudo find $PROJECT_DIR/public -type f -exec chmod 664 {} \;
sudo find $PROJECT_DIR/public -type d -exec chmod 775 {} \;

# Garantir permissões específicas para arquivos críticos
sudo chmod 775 $PROJECT_DIR/storage/logs
sudo chmod 664 $PROJECT_DIR/storage/logs/laravel.log
sudo chmod -R 775 $PROJECT_DIR/storage/framework
sudo chmod -R 775 $PROJECT_DIR/bootstrap/cache

echo "Permissões ajustadas com sucesso!" 