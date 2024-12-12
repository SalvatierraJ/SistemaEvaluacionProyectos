CREATE VIEW equipos AS
SELECT
    `p`.`id` AS `id_proyecto`,
    `p`.`nombre_proyecto` AS `proyecto`,
    `p`.`nombre_grupo` AS `grupo`,
    `p`.`carrera` AS `carrera`,
    GROUP_CONCAT(`i`.`nombre_integrante` SEPARATOR ',') AS `integrantes`
FROM
    `proyectos` `p`
JOIN
    `integrantes` `i` ON `p`.`id` = `i`.`id_proyecto`
GROUP BY
    `p`.`id`;


CREATE VIEW vista_evaluaciones_proyectos AS
SELECT
    `e`.`id_jurado` AS `id_jurado`,
    `u`.`nombre_completo` AS `nombre_jurado`,
    `e`.`id_proyecto` AS `id_proyecto`,
    `e`.`propuesta_academica` AS `propuesta_academica`,
    `e`.`pertinencia_propuesta` AS `pertinencia_propuesta`,
    `e`.`grado_innovacion` AS `grado_innovacion`,
    `e`.`calidad_prototipado` AS `calidad_prototipado`,
    `e`.`impacto_social` AS `impacto_social`,
    `e`.`sostenibilidad_propuesta` AS `sostenibilidad_propuesta`,
    `e`.`propuesta_academica` + `e`.`pertinencia_propuesta` + `e`.`grado_innovacion` + `e`.`calidad_prototipado` + `e`.`impacto_social` + `e`.`sostenibilidad_propuesta` AS `total_evaluacion`,
    `p`.`total_promedio` AS `total_promedio`
FROM
    (
        `evaluacionproyectos`.`evaluaciones` `e`
        JOIN `evaluacionproyectos`.`usuarios` `u` ON `e`.`id_jurado` = `u`.`id`
    )
    JOIN `evaluacionproyectos`.`vista_promedio_evaluacion` `p` ON `e`.`id_proyecto` = `p`.`id_proyecto`
ORDER BY
    `p`.`total_promedio` DESC;


CREATE VIEW vista_jurados AS
SELECT
    `evaluacionproyectos`.`usuarios`.`id` AS `id`,
    `evaluacionproyectos`.`usuarios`.`nombre_completo` AS `nombre_completo`,
    `evaluacionproyectos`.`usuarios`.`usuario` AS `usuario`,
    `evaluacionproyectos`.`usuarios`.`contrasena` AS `contrasena`,
    `evaluacionproyectos`.`usuarios`.`rol` AS `rol`,
    `evaluacionproyectos`.`usuarios`.`estado` AS `estado`
FROM
    `evaluacionproyectos`.`usuarios`
WHERE
    `evaluacionproyectos`.`usuarios`.`rol` = 'jurado';


CREATE VIEW vista_promedio_evaluacion AS
SELECT
    `evaluacionproyectos`.`evaluaciones`.`id_proyecto` AS `id_proyecto`,
    AVG(`evaluacionproyectos`.`evaluaciones`.`propuesta_academica` + `evaluacionproyectos`.`evaluaciones`.`pertinencia_propuesta` + `evaluacionproyectos`.`evaluaciones`.`grado_innovacion` + `evaluacionproyectos`.`evaluaciones`.`calidad_prototipado` + `evaluacionproyectos`.`evaluaciones`.`impacto_social` + `evaluacionproyectos`.`evaluaciones`.`sostenibilidad_propuesta`) AS `total_promedio`
FROM
    `evaluacionproyectos`.`evaluaciones`
GROUP BY
    `evaluacionproyectos`.`evaluaciones`.`id_proyecto`;
