<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Тестовое задание интеграции с API на фреймворке Laravel

### Реализована выгрузка данных из API в БД по эндпоинтам:

- Данные из продаж
- Данные из заказов
- Данные из складов
- Данные из доходов

### Для выгрузки потребуется:

- Установить БД MySQL 8.0+ / PHP 8.3 (Рекомендуется)
- Указать подключение к БД в файле .env
- Прописать API_URL в файле .env
- Прописать API_KEY в файле .env
- Провести миграции
- Зависимости composer и npm устанавливать НЕ нужно

## Выгрузка происходит через консольную команду app:fetch

Дата указывается в формате Y-m-d
Флаги --page и --limit не обязательны, но можно указать нужную страницу и лимит

### Выгрузка из продаж:

```
php artisan app:fetch sales (дата от) (дата до) --page 1 --limit 100
```

### Выгрузка из заказов:

```
php artisan app:fetch orders (дата от) (дата до) --page 1 --limit 100
```

### Выгрузка из складов:
Выгрузка только за текущий день
```
php artisan app:fetch stocks (текущая дата) --page 1 --limit 100
```

### Выгрузка из доходов:

```
php artisan app:fetch incomes (дата от) (дата до) --page 1 --limit 100
```
