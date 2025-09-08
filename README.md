**Post Venta** 
Es una aplicación web desarrollada con tecnologías como lo son PHP, JavaScript, Bootstrap y jQuery. 
Está diseñada para gestionar procesos de post‑venta aplicando la arquitectura MVC con una interfaz de usuario moderna.

##  Tecnologías utilizadas
- **Backend / Lógica de servidor:** PHP (estructura MVC: Models, Views, Controllers)  
- **Interfaz y frontend:** JavaScript, CSS y Bootstrap  
- **Interactividad:** jQuery para dinamismo.
- **Base de datos:** MySQL (con conectividad mediante PHP).
- **Generación de documentos:** Biblioteca FPDF integrada (`libraries/fpdf`).
- **Arquitectura de archivos:**  
  - `Assets/`: recursos visuales (imágenes, estilos, scripts adicionales).
  - `Config/`: archivos de configuración (como conexión a BD, rutas, constantes).
  - `Controllers/`: lógica de control, validación y coordinación entre modelos y vistas.
  - `Models/`: acceso y manipulación de datos en la base de datos MySQL.
  - `Views/`: plantillas HTML con Bootstrap + jQuery para interacción con el usuario  .
  - `index.php`: punto de entrada principal a la aplicación.
 
**Prepara tu entorno local**

-Instala XAMPP, WAMP u otro servidor compatible con PHP y MySQL.
-Asegúrate de habilitar Apache y MySQL.
-Configura la base de datos.
-Host (por defecto: localhost).
-Usuario y contraseña de MySQL.
-Nombre de la base de datos.

**Coloca el proyecto en tu servidor**
-Copia la carpeta del proyecto a la ruta pública del servidor (por ejemplo, htdocs/ en XAMPP).

**Funcionalidades principales**
-Gestión de post‑venta mediante un flujo MVC organizado.
-Creación y descarga de documentos en formato PDF usando FPDF en la generación de facturas.
-Interactividad dinámica con jQuery y AJAX: actualización de datos sin recarga completa.
-Interfaz responsive y estilizada con Bootstrap.
-Conexión segura a MySQL vía PHP para operaciones CRUD (Create, Read, Update, Delete).

**Estructura de Carpetas**
Post_venta--PHP-Javascript-CSS-Bootstrap-Jquery-MySql/
│
├── Assets/              # Recursos (imágenes, CSS personalizados, JS adicionales)
├── Config/              # Configuraciones (BD, rutas, etc.)
├── Controllers/         # Controladores de la aplicación
├── Models/              # Modelos de datos (Base de datos)
├── Views/               # Vistas (HTML + Bootstrap + jQuery)
├── libraries/
│   └── fpdf/            # Biblioteca para generar PDFs
├── index.php            # Punto de entrada principal
└── .htaccess            # Reglas de servidor (opcional)
