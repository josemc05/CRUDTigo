# PRUEBA TÉCNICA  CRUD

Prueba de conocimientos técnicos. Proyecto Laravel 8 - CRUD para manejo de tareas.

## Tabla de Contenidos

- [Instalación](#instalación)
- [Uso](#uso)
- [Funciones del Sistema](#Funciones del Sistema)

## Instalación
Preacondiciones:

-Asegúrese de tener una versión de PHP entre 7.2 y 8.0. Ya que son las compatibles con Laravel.

-Asegúrese de tener una versión de MySQL 5.7 en adelante.

1. Clona este repositorio.
2. Instala las dependencias utilizando el comando `composer install`.
3. Dentro de la carpeta del proyecto, existe una carpeta con el nombre de `BD`, ahí se encuentra un script SQL llamado `BDbase.sql` con los comandos para la creación de la base de datos y los procedimientos almacenados. Se deben ejecutar este script en su programa de gestion de base de datos de preferencia.
4. Editar el archivo `.env.example` cambiando los campos:
    DB_HOST= `Host donde esta ejecutandose MySQL`

    DB_PORT= `Puerto donde esta ejecutandose MySQL`

    DB_DATABASE= `crud_tigo`

    DB_USERNAME= `Usuario de acceso a la base de datos`

    DB_PASSWORD= `Contraseña de acceso a la base de datos`

5. Renombrar el archivo `.env.example` a `.env`. Eliminando el .example. 

## Uso

Ponga en marcha el proyecto con el comando.

```bash
php artisan serve
```

Al ejecutar este comando, le mostrará en que puerto se esta ejecutando el proyecto.

## Funciones del Sistema

El sistema cuenta con la funcionalidad principal de gestionar tareas.

1. Se encontrara un input que permitira agregar una tarea que el usuario escriba a la lista de tareas. Una vez escrita la tarea, se debe proceder a presionar el boton con el simbolo de "+" para agregar la tarea.

2. Las tareas en la lista se podrán:

    2.1 Completar: Al presionar el botón verde con el icono del gancho, se completará la tarea y se tachara el texto. 

    2.2 Editar: Al presionar el botón azul con el icono del lapiz y papel, se habilitará un input en la celda correspondiente a la tarea seleccionada. Ahí, se podrá editar el texto de la tarea y, al presionar `enter`, se actualizará la tarea con el nuevo texto. En caso de que desee dejar de editar o desee salir del modo de edición, se debe dar click nuevamente en el botón azul con el icono del lapiz y papel.
    
    2.3 Eliminar: Al presionar el botón rojo con el icono de la cruz, se mostrará un modal para pedir confirmación de si el usuario está seguro que desea la tarea seleccionada. Al presionar el botón `eliminar` del modal, se efectuará la eliminación.



