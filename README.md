# RentaCar

Sitio web de alquiler de autos desarrollado con **Laravel 12**. Trabajo Práctico para la materia **Producción Web**.

## Requisitos

- PHP 8.2 o superior
- Composer
- MySQL / MariaDB en ejecución (por ejemplo, XAMPP)

## Preparar el servidor de base de datos

Si se utiliza **XAMPP**:

1. Abrir el panel de XAMPP.
2. Iniciar:
   - MySQL Database
   - Apache Web Server (necesario para acceder a phpMyAdmin)
3. Abrir [http://localhost/phpmyadmin](http://localhost/phpmyadmin) y crear una base de datos vacía llamada **`rentacar`** con cotejamiento `utf8mb4_unicode_ci`.

## Pasos para ejecutar el proyecto

```bash
# 1. Instalar dependencias
composer install

# 2. Copiar el archivo de entorno
cp .env.example .env

# 3. Configurar la conexión a la base de datos en .env
#    DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 4. Generar la clave de la aplicación
php artisan key:generate

# 5. Ejecutar migraciones y seeders
php artisan migrate --seed

# 6. Levantar el servidor de desarrollo
php artisan serve
```

El sitio queda disponible en **http://localhost:8000**.
