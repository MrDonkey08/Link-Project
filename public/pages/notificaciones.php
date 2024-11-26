<?php
// Suponiendo que ya tienes la conexión a la base de datos y la sesión iniciada
require '../src/server/conecta.php';
session_start();

$con = conecta();
$id_usuario = $_SESSION['IDUser'];

// Obtener las notificaciones para este usuario
$query_notificaciones = "
SELECT 
    s.id_proyecto,
    s.id_solicitante,
    s.estado,
    p.nombre AS nombre_proyecto,
    u.nombres AS nombre_solicitante
FROM solicitudes s
JOIN proyecto p ON p.id = s.id_proyecto
JOIN usuario u ON u.id_usuario = s.id_solicitante
WHERE s.id_lider = $1 AND s.estado = 'pendiente'
";

$result_notificaciones = pg_query_params($con, $query_notificaciones, [$id_usuario]);

$notificaciones = [];
if ($result_notificaciones) {
    while ($row = pg_fetch_assoc($result_notificaciones)) {
        $notificaciones[] = $row;
    }
} else {
    echo "Error al obtener las notificaciones.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="../assets/styles/notificaciones.css">
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
</head>
<body>
    <header>
        <h1>Notificaciones</h1>
        <p>Solicitudes de proyectos</p>
    </header>

    <div class="notifications-container">
        <?php if (!empty($notificaciones)): ?>
            <?php foreach ($notificaciones as $notificacion): ?>
                <div class="notification-card">
                    <h3><?php echo htmlspecialchars($notificacion['nombre_solicitante']); ?> ha enviado una solicitud para el proyecto "<?php echo htmlspecialchars($notificacion['nombre_proyecto']); ?>"</h3>
                    <div class="actions">
                        <form action="../src/server/procesar_solicitud.php" method="POST">
                            <input type="hidden" name="id_proyecto" value="<?php echo $notificacion['id_proyecto']; ?>">
                            <input type="hidden" name="id_solicitante" value="<?php echo $notificacion['id_solicitante']; ?>">
                            <button type="submit" name="accion" value="aceptar" class="accept-btn">Aceptar</button>
                            <button type="submit" name="accion" value="rechazar" class="reject-btn">Rechazar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes solicitudes pendientes.</p>
        <?php endif; ?>
    </div>

</body>
</html>
