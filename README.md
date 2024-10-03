# Prueba_ToDo

## Descripción
Esta es una aplicación de gestión de notas que permite a los usuarios crear, editar y eliminar notas, así como organizar sus notas por fecha de vencimiento y fecha de creación. La aplicación está construida con **Laravel 11** para el backend y **Vue.js** para el frontend, ofreciendo una interfaz de usuario interactiva y moderna.

## Funcionalidades
- **Registro de Usuarios**: Los usuarios pueden registrarse y acceder a la aplicación.
- **Gestión de Notas**:
  - Crear nuevas notas.
  - Editar notas existentes.
  - Eliminar notas.
  - Organizar notas por fecha de vencimiento o fecha de creación.
- **Interfaz Amigable**: Estilo visual atractivo utilizando colores pastel.
- **Modales para Crear y Editar Notas**: Utiliza modales para la creación y edición de notas.

## Tecnologías Utilizadas
- **Backend**: Laravel 11
- **Frontend**: Vue.js
- **Estilos**: CSS 
- **Base de Datos**: MySQL

## Instalación
Sigue estos pasos para configurar el proyecto en tu entorno local:

1. Clona el repositorio:
   ```bash
   git clone <URL_DEL_REPOSITORIO>
   ```

2. Navega a la carpeta del proyecto:
   ```bash
   cd nombre-del-proyecto
   ```

3. Instala las dependencias de backend:
   ```bash
   composer install
   ```

4. Configura el archivo `.env`:
   ```bash
   cp .env.example .env
   ```
   Modifica las configuraciones de base de datos y otras variables necesarias.

5. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

6. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```

7. Instala las dependencias de frontend:
   ```bash
   npm install
   ```

8. Compila los recursos:
   ```bash
   npm run dev
   ```

9. Ejecuta el servidor:
   ```bash
   php artisan serve
   ```

## Uso
1. Abre tu navegador y ve a `http://127.0.0.1:8000`.
2. Regístrate o inicia sesión para comenzar a utilizar la aplicación.

## Contribuciones
Las contribuciones son bienvenidas. Si deseas contribuir al proyecto, por favor sigue estos pasos:

1. Realiza un fork del repositorio.
2. Crea una nueva rama (`git checkout -b feature/nueva-caracteristica`).
3. Realiza tus cambios y haz un commit (`git commit -m 'Añadir nueva característica'`).
4. Sube tus cambios (`git push origin feature/nueva-caracteristica`).
5. Abre un Pull Request.
