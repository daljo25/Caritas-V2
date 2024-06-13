# Caritas-V2

Caritas-V2 es una aplicación web para gestionar donantes y donaciones. Está construida con Laravel 10 y utiliza FilamentPHP 3 para el panel de administración.

## Características

- Gestión de donantes
- Gestión de donaciones
- Panel de administración con FilamentPHP
- Autenticación de usuarios

## Requisitos

- PHP 8.1 o superior
- Composer
- Node.js y npm
- MySQL o cualquier otra base de datos compatible con Laravel

## Instalación

Sigue estos pasos para configurar y ejecutar el proyecto localmente.

1. Clonar el repositorio:

    ```bash
    git clone https://github.com/daljo25/Caritas-V2.git
    cd Caritas-V2
    ```

2. Instalar dependencias de PHP con Composer:

    ```bash
    composer install
    ```

3. Instalar dependencias de Node.js con npm:

    ```bash
    npm install
    ```

4. Copiar el archivo `.env.example` a `.env` y configurar la base de datos y otras variables de entorno:

    ```bash
    cp .env.example .env
    ```

5. Generar la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

6. Ejecutar las migraciones y los seeders:

    ```bash
    php artisan migrate --seed
    ```

7. Compilar los assets de frontend:

    ```bash
    npm run dev
    ```

8. Iniciar el servidor de desarrollo:

    ```bash
    php artisan serve
    ```

## Uso

Después de seguir los pasos de instalación, puedes acceder a la aplicación en `http://localhost:8000`. Utiliza el panel de administración de Filament para gestionar donantes y donaciones.

## Panel de Administración

El panel de administración de Filament está disponible en `http://localhost:8000/dashboard`.

## Contribuir

Las contribuciones son bienvenidas. Por favor, abre un issue o envía un pull request para discutir los cambios propuestos.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

## Contacto

Para cualquier pregunta o comentario, por favor contacta a [daljo25](https://github.com/daljo25].

