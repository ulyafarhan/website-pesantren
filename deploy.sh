#!/bin/bash
# Skrip ini digunakan untuk melakukan deploy aplikasi Laravel dengan beberapa langkah optimasi dan pembersihan cache.

php artisan config:cache      
php artisan route:cache       
php artisan view:cache        
php artisan event:cache       
php artisan icons:cache       
php artisan filament:cache-components  


php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear


php artisan optimize