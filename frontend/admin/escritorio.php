<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3)) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
    exit();
}

$rol = $_SESSION['rol'];

require_once('../../backend/bd/Conexion.php');
$req = $connect->prepare("SELECT id, title, start, end, color FROM events");
$req->execute();
$events = $req->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!--<link rel="stylesheet" href="../../backend/css/admin.css">-->
    <link rel="icon" type="image/png" sizes="96x96" href="../../backend/img/ico.svg">

    <!-- Data Tables -->
    <link rel="stylesheet" href="../../backend/vendor/datatables/dataTables.bs4.css" />
    <link rel="stylesheet" href="../../backend/vendor/datatables/dataTables.bs4-custom.css" />
    <link href="../../backend/vendor/datatables/buttons.bs.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <!-- FullCalendar -->
    <link href='../../backend/css/fullcalendar.css' rel='stylesheet' />
    <style type="text/css">
        #calendar {
            max-width: 800px;
        }

        .col-centered {
            float: none;
            margin: 0 auto;
        }
    </style>

    <title>Clínica Salud | Panel administrativo</title>
</head>

<body>

    <div class="d-flex">
        <aside id="sidebar" class="bg-light border-end  mb-3">

            <div class="p-3">
                <a href="escritorio.php" class="navbar-brand d-flex align-items-center mb-3">
                    <i class="bx bxs-heart me-2"></i> Clínica Salud
                </a>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="escritorio.php" class="nav-link active">
                            <i class="bx bxs-dashboard me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item text-uppercase fw-bold small text-muted mt-3">Main</li>
                    <!-- Citas -->
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#citasMenu" role="button" aria-expanded="false" aria-controls="citasMenu">
                            <i class="bx bxs-book-alt me-2"></i> Citas
                            <i class='bx bx-chevron-right icon-right'></i>
                        </a>
                        <ul class="collapse list-unstyled ms-3" id="citasMenu">
                            <li><a href="../citas/mostrar.php" class="nav-link">Todas las citas</a></li>
                            <li><a href="../citas/nuevo.php" class="nav-link">Nueva</a></li>
                            <li><a href="../citas/calendario.php" class="nav-link">Calendario</a></li>
                        </ul>
                    </li>
                    <!-- Pacientes -->
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#pacientesMenu" role="button" aria-expanded="false" aria-controls="pacientesMenu">
                            <i class="bx bxs-user me-2"></i> Pacientes
                            <i class='bx bx-chevron-right icon-right'></i>
                        </a>
                        <ul class="collapse list-unstyled ms-3" id="pacientesMenu">
                            <li><a href="../pacientes/mostrar.php" class="nav-link">Lista de pacientes</a></li>
                            <li><a href="../pacientes/pagos.php" class="nav-link">Pagos</a></li>
                            <li><a href="../pacientes/historial.php" class="nav-link">Historial de los pacientes</a></li>
                            <li><a href="../pacientes/documentos.php" class="nav-link">Documentos</a></li>
                        </ul>
                    </li>
                    <!-- Médicos -->
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#medicosMenu" role="button" aria-expanded="false" aria-controls="medicosMenu">
                            <i class="bx bxs-briefcase me-2"></i>
                            Médicos
                            <i class='bx bx-chevron-right icon-right'></i>
                        </a>
                        <ul class="collapse list-unstyled ms-3" id="medicosMenu">
                            <li><a href="../medicos/mostrar.php" class="nav-link">Lista de médicos</a></li>
                            <li><a href="../medicos/historial.php" class="nav-link">Historial de los médicos</a></li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#recursosHumanosMenu" role="button" aria-expanded="false" aria-controls="recursosHumanosMenu">
                            <i class="bx bxs-briefcase me-2"></i>
                            Recursos humanos
                            <i class='bx bx-chevron-right icon-right'></i>
                        </a>
                        <ul class="collapse list-unstyled ms-3" id="recursosHumanosMenu">
                            <li><a href="../recursos/enfermera.php" class="nav-link">Enfermera</a></li>
                            <li><a href="../recursos/laboratiorios.php" class="nav-link">Laboratorios</a></li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#actividadesMenu" role="button" aria-expanded="false" aria-controls="actividadesMenu">
                            <i class="bx bxs-briefcase me-2"></i>
                            Actividades financieras
                            <i class='bx bx-chevron-right icon-right'></i>
                        </a>
                        <ul class="collapse list-unstyled ms-3" id="actividadesMenu">
                            <li><a href="../actividades/mostrar.php" class="nav-link">Pagos</a></li>
                            <li><a href="../actividades/nuevo.php" class="nav-link">Nuevo pago</a></li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#medicinaMenu" role="button" aria-expanded="false" aria-controls="medicinaMenu">
                            <i class="bx bxs-briefcase me-2"></i> Medicina
                            <i class='bx bx-chevron-right icon-right'></i>
                        </a>
                        <ul class="collapse list-unstyled ms-3" id="medicinaMenu">
                            <li><a href="../medicinas/venta.php" class="nav-link">Vender</a></li>
                            <li><a href="../medicinas/mostrar.php" class="nav-link">Listado</a></li>
                            <li><a href="../medicinas/nuevo.php" class="nav-link">Nueva</a></li>
                            <li><a href="../medicinas/categoria.php" class="nav-link">Categoria</a></li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#ajustesMenu" role="button" aria-expanded="false" aria-controls="ajustesMenu">
                            <i class="bx bxs-briefcase me-2"></i> Ajustes
                            <i class='bx bx-chevron-right icon-right'></i>
                        </a>
                        <ul class="collapse list-unstyled ms-3" id="ajustesMenu">
                            <li><a href="../ajustes/mostrar.php" class="nav-link">Ajustes</a></li>
                            <li><a href="../ajustes/idioma.php" class="nav-link">Idioma</a></li>
                            <li><a href="../ajustes/base.php" class="nav-link">Base de datos</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="../acerca/mostrar.php" class="nav-link">
                            <i class="bx bxs-info-circle me-2"></i> Acerca de
                        </a>
                    </li>

                </ul>
            </div>
        </aside>
        <main id="main-content" class="container  mb-3">
            <header class=" mb-3">
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
                    <!-- Botón para colapsar el sidebar -->
                    <button class="btn btn-outline-primary me-3 d-lg-none toggle-sidebar">
                        <i class='bx bx-menu'></i>
                    </button>

                    <!-- Barra de búsqueda -->
                    <form class="d-flex flex-grow-1 me-auto">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class='bx bx-search'></i>
                            </button>
                        </div>
                    </form>

                    <!-- Divisor -->
                    <div class="d-none d-lg-block mx-3">
                        <span class="border-start ps-3"></span>
                    </div>

                    <!-- Perfil de usuario -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Profile" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline">Mi Perfil</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="../profile/mostrar.php"><i class='bx bxs-user-circle me-2'></i> Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../salir.php"><i class='bx bxs-log-out-circle me-2'></i> Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </header>


            <!-- Contenido principal -->
            <div class="card bg-light border-light rounded-4 mb-3">
                <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="escritorio.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="#" class="active">Dashboard</a>
                        </li>
                    </ol>
                </nav>

                <div class="row  mb-3">
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Pacientes
                                    <i class='bx bx-user icon'></i>
                                </h5>
                                <?php
                                $sql = "SELECT COUNT(*) total FROM patients";
                                $result = $connect->query($sql); //$pdo sería el objeto conexión
                                $total = $result->fetchColumn();
                                ?>
                                <h2><?php echo  $total; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Medicos
                                    <i class='bx bx-briefcase icon'></i>
                                </h5>
                                <?php
                                $sql = "SELECT COUNT(*) total FROM doctor";
                                $result = $connect->query($sql); //$pdo sería el objeto conexión
                                $total = $result->fetchColumn();

                                ?>
                                <h2><?php echo  $total; ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Usuarios
                                    <i class='bx bx-user-circle icon'></i>
                                </h5>
                                <?php
                                $sql = "SELECT COUNT(*) total FROM users";
                                $result = $connect->query($sql); //$pdo sería el objeto conexión
                                $total = $result->fetchColumn();
                                ?>
                                <h2><?php echo  $total; ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Citas

                                </h5>
                                <?php
                                $sql = "SELECT SUM(monto) total FROM events";
                                $result = $connect->query($sql); //$pdo sería el objeto conexión
                                $total = $result->fetchColumn();
                                ?>
                                <h2>MX/.<?php echo  $total; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row  mb-3">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card shadow">
                            <div class="card-body">

                                <?php
                                $sentencia = $connect->prepare("SELECT * FROM doctor ORDER BY idodc DESC LIMIT 10;");
                                $sentencia->execute();
                                $data =  array();
                                if ($sentencia) {
                                    while ($r = $sentencia->fetchObject()) {
                                        $data[] = $r;
                                    }
                                }
                                ?>
                                <?php if (count($data) > 0): ?>
                                    <table class="table table-striped table-hover table-bordered">

                                        <thead>
                                            <tr class="table-info">
                                                <th scope="col" class="">Nuevos médicos</th>
                                                <th scope="col" class="">Especialidad</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <?php foreach ($data as $d): ?>
                                                <tr>
                                                    <td data-title="Paciente"><?php echo $d->nodoc ?>&nbsp;<?php echo $d->apdoc ?></td>
                                                    <td data-title="Especialidad"><?php echo $d->nomesp ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>

                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                        <strong>Danger!</strong> No hay datos.
                                    </div>
                                <?php endif; ?>



                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="card shadow">
                            <div class="card-body">

                                <?php

                                $sentencia = $connect->prepare("SELECT * FROM patients ORDER BY idpa DESC LIMIT 10;");
                                $sentencia->execute();
                                $data =  array();
                                if ($sentencia) {
                                    while ($r = $sentencia->fetchObject()) {
                                        $data[] = $r;
                                    }
                                }
                                ?>
                                <?php if (count($data) > 0): ?>
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr class="table-info">
                                                <th scope="col" class="">Nuevos pacientes</th>

                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <?php foreach ($data as $d): ?>
                                                <tr>

                                                    <td data-title="Paciente"><?php echo $d->nompa ?>&nbsp;<?php echo $d->apepa ?></td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>

                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                        <strong>Danger!</strong> No hay datos.
                                    </div>
                                <?php endif; ?>



                            </div>
                        </div>



                    </div>
                </div>

                <div class="data  mb-3">
                    <div class="content-data">
                        <div class="head">
                            <h3>Calendario</h3>

                        </div>
                        <div id="calendar" class="col-centered">

                        </div>
                    </div>
                </div>
            </div>

        </main>

    </div>







    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <script src="../../backend/js/script.js"></script>

    <!-- Data Tables -->
    <script src="../../backend/vendor/datatables/dataTables.min.js"></script>
    <script src="../../backend/vendor/datatables/dataTables.bootstrap.min.js"></script>


    <!-- Custom Data tables -->
    <script src="../../backend/vendor/datatables/custom/custom-datatables.js"></script>
    <script src="../../backend/vendor/datatables/custom/fixedHeader.js"></script>


    <!-- FullCalendar -->
    <script src='../../backend/js/moment.min.js'></script>
    <script src='../../backend/js/fullcalendar/fullcalendar.min.js'></script>
    <script src='../../backend/js/fullcalendar/fullcalendar.js'></script>
    <script src='../../backend/js/fullcalendar/locale/es.js'></script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {

            var date = new Date();
            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
            var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

            $('#calendar').fullCalendar({
                header: {
                    language: 'es',
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay',

                },
                defaultDate: yyyy + "-" + mm + "-" + dd,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                select: function(start, end) {

                    $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd').modal('show');
                },
                eventRender: function(event, element) {
                    element.bind('dblclick', function() {
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #title').val(event.title);
                        $('#ModalEdit #color').val(event.color);
                        $('#ModalEdit').modal('show');
                    });
                },
                eventDrop: function(event, delta, revertFunc) { // si changement de position

                    edit(event);

                },
                eventResize: function(event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                    edit(event);

                },
                events: [
                    <?php foreach ($events as $event):

                        $start = explode(" ", $event['start']);
                        $end = explode(" ", $event['end']);
                        if ($start[1] == '00:00:00') {
                            $start = $start[0];
                        } else {
                            $start = $event['start'];
                        }
                        if ($end[1] == '00:00:00') {
                            $end = $end[0];
                        } else {
                            $end = $event['end'];
                        }
                    ?>, {
                            id: '<?php echo $event['id']; ?>',
                            title: '<?php echo $event['title']; ?>',
                            start: '<?php echo $start; ?>',
                            end: '<?php echo $end; ?>',
                            color: '<?php echo $event['color']; ?>',
                        },
                    <?php endforeach; ?>
                ]
            });

        });
    </script>
    <script>
        // Cambiar el ícono del menú desplegable
        document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]').forEach((toggle) => {
            toggle.addEventListener('click', function() {
                const icon = this.querySelector('.bx-chevron-down, .bx-chevron-right');
                if (icon) {
                    icon.classList.toggle('bx-chevron-down');
                    icon.classList.toggle('bx-chevron-right');
                }
            });
        });
    </script>
</body>

</html>