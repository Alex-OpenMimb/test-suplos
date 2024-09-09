# Prueba Técnica - Sistema de Gestión de Tareas

## Descripción del Proyecto

Este proyecto es un sistema básico de gestión de tareas desarrollado con Laravel y Vue.js. El objetivo de esta prueba técnica es identificar y corregir errores en el código tanto en el backend como en el frontend. El sistema permite a los usuarios crear, actualizar, eliminar y visualizar tareas.

## Objetivo de la Prueba

El objetivo principal de esta prueba es evaluar tus habilidades para depurar y corregir errores en un proyecto existente que utiliza Laravel, PHP, JavaScript, y Vue.js. Deberás:

- Identificar y corregir errores en el backend relacionado con la creación, actualización, eliminación y validación de tareas.
- Corregir problemas en el frontend que afectan la visualización y manejo de la lista de tareas.
- Asegurarte de que las tareas se gestionen correctamente en la interfaz de usuario.

Además, deberás agregar una funcionalidad extra para filtrar las tareas completadas y pendientes.

## Instrucciones de Instalación

Sigue los siguientes pasos para configurar el proyecto en tu entorno local:


1. **Clona el repositorio:**

       Prueba-Soporte
   
2. **Instala las dependencias de PHP y Node.js:**

   .Composer: Para instalar las dependencias de PHP, ejecuta:
   
        composer install

   .NPM: Para instalar las dependencias de Node.js, ejecuta:

        npm install
        npm run dev

3. **Configura el archivo de entorno .env:**

   .Copia el archivo .env.example a .env:

       cp .env.example .env
   
   .Genera la clave de la aplicación:

       php artisan key:generate
   
   .Configura la base de datos en el archivo .env. Asegúrate de tener una base de datos MySQL disponible y configurada.
   
4. **Ejecuta las migraciones para crear las tablas necesarias:**

       php artisan migrate

5. **Compilar Recursos de Frontend:**

   .Compila los archivos de frontend utilizando Laravel Mix:

       npm run dev

6. **Iniciar el Servidor:**

   .Inicia el servidor de desarrollo de Laravel:

       php artisan serve

       
**Objetivo de la Prueba**

El proyecto contiene errores tanto en el backend (Laravel/PHP) como en el frontend (JavaScript). Tu objetivo es:

 1.Identificar los errores en el código.
 2.Corregir los errores para que la aplicación funcione correctamente.
 3.Probar la aplicación después de realizar las correcciones para asegurarte de que todo funcione como se espera.
 
**Entrega**

Sube el código corregido a un repositorio de GitHub y envíanos el enlace. Asegúrate de describir los problemas que encontraste y cómo los solucionaste en este archivo README.md.

**Notas**

Puedes añadir cualquier comentario adicional sobre las decisiones que tomaste al corregir el código.
Recuerda que el objetivo es demostrar tu capacidad para depurar y mejorar código existente.

¡Buena suerte!

**Correcciones**
Backend
 1. La declaración de la foreign key user_id en la tabla task se elimina un método y se usa el adecuado.
 2. En el modelo task se agrega en las propiedades fillable la "completed" 
 3. En el controlador se eliminan las validaciones de los métodos, para validar se crea un Task Requestel cual valida por método del protocolo http y retorna un mensaje de error para darle manejo en el front.
 4. En el taskController:
     4.1. Se agrega el método para completar la tarea, filtrar y listar.
     4.2. Los métodos existentes se optimizan utilizando inyeción de depencia.
     4.3. Se crea un método para manjear las respuestas.
     4.4. En el método create se retorna la tarea creada con el nombre del usuario, el cuál se obtiene con una cossulta.
5. En Sotorage:
    5.1. Se crea una mutación para mostrar los errores, SET_ERROR_MESSAGE.
    5.2. Se crea la mutación SET_TASKS para agregar las tareas que se listarán en la interfaz.
    5.3. La mutacion addTask se obtiene la tarea creada para visualizar en el componente.
6. En el Componente.
    6.1 se crea la propiedad "completed" para manejar el filtro de las tareas.
    6.2 Se crea una tabla la cual rednderiza los datos con "tasksList".
    6.3 Se crea un modal el cual utiliza "selectedTask" para renderizar la tarea a editar.
    6.4.Se agrega una validación para el email.
    6.5. Se muestra el mensaje de error que podría ocurrir al crear una tarea.
    6.6. El action fetchTask es empleado en distintas partes para obtener la tarea cuando estás son afectas en la db.
7. Se crea un seeder para los usuarios.
8. Se el action para obtener las tareas en el hook mounted.
9. Se utiliza un watch para hacer los filtros.
10. Se corrige la vista blade del task.
11. Se cambia el nombre de la db=prueba-soporte,  ven .env.
