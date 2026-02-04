web: php -r "file_exists('.env') || copy('.env.example', '.env');" && php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
