DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarEstadoUsuario`(IN idUsuario INT, IN nuevoEstado VARCHAR(255))
BEGIN
  UPDATE usuarios
  SET estado = nuevoEstado
  WHERE id = idUsuario;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `guardarEquipo`(IN `nombreProyecto` VARCHAR(255), IN `nombreEquipo` VARCHAR(255), IN `integrantes` VARCHAR(255))
BEGIN
    DECLARE integrante VARCHAR(255);
    DECLARE done INT DEFAULT FALSE;
    DECLARE cur CURSOR FOR SELECT TRIM(value) FROM integrantes;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    START TRANSACTION;

    INSERT INTO proyectos (nombre_proyecto, nombre_equipo) VALUES (nombreProyecto, nombreEquipo);

    SET @last_id = LAST_INSERT_ID();

    SET @sql = CONCAT("INSERT INTO integrantes (id_proyecto, nombre_integrante) VALUES ");
    SET @sql_values = "";

    OPEN cur;

    get_integrantes:LOOP
        FETCH cur INTO integrante;
        IF done THEN
            LEAVE get_integrantes;
        END IF;
        SET @sql_values = CONCAT(@sql_values, "(", @last_id, ", '", integrante, "'), ");
    END LOOP;

    CLOSE cur;

    IF LENGTH(@sql_values) > 0 THEN
        SET @sql_values = LEFT(@sql_values, LENGTH(@sql_values) - 2); -- Eliminar la última coma y espacio
        SET @sql = CONCAT(@sql, @sql_values);
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;

    COMMIT;
END$$
DELIMITER ;
