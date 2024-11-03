cp .env.example .env

APP_URL=http://localhost:8080
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=user
DB_PASSWORD=password

REDIS_HOST=redis
REDIS_PORT=6379

docker-compose up -d --build

docker-compose exec app composer 
docker-compose exec app php artisan key:generate

docker-compose exec app npm install

docker-compose exec app php artisan migrate:fresh --seed


docker-compose exec app npm run build

http://localhost:8080/login

phpmyadmin 
http://localhost:8081


USER 
admin@example.com
password