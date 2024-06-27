CREATE DATABASE crud_tigo;

USE crud_tigo;

/* Crear tabla */
CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estatus ENUM('nueva', 'completada') NOT NULL DEFAULT 'nueva',
    tarea VARCHAR(250) NOT NULL
);

/* PROCEDIMIENTOS ALMACENADOS */

/* Crear tarea */
DELIMITER //

CREATE PROCEDURE CrearTarea (
    IN p_tarea VARCHAR(250)
)
BEGIN
    INSERT INTO tareas (tarea) VALUES ( p_tarea);
END //

DELIMITER ;

/* Modificar Tarea */
DELIMITER //

CREATE PROCEDURE ModificarTarea (
    IN p_id INT,
    IN p_tarea VARCHAR(250)
)
BEGIN
    UPDATE tareas
    SET tarea = p_tarea
    WHERE id = p_id;
END //

DELIMITER ;

/* Eliminar Tarea */
DELIMITER //

CREATE PROCEDURE EliminarTarea (
    IN p_id INT
)
BEGIN
    DELETE FROM tareas WHERE id = p_id;
END //

DELIMITER ;

/* Actualizar Estatus de Tarea */
DELIMITER //

CREATE PROCEDURE CompletarTarea (
    IN p_id INT
)
BEGIN
    UPDATE tareas
    SET estatus = 'completada'
    WHERE id = p_id;
END //

DELIMITER ;
