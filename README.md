# Sistema de Evaluación de Proyectos para Feria

## Descripción del Proyecto
El sistema fue desarrollado con el objetivo de registrar proyectos de feria y permitir que un jurado pueda evaluarlos de manera eficiente. Incluye funcionalidades para gestionar equipos, registrar jurados y realizar evaluaciones basadas en distintos criterios.

## Tecnologías Utilizadas
- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Backend:** PHP
- **Base de Datos:** MySQL (MariaDB)
- **Servidor:** Apache/Nginx

## Características Principales
### 📌 Administración
- Registro y gestión de proyectos.
- Registro de jurados con credenciales de acceso.
- Listado de evaluaciones realizadas por los jurados.
- Gestión de equipos y sus integrantes.

### 🎯 Jurado
- Visualización de los proyectos asignados para evaluación.
- Calificación de los proyectos en distintas categorías.
- Confirmación de evaluación antes de guardar los resultados.

## Instalación y Configuración
### 1️⃣ Requisitos
- Servidor con PHP 8.2+.
- MySQL 10.4+ (MariaDB recomendado).

### 2️⃣ Clonar el Repositorio
```bash
git clone https://github.com/usuario/sistema-evaluacion.git
cd sistema-evaluacion
```

### 3️⃣ Configurar el Entorno
Debes dirijirte a la carpeta Administrador, luego en la carpeta config se encuentra la base de datos, los procedimientos almacenados y las vistas necesarias, debes de montar la base de datos con estos archivos .sql
Modificar los valores en `Adminitrador/php/conexionBasededatos.php` con las credenciales de MySQL:
```
$Servidor = "localhost";
$usuario = "root";
$claveSecretaServidor = "";
$nombreBaseDatos = "evaluacionproyectos";
```

### 4️⃣ Iniciar el Servidor
esto en engix o apache dentro de la carpeta www o htdocs

Acceder en el navegador: `http://127.0.0.1/nombreProyecto`

## Capturas de Pantalla
### 🔹 Vista del Administrador
El administrador puede gestionar proyectos, registrar jurados y ver los resultados de las evaluaciones.

![image](https://github.com/user-attachments/assets/9f037742-5f40-4114-af44-e1de51285126)
![image](https://github.com/user-attachments/assets/8017f059-a88f-4786-9da4-5198599cd4d6)
![image](https://github.com/user-attachments/assets/2a217602-50e7-4146-abbe-f9068b49d300)
![image](https://github.com/user-attachments/assets/06b99831-1a2a-4449-ae4f-1c26f75878d5)
![image](https://github.com/user-attachments/assets/536f01f6-c840-4204-b629-9fc417d248fa)
![image](https://github.com/user-attachments/assets/d3513782-8493-45a4-a9ec-ef65837517ff)



### 🔹 Vista del Jurado
El jurado puede visualizar los proyectos asignados, evaluarlos y confirmar su calificación.

![image](https://github.com/user-attachments/assets/eddce148-a0b2-4a56-ba78-f68cff4b363a)

![image](https://github.com/user-attachments/assets/c9e07810-7e2a-4fb3-8a50-95894f24cb35)


## Contacto y Créditos
Desarrollado por **SalvatierraJ**
📧 Contacto: javiersalvatierra44@gmail.com
