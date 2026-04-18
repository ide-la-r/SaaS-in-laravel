#!/bin/bash

echo "Optimizing Laravel application..."

# Cache configuration
php artisan config:cache
echo "✓ Configuration cached"

# Cache routes
php artisan route:cache
echo "✓ Routes cached"

# Cache views
php artisan view:cache
echo "✓ Views cached"

# Optimize class loader
php artisan optimize
echo "✓ Class loader optimized"

echo ""
echo "Application optimized for production!"
