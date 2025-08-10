<?php
$conexion = new mysqli("localhost", "root", "", "imaginarium");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Escapar y capturar datos del formulario
function limpiar($conexion, $campo) {
    return isset($_POST[$campo]) ? $conexion->real_escape_string($_POST[$campo]) : null;
}

$nombre_proyecto = limpiar($conexion, 'nombre_proyecto');
$total_estudiantes = limpiar($conexion, 'total_estudiantes');
$mujeres_estudiantes = limpiar($conexion, 'mujeres_estudiantes');
$hombres_estudiantes = limpiar($conexion, 'hombres_estudiantes');
$otro_genero_estudiantes = limpiar($conexion, 'otro_genero_estudiantes');
$nombres_estudiantes = limpiar($conexion, 'nombres_estudiantes');

$total_profesores = limpiar($conexion, 'total_profesores');
$mujeres_profesores = limpiar($conexion, 'mujeres_profesores');
$hombres_profesores = limpiar($conexion, 'hombres_profesores');
$otro_genero_profesores = limpiar($conexion, 'otro_genero_profesores');
$nombres_profesores = limpiar($conexion, 'nombres_profesores');

$objetivo_proyecto = limpiar($conexion, 'objetivo_proyecto');

// Criterios SEAES (checkboxes: si están marcados, valen 1)
$responsabilidad_social = isset($_POST['responsabilidad_social']) ? 1 : 0;
$equidad_social_genero = isset($_POST['equidad_social_genero']) ? 1 : 0;
$inclusion = isset($_POST['inclusion']) ? 1 : 0;
$excelencia = isset($_POST['excelencia']) ? 1 : 0;
$innovacion_social = isset($_POST['innovacion_social']) ? 1 : 0;
$vanguardia = isset($_POST['vanguardia']) ? 1 : 0;
$interculturalidad = isset($_POST['interculturalidad']) ? 1 : 0;

// Acumulado de criterios SEAES
$acumulado_rs = limpiar($conexion, 'acumulado_rs');
$acumulado_eg = limpiar($conexion, 'acumulado_eg');
$acumulado_inc = limpiar($conexion, 'acumulado_inc');
$acumulado_exc = limpiar($conexion, 'acumulado_exc');
$acumulado_ino = limpiar($conexion, 'acumulado_ino');
$acumulado_vang = limpiar($conexion, 'acumulado_vang');
$acumulado_inter = limpiar($conexion, 'acumulado_inter');

$sector_beneficiado = limpiar($conexion, 'sector_beneficiado');
$nombre_empresa_institucion = limpiar($conexion, 'nombre_empresa_institucion');
$origen_desarrollo_proyecto = limpiar($conexion, 'origen_desarrollo_proyecto');
$asignaturas_pe = limpiar($conexion, 'asignaturas_pe');
$fecha_inicio_proyecto = limpiar($conexion, 'fecha_inicio_proyecto');
$estado_proyecto = limpiar($conexion, 'estado_proyecto');
$url_evidencia_proyecto = limpiar($conexion, 'url_evidencia_proyecto');
$producto_generado = limpiar($conexion, 'producto_generado');
$fecha_fin_proyecto = limpiar($conexion, 'fecha_fin_proyecto');

// Consulta SQL
$sql = "INSERT INTO proyectos (
    nombre_proyecto, objetivo_proyecto,
    total_estudiantes, mujeres_estudiantes, hombres_estudiantes, otro_genero_estudiantes, nombres_estudiantes,
    total_profesores, mujeres_profesores, hombres_profesores, otro_genero_profesores, nombres_profesores,
    responsabilidad_social, equidad_social_genero, inclusion, excelencia, innovacion_social,
    vanguardia, interculturalidad,
    acumulado_rs, acumulado_eg, acumulado_inc, acumulado_exc, acumulado_ino, acumulado_vang, acumulado_inter,
    sector_beneficiado, nombre_empresa_institucion, origen_desarrollo_proyecto,
    asignaturas_pe, fecha_inicio_proyecto, fecha_fin_proyecto, estado_proyecto,
    url_evidencia_proyecto, producto_generado
) VALUES (
    '$nombre_proyecto', '$objetivo_proyecto',
    '$total_estudiantes', '$mujeres_estudiantes', '$hombres_estudiantes', '$otro_genero_estudiantes', '$nombres_estudiantes',
    '$total_profesores', '$mujeres_profesores', '$hombres_profesores', '$otro_genero_profesores', '$nombres_profesores',
    '$responsabilidad_social', '$equidad_social_genero', '$inclusion', '$excelencia', '$innovacion_social',
    '$vanguardia', '$interculturalidad',
    '$acumulado_rs', '$acumulado_eg', '$acumulado_inc', '$acumulado_exc', '$acumulado_ino', '$acumulado_vang', '$acumulado_inter',
    '$sector_beneficiado', '$nombre_empresa_institucion', '$origen_desarrollo_proyecto',
    '$asignaturas_pe', '$fecha_inicio_proyecto', '$fecha_fin_proyecto', '$estado_proyecto',
    '$url_evidencia_proyecto', '$producto_generado'
)";
if ($conexion->query($sql) === TRUE) {
    $id = $conexion->insert_id;
    header("Location: registro.html?status=success&id=$id");
} else {
    $error = urlencode($conexion->error);
    header("Location: registro.html?status=error&msg=$error");
}
exit();
?>
