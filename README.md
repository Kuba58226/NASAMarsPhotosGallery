# NASAMarsPhotosGallery

## Commands:
### Update polish holidays table:
```php artisan RefreshDates```
### Update NASA images data based on polish holidays:
```php artisan RefreshImages```
## Installation
- ```cd server```
- ```composer install```
- ```copy .env.example .env```
- In the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options to match the credentials of the database you created.
- ```php artisan migrate```
- ```php artisan serve```
