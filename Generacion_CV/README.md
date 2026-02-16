# Generador de CV con PHP y MySQL

Sistema completo para crear, gestionar y visualizar Currículums Vitae de forma profesional.

## Características

 Formulario dinámico para crear CVs
 Gestión de múltiples secciones (experiencia, formación, habilidades, idiomas)
 Sistema de versiones (cada edición crea una nueva versión)
 Subida de foto opcional
 Visualización limpia y profesional
 Exportación a PDF desde el navegador
 Diseño responsive con Bootstrap
 Código separado (PHP, JS, HTML, CSS)

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Extensiones PHP: mysqli, gd (para imágenes)

## Instalación

### 1. Configurar la base de datos

```bash
# Acceder a MySQL
mysql -u root -p

# Ejecutar el script de base de datos
source database.sql
```

O importar manualmente el archivo `database.sql` desde phpMyAdmin.

### 2. Configurar la conexión

Editar el archivo `config.php` y ajustar las credenciales de MySQL:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('DB_NAME', 'cv_generator');
```

### 3. Crear directorio de uploads

```bash
mkdir uploads
chmod 777 uploads
```

### 4. Configurar el servidor web

#### Apache
Asegurarse de que el módulo `mod_rewrite` está activado y colocar los archivos en el directorio web (`/var/www/html` o `htdocs`).

#### PHP Built-in Server (para desarrollo)
```bash
php -S localhost:8000
```

Acceder a: `http://localhost:8000`

## Estructura del proyecto

```
cv-generator/
├── config.php              # Configuración de base de datos
├── database.sql            # Script de creación de BD
├── index.php               # Formulario de creación
├── procesar.php            # Procesamiento de datos
├── ver_cv.php              # Visualización del CV
├── editar.php              # Edición de CV (crea nueva versión)
├── listar.php              # Lista de todos los CVs
├── eliminar.php            # Eliminación de CVs
├── css/
│   └── styles.css          # Estilos personalizados
├── js/
│   ├── formulario.js       # Funciones del formulario dinámico
│   ├── editar.js           # Carga de datos en edición
│   └── listar.js           # Funciones de la lista
├── uploads/                # Directorio para fotos (crear manualmente)
└── README.md              # Este archivo
```

## Uso

### Crear un nuevo CV

1. Acceder a la página principal
2. Rellenar el formulario con tus datos personales
3. Añadir experiencias, formación, habilidades e idiomas usando los botones "Añadir"
4. Subir una foto (opcional)
5. Hacer clic en "Guardar y Generar CV"

### Ver CVs guardados

1. Ir a "Ver CVs Guardados" en el menú
2. Seleccionar el CV que quieres ver
3. Usar el botón "Imprimir/PDF" para exportar

### Editar un CV

1. Desde la lista de CVs o desde la visualización, hacer clic en "Editar"
2. Modificar los campos necesarios
3. Al guardar, se creará automáticamente una nueva versión

### Eliminar un CV

1. Desde la lista de CVs, hacer clic en "Eliminar"
2. Confirmar la eliminación

## Características técnicas

### Sistema de versiones
Cada vez que editas un CV, se crea una nueva versión manteniendo el historial completo. Esto permite:
- Ver versiones anteriores
- Comparar cambios
- Recuperar información antigua

### Campos dinámicos
Los campos de experiencia, formación, habilidades e idiomas son completamente dinámicos:
- Añadir múltiples entradas
- Eliminar entradas individuales
- Sin límite de cantidad

### Seguridad
- Validación de datos en cliente y servidor
- Protección contra SQL Injection usando prepared statements
- Validación de tipos de archivo para fotos
- Límite de tamaño de archivo (2MB)
- Escapado de HTML para prevenir XSS

### Responsive Design
El diseño se adapta a diferentes tamaños de pantalla:
- Desktop
- Tablet
- Móvil

## Personalización

### Cambiar estilos
Editar el archivo `css/styles.css` para modificar colores, fuentes, espaciados, etc.

### Añadir nuevos campos
1. Agregar campos al formulario en `index.php`
2. Añadir campos a la tabla en `database.sql`
3. Procesar en `procesar.php`
4. Mostrar en `ver_cv.php`

### Modificar niveles de habilidades/idiomas
Editar los ENUM en `database.sql` y actualizar los select en los archivos JS.

## Solución de problemas

### Error de conexión a la base de datos
- Verificar credenciales en `config.php`
- Asegurar que MySQL está ejecutándose
- Verificar que la base de datos existe

### Las fotos no se suben
- Verificar que el directorio `uploads/` existe
- Verificar permisos (chmod 777)
- Verificar tamaño máximo de upload en `php.ini`

### Los formularios dinámicos no funcionan
- Verificar que los archivos JS están cargando correctamente
- Abrir la consola del navegador para ver errores
- Verificar que Bootstrap está cargando

## Tecnologías utilizadas

- **Backend**: PHP 7.4+
- **Base de datos**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Framework CSS**: Bootstrap 5.3
- **Iconos**: Bootstrap Icons

## Licencia

Este proyecto es de código abierto y está disponible para uso educativo y comercial.

## Autor

Desarrollado como proyecto educativo de generador de CVs.
