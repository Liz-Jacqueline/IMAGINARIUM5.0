<?php
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "", "imaginarium");

if ($conexion->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión: " . $conexion->connect_error]);
    exit;
}

// 🔍 GET: Obtener nombre del proyecto por ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conexion->prepare("SELECT nombre_proyecto FROM proyectos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        echo json_encode(['nombre_proyecto' => $fila['nombre_proyecto']]);
    } else {
        echo json_encode(['nombre_proyecto' => null]);
    }

    $stmt->close();
    $conexion->close();
    exit;
}

// 📝 POST: Guardar una reserva con validación de horario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_proyecto'])) {
    $id_proyecto = intval($_POST['id_proyecto']);
    $nombre_proyecto = $conexion->real_escape_string($_POST['nombre_proyecto']);
    $fecha = $_POST['fecha'] ?? '';
    $hora_inicio = $_POST['hora_inicio'] ?? '';
    $hora_fin = $_POST['hora_fin'] ?? '';

    // 🔍 Validar si ya hay una reserva en ese horario
    $stmt = $conexion->prepare(
        "SELECT COUNT(*) FROM agenda 
         WHERE fecha = ? AND (hora_inicio < ? AND hora_fin > ?)"
    );
    $stmt->bind_param("sss", $fecha, $hora_fin, $hora_inicio);
    $stmt->execute();
    $stmt->bind_result($existe);
    $stmt->fetch();
    $stmt->close();

    if ($existe > 0) {
        echo json_encode(["success" => false, "error" => "Ese horario ya está ocupado"]);
        $conexion->close();
        exit;
    }

    // ✅ Insertar nueva reserva
    $stmt = $conexion->prepare(
        "INSERT INTO agenda (id_proyecto, nombre_proyecto, fecha, hora_inicio, hora_fin)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("issss", $id_proyecto, $nombre_proyecto, $fecha, $hora_inicio, $hora_fin);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
    exit;
}

// 📋 GET: Listar reservas
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['listar'])) {
    $resultado = $conexion->query(
        "SELECT nombre_proyecto, fecha, hora_inicio, hora_fin FROM agenda ORDER BY fecha ASC"
    );

    $reservas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $reservas[] = $fila;
    }

    echo json_encode($reservas);
    $conexion->close();
    exit;
}

// ❌ Si no coincide ninguna ruta
http_response_code(400);
echo json_encode(["error" => "Solicitud no válida"]);
$conexion->close();
?>
