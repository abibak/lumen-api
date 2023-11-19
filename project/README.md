# Lumen app

## Инструкция по запуску проекта

```
git clone https://github.com/abibak/lumen-api.git
```

Запуск приложения из командой строки
```
cd ./deploy

docker-compose build

docker-compose up -d
```

Выполнение миграций
```
docker exec -it deploy-php //bin//sh

php artisan migrate --seed
```


