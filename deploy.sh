#!/bin/bash

set -e

echo "=================================="
echo "🚀 Deploying printerimfu.ru"
echo "=================================="

echo ""
echo "🔍 Checking Git working tree..."

if [ -n "$(git status --porcelain)" ]; then
    echo "❌ Git working tree is not clean!"
    echo ""
    git status --short
    echo ""
    echo "Deployment stopped."
    exit 1
fi

echo "✅ Working tree is clean."

echo ""
echo "📥 Updating code from GitHub..."
git pull --ff-only

echo ""
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo ""
echo "🗄️ Running database migrations..."
php artisan migrate --force

echo ""
echo "🧹 Optimizing Laravel..."
php artisan optimize

echo ""
echo "=================================="
echo "✅ Deployment completed!"
echo "=================================="
