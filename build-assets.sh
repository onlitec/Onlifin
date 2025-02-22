#!/bin/bash

# Definir o diretório do projeto
PROJECT_DIR="/var/www/html/onlifin"

echo "Iniciando ajuste de permissões e build..."

# Parar serviços
sudo systemctl stop nginx
sudo systemctl stop php8.2-fpm

# Limpar diretórios
sudo rm -rf $PROJECT_DIR/public/build
sudo rm -rf $PROJECT_DIR/node_modules
sudo rm -rf $PROJECT_DIR/bootstrap/cache/*
sudo rm -rf $PROJECT_DIR/storage/logs/*
sudo rm -rf $PROJECT_DIR/storage/framework/cache/*
sudo rm -rf $PROJECT_DIR/storage/framework/sessions/*
sudo rm -rf $PROJECT_DIR/storage/framework/views/*
rm -f $PROJECT_DIR/package-lock.json

# Criar diretórios necessários
sudo mkdir -p $PROJECT_DIR/public/build
sudo mkdir -p $PROJECT_DIR/bootstrap/cache
sudo mkdir -p $PROJECT_DIR/storage/logs
sudo mkdir -p $PROJECT_DIR/storage/framework/cache
sudo mkdir -p $PROJECT_DIR/storage/framework/sessions
sudo mkdir -p $PROJECT_DIR/storage/framework/views

# Criar arquivo de log
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

# Permissões temporárias para build
sudo chown -R $USER:$USER $PROJECT_DIR
sudo chmod -R 775 $PROJECT_DIR

# Instalar dependências e fazer build
cd $PROJECT_DIR
npm install
npm run build

# Mover o manifest.json para o local correto se necessário
if [ -f "$PROJECT_DIR/public/build/.vite/manifest.json" ]; then
    sudo mv $PROJECT_DIR/public/build/.vite/manifest.json $PROJECT_DIR/public/build/manifest.json
fi

# Verificar se o build foi criado
if [ ! -f "$PROJECT_DIR/public/build/manifest.json" ]; then
    echo "Erro: manifest.json não foi criado!"
    exit 1
fi

# Restaurar permissões corretas
sudo chown -R www-data:www-data $PROJECT_DIR/storage
sudo chown -R www-data:www-data $PROJECT_DIR/bootstrap
sudo chown -R www-data:www-data $PROJECT_DIR/public/build

# Garantir permissões específicas novamente
sudo chmod 775 $PROJECT_DIR/storage/logs
sudo chmod 664 $PROJECT_DIR/storage/logs/laravel.log
sudo chmod -R 775 $PROJECT_DIR/storage/framework
sudo chmod -R 775 $PROJECT_DIR/bootstrap/cache

# Reiniciar serviços
sudo systemctl start php8.2-fpm
sudo systemctl start nginx

echo "Build concluído com sucesso!"

# Mostrar conteúdo do manifest
echo "Conteúdo do manifest.json:"
cat $PROJECT_DIR/public/build/manifest.json

# Verificar permissões
echo -e "\nVerificando permissões críticas:"
ls -la $PROJECT_DIR/storage/logs/laravel.log
ls -la $PROJECT_DIR/bootstrap/cache
ls -la $PROJECT_DIR/storage/framework 