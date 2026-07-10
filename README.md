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

## Pagos con MercadoPago (sandbox — opcional)

El circuito de contratación funciona **sin** MercadoPago: si no se configuran credenciales, la reserva se registra directamente como **confirmada**.

Para activar el pago online en modo de prueba, completar en `.env` las credenciales **de prueba** de una aplicación de MercadoPago (Checkout Pro):

```env
MP_ACCESS_TOKEN=APP_USR-...   # Access Token de PRUEBA
MP_PUBLIC_KEY=APP_USR-...     # Public Key de PRUEBA
```

Luego `php artisan config:clear`. Con esto, al reservar la reserva queda **pendiente** y aparece el botón **"Pagar con MercadoPago"**.

Para pagar en el sandbox, en el checkout elegir **"Ingresar con mi cuenta"** e iniciar sesión con una **cuenta de prueba de comprador** de MercadoPago (usuario y contraseña incluidos en `datos.txt`). En `localhost`, tras aprobar el pago se usa el botón **"Ya pagué — verificar estado"** de la reserva para sincronizar el resultado.

### Probar el webhook end-to-end (URL pública con ngrok)

En `localhost` MercadoPago no puede alcanzar el webhook ni redirigir automáticamente. Para verificar el retorno automático y el **webhook** de punta a punta, exponer el sitio con [ngrok](https://ngrok.com/):

```bash
# 1. Levantar el servidor local
php artisan serve --port=8000

# 2. En otra terminal, exponerlo con ngrok
ngrok http 8000
```

ngrok muestra una URL pública, por ejemplo `https://xxxxxxxx.ngrok-free.dev`. Configurarla en `.env`:

```env
APP_URL=https://xxxxxxxx.ngrok-free.dev
```

Luego `php artisan config:clear` y **acceder al sitio desde esa URL de ngrok** (no desde `localhost`). Al pagar, MercadoPago redirige automáticamente a la página de éxito y notifica el pago por webhook, confirmando la reserva sin intervención manual.

> La URL gratuita de ngrok cambia en cada reinicio; hay que actualizar `APP_URL` cada vez. Para la entrega, dejar `APP_URL=http://localhost:8000`.
