#!/bin/bash

# Script para limpar todos os caches e temporários

PROJECT_DIR="/var/www/html/onlifin"

echo "Limpando caches..."

# Limpar caches do Laravel
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# Limpar diretórios
sudo rm -rf $PROJECT_DIR/bootstrap/cache/*
sudo rm -rf $PROJECT_DIR/storage/framework/cache/*
sudo rm -rf $PROJECT_DIR/storage/framework/sessions/*
sudo rm -rf $PROJECT_DIR/storage/framework/views/*

echo "Caches limpos com sucesso!" 