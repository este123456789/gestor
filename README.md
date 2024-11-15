
```markdown
# Gestión de Tareas con Laravel y Vue.js

Este proyecto utiliza **Laravel**, **Vue.js** y **Breeze** para crear una aplicación web de gestión de tareas. Aquí se describe el paso a paso de cómo instalar y configurar el proyecto.

---

## Requisitos

- PHP >= 7.4
- Composer
- Node.js >= 14.x
- NPM

---

## Pasos para la Instalación

### 1. **Crear el Proyecto Laravel**

Primero, creamos un nuevo proyecto de Laravel utilizando el siguiente comando:

```bash
composer create-project --prefer-dist laravel/laravel gestion-de-tareas
```

### 2. **Instalar Axios para las solicitudes HTTP**

Instalamos `axios` para manejar las solicitudes HTTP en el frontend:

```bash
npm install axios
npm run dev
```

### 3. **Instalar Laravel Breeze para Autenticación**

Laravel Breeze es un paquete que facilita la configuración de la autenticación. Lo instalamos con:

```bash
composer require laravel/breeze --dev
php artisan breeze:install vue
```

Luego de instalar Breeze, debes instalar las dependencias de frontend y compilar los assets:

```bash
npm install && npm run dev
```

### 4. **Migrar las Tablas de la Base de Datos**

Ejecuta las migraciones para crear las tablas necesarias en la base de datos:

```bash
php artisan migrate
```

---

## Crear Modelos y Controladores

### 5. **Crear el Modelo `Task` y su Migración**

El siguiente comando crea el modelo `Task` y la migración correspondiente:

```bash
php artisan make:model Task -m
```

### 6. **Crear el Controlador `TaskController`**

Generamos el controlador para gestionar las tareas:

```bash
php artisan make:controller TaskController
```

---

## Crear Seeder para Usuarios

### 7. **Crear Seeder para la Tabla de Usuarios**

El siguiente comando crea el seeder para llenar la tabla `users` con datos de ejemplo:

```bash
php artisan make:seeder UsersTableSeeder
```

### 8. **Ejecutar Seeder para Poblar la Base de Datos**

Ejecuta el seeder para agregar usuarios a la base de datos:

```bash
php artisan db:seed
php artisan db:seed --class=UsersTableSeeder
```

---

## Rutas del API

En esta aplicación, las siguientes rutas del **API** se encargan de gestionar las tareas. Estas rutas están definidas en el archivo `routes/api.php`:

```php
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleCompletion']);
```

Estas rutas manejan las operaciones CRUD de las tareas y permiten lo siguiente:

- **GET `/tasks`**: Obtener la lista de todas las tareas.
- **POST `/tasks`**: Crear una nueva tarea.
- **PUT `/tasks/{task}`**: Actualizar una tarea existente.
- **DELETE `/tasks/{task}`**: Eliminar una tarea.
- **PATCH `/tasks/{task}/toggle`**: Cambiar el estado de completada a incompleta (y viceversa).

---

## Rutas Web

Las siguientes rutas web están definidas en el archivo `routes/web.php` y se utilizan para renderizar las vistas con **Inertia.js**:

```php
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/alltasks', function () {
    return Inertia::render('AllTasks');
})->middleware(['auth', 'verified'])->name('alltasks');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
```

Estas rutas gestionan la autenticación, el perfil del usuario y el acceso al dashboard y la vista de tareas.

---

## Conclusión

Con estos pasos hemos configurado la base de nuestro proyecto de gestión de tareas utilizando Laravel y Vue.js. Ahora puedes continuar con la creación de las rutas, vistas y lógica de la aplicación para gestionar las tareas de forma eficiente.

---

## Comandos Rápidos

Aquí tienes un resumen de los comandos utilizados:

- **Crear Proyecto Laravel:**
  ```bash
  composer create-project --prefer-dist laravel/laravel gestion-de-tareas
  ```

- **Instalar Axios:**
  ```bash
  npm install axios
  npm run dev
  ```

- **Instalar Laravel Breeze:**
  ```bash
  composer require laravel/breeze --dev
  php artisan breeze:install vue
  npm install && npm run dev
  ```

- **Migrar la Base de Datos:**
  ```bash
  php artisan migrate
  ```

- **Crear Modelo y Migración para `Task`:**
  ```bash
  php artisan make:model Task -m
  ```

- **Crear Controlador `TaskController`:**
  ```bash
  php artisan make:controller TaskController
  ```

- **Crear Seeder para `Users`:**
  ```bash
  php artisan make:seeder UsersTableSeeder
  ```

- **Ejecutar Seeder:**
  ```bash
  php artisan db:seed
  php artisan db:seed --class=UsersTableSeeder
  ```

---

## Iconos

[![Laravel](https://img.shields.io/badge/Laravel-ff2d20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-4FC08D?style=flat-square&logo=vue.js&logoColor=white)](https://vuejs.org/)
[![Axios](https://img.shields.io/badge/Axios-5A29E1?style=flat-square&logo=axios&logoColor=white)](https://axios-http.com/)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![Node.js](https://img.shields.io/badge/Node.js-339933?style=flat-square&logo=node.js&logoColor=white)](https://nodejs.org/)

---

## Autor

Este proyecto fue creado por **Esteban Villa**.

```

### Cambios realizados:
- **Sección "Rutas del API"**: Explicación de las rutas del API definidas en `routes/api.php`, explicando cómo interactúan con el controlador `TaskController`.
- **Sección "Rutas Web"**: Explicación de las rutas web definidas en `routes/web.php`, incluyendo las rutas de la página de bienvenida, dashboard, y las tareas.
- **Sección "Autor"**: Al final del documento, se agrega el nombre del autor, **Esteban Villa**.

Este `README.md` ahora está completo y cubre todo el proceso de instalación, configuración y detalles clave del proyecto.