<?php
session_start();
$Nombre = $_SESSION['NombreUser'];
if (!isset($_SESSION['NombreUser'])) {
    header("Location: ../index.php");
    exit();
}
require '../src/server/conecta.php';
// Obtiene el ID que se envia desde el icono de "user"
if (isset($_GET['id'])) {
  $id_usuario = $_GET['id'];
} else {
  echo "ID de usuario no proporcionado.";
  exit();
}
$con = conecta();

//<<----------------------------------------------- Verifica si el ID pertenece a un estudiante
$sql_estudiante = "SELECT * FROM estudiante WHERE id_usuario = $1";
$result_estudiante = pg_prepare($con, "query_select_estudiante", $sql_estudiante);
$res_estudiante = pg_execute($con, "query_select_estudiante", array($id_usuario));

if ($res_estudiante && pg_num_rows($res_estudiante) > 0) {
    $row = pg_fetch_assoc($res_estudiante);
    // <<----- Se obtienen los datos de la tabla estudiante
    $id_estudiante  = $row["id_estudiante"];
    $nombre         = $row["nombres"];
    $apellidos      = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
    $carrera        = $row["carrera"];
    $telefono       = $row["num_tel"];
    $correo         = $row["correo"];
    $codigo         = $row["codigo_escolar"];
    $foto           = $row["foto"];
} else {
    //<<----------------------------------------------- Verifica si el ID pertenece a un asesor
    $sql_asesor = "SELECT * FROM asesor WHERE id_usuario = $1";
    $result_asesor = pg_prepare($con, "query_select_asesor", $sql_asesor);
    $res_asesor = pg_execute($con, "query_select_asesor", array($id_usuario));

    if ($res_asesor && pg_num_rows($res_asesor) > 0) {
        $row = pg_fetch_assoc($res_asesor);
        // <<----- Se obtienen los datos de la tabla asesor
        $nombre       = $row["nombres"];
        $apellidos    = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
        $departamento = $row["departamento"];
        $telefono     = $row["num_tel"];
        $correo       = $row["correo"];
        $codigo       = $row["codigo_escolar"];
        $foto         = $row["foto"];
    } else {
        echo "No se encontró ningún estudiante o asesor con el ID: $id_usuario";
        exit();
    }
}

// <<<------------------------------------------------------------------- Consulta para obtener proyectos asociados al usuario (estudiante o asesor)
$sql_proyectos = "
    SELECT p.* 
    FROM proyecto p
    JOIN integrante i ON p.id = i.id_proyecto
    WHERE i.id_estudiante = $1
";

$result_proyectos = pg_prepare($con, "query_select_proyectos", $sql_proyectos);
$res_proyectos = pg_execute($con, "query_select_proyectos", array($id_estudiante));

if ($res_proyectos && pg_num_rows($res_proyectos) > 0) {
    while ($row = pg_fetch_assoc($res_proyectos)) {
      // <<----- Se obtienen los datos de la tabla proyecto
        $id_proyecto          = $row["id"];
        $nombre_proyecto      = $row["nombre"];
        $descripcion_proyecto = $row["descripcion"];
        $area_preoyecto       = $row["area"];
        $status               = $row["activo"];
        $conoc_req            = $row["conocimientos_requeridos"];
        $niv_innova           = $row["nivel_de_innovacion"];
        $logo                 = $row["logo"];
    }
} else {
    echo "No se encontraron proyectos asociados al usuario.";
}

// Consulta para obtener integrantes del proyecto
$sql_integrantes = "
    SELECT i.*, u.nombres, u.apellido_pat, u.apellido_mat 
    FROM integrante i
    JOIN usuario u ON i.id_estudiante = u.id_usuario
    WHERE i.id_proyecto = $1
";

$result_integrantes = pg_prepare($con, "query_select_integrantes", $sql_integrantes);
$res_integrantes = pg_execute($con, "query_select_integrantes", array($id_proyecto));

if ($res_integrantes && pg_num_rows($res_integrantes) > 0) {
    while ($row = pg_fetch_assoc($res_integrantes)) {
        // Aquí puedes obtener los datos del integrante
        $nombre_integrante = $row["nombres"];
        $apellidos_integrante = $row["apellido_pat"] . ' ' . $row["apellido_mat"];
        // ... otros campos
    }
} else {
    echo "No se encontraron integrantes para el proyecto.";
}

// Cerrar la conexión con la BD
pg_close($con);
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mi perfil de Link-Proyect</title>
    <link rel="stylesheet" href="../assets/styles/normalize.css" />
    <link rel="stylesheet" href="../assets/styles/style.css" />
    <link rel="stylesheet" href="../assets/styles/inicio.css" />
    <link rel="stylesheet" href="../assets/styles/perfil_usuario.css" />
  </head>
  <body>
    <!-- ------------------------------------ Encabezado de pagina Inicial -->
    <header>
      <h1>Link-Project</h1>
    </header>
    <!-- <div class="button-container">
      <a href="crear_proyecto.php" class="btn">Crear Proyecto</a>
    </div>

    <div class="navigation-bar">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
      <a href="perfil_usuario.php?id=<?php echo $_SESSION['IDUser']; ?>" class="user">
        <i  class="ti ti-user-circle" ></i>
      </a> -->
      
    </div>
      <!-- ------------------------------------------------------------------------- Contenido de la pagina -->
      <div class="Contenido">
        <div class="contenedor">
          <div class="Header">
            <div class="avatar"><?php echo $foto; ?></div>
              <h1><?php echo $nombre . ' ' . $apellidos; ?></h1>
            </div>
                
            <div class="contact-info">
                    
              <p> <?php echo $id_estudiante; ?> </p>
              <p> <?php echo $telefono; ?> </p>
              <p> <?php echo $correo; ?> </p>
              <p> <?php echo $codigo; ?> </p>
              <p> <?php echo $carrera; ?></p>  
            </div>
            <div class="section-title">Habilidades</div>  
            
            <p> --------------------------------------------</p>  
            
            
            
            <div class="section-title">Proyecto</div>
            <div class="pr-item">
              <!------------------------------------------- Logica para saber si esta en proyecto o no -------------------- <img src="'icono_pr.png'" alt="Pr Icon">-->
              <p class="section-title" > Nombre del proyecto: </p>
              <p> <?php echo $nombre_proyecto; ?></p> 
              <p> --------------------------------------------</p>  
              <p class="section-title" > Descripcion: </p> 
              <p> <?php echo $descripcion_proyecto; ?></p> 
              <p> --------------------------------------------</p> 
              <p class="section-title" > Area del proyecto: </p> 
              <p> <?php echo $area_preoyecto; ?></p> 
              <p> --------------------------------------------</p>
              <p class="section-title" > Status del proyecto: </p> 
              <p> <?php echo $status; ?></p> 
              <p> --------------------------------------------</p>
              <p class="section-title" > Conocimientos requeridos: </p> 
              <p> <?php echo $conoc_req; ?></p> 
              <p> --------------------------------------------</p>
              <p class="section-title" > Nivel de innovacion: </p> 
              <p> <?php echo $niv_innova; ?></p> 
              <p> --------------------------------------------</p>
              <p class="section-title" > Integrantes: </p> 
              <p> <?php echo $nombre_integrante . ' ' . $apellidos_integrante; ?></p> 
              <p> --------------------------------------------</p>

                
              <div>
                
              </div>
            </div>
                
            </div>
        </div>
    </div>
  </body>
</html>
