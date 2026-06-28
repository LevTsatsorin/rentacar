# RentaCar

Sitio web de alquiler de autos desarrollado con **Laravel 12**. Trabajo Práctico para la materia **Portales y Comercio Electrónico**.

Incluye un sitio público (inicio, flota, blog y contacto), registro e inicio de sesión de usuarios, y un panel de administración protegido por rol con ABM del blog (carga y cambio de imágenes) y listado de usuarios con sus alquileres contratados.

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

# 3. Generar la clave de la aplicación
php artisan key:generate

# 4. Configurar la conexión a la base de datos en .env
#    DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5. Ejecutar migraciones y seeders
php artisan migrate:fresh --seed

# 6. Enlazar el almacenamiento público (imágenes del blog)
php artisan storage:link

# 7. Levantar el servidor de desarrollo
php artisan serve
```

El sitio queda disponible en **http://localhost:8000**.

## Usuarios de prueba (cargados por el seeder)

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | `admin@rentacar.test` | `password` |
| Usuario | `cliente@rentacar.test` | `password` |

El panel de administración está en **`/admin`** y requiere iniciar sesión con el usuario administrador.
