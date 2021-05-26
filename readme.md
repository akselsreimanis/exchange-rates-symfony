# Exchange rates using Symfony

``` docker-compose up --build -d```

``` docker exec exchange_rates_app sh -c "cd /var/www/exchange_rates/ && npm install && composer install && npm run build --prod && bin/console doctrine:migrations:migrate && bin/console rates:import"```