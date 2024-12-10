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
    <link rel="stylesheet" href="../../backend/css/admin.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../../backend/img/ico.svg">

    <!-- Data Tables -->
    <link rel="stylesheet" href="../../backend/vendor/datatables/dataTables.bs4.css" />
    <link rel="stylesheet" href="../../backend/vendor/datatables/dataTables.bs4-custom.css" />
    <link href="../../backend/vendor/datatables/buttons.bs.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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

<body class="container">

    <!-- SIDEBAR -->
    <section id="sidebar" class="bg-light border-end">

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
                        <i class="bx bx-chevron-down"></i>
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
                        <i class="bx bx-chevron-down"></i>
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
                        <i class="bx bx-chevron-down"></i>
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
                        <i class="bx bx-chevron-down"></i>
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
                        <i class="bx bx-chevron-down"></i>
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

        <ul class="side-menu">
            <li><a href="escritorio.php" class="active"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>
            <li class="divider" data-text="main">Main</li>
            <li>
                <a href="#"><i class='bx bxs-book-alt icon'></i> Citas <i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../citas/mostrar.php">Todas las citas</a></li>
                    <li><a href="../citas/nuevo.php">Nueva</a></li>
                    <li><a href="../citas/calendario.php">Calendario</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-user icon'></i> Pacientes <i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../pacientes/mostrar.php">Lista de pacientes</a></li>
                    <li><a href="../pacientes/pagos.php">Pagos</a></li>
                    <li><a href="../pacientes/historial.php">Historial de los pacientes</a></li>
                    <li><a href="../pacientes/documentos.php">Documentos</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-briefcase icon'></i> Médicos <i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/historial.php">Historial de los médicos</a></li>

                </ul>
            </li>


            <li>
                <a href="#"><i class='bx bxs-user-pin icon'></i> Recursos humanos<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../recursos/enfermera.php">Enfermera</a></li>
                    <li><a href="../recursos/laboratiorios.php">Laboratorios</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-diamond icon'></i> Actividades financieras<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../actividades/mostrar.php">Pagos</a></li>
                    <li><a href="../actividades/nuevo.php">Nuevo pago</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-spray-can icon'></i> Medicina<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicinas/venta.php">Vender</a></li>
                    <li><a href="../medicinas/mostrar.php">Listado</a></li>
                    <li><a href="../medicinas/nuevo.php">Nueva</a></li>
                    <li><a href="../medicinas/categoria.php">Categoria</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-cog icon'></i> Ajustes<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../ajustes/mostrar.php">Ajustes</a></li>
                    <li><a href="../ajustes/idioma.php">Idioma</a></li>
                    <li><a href="../ajustes/base.php">Base de datos</a></li>

                </ul>
            </li>

            <li><a href="../acerca/mostrar.php"><i class='bx bxs-info-circle icon'></i> Acerca de</a></li>


        </ul>


    </section>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu toggle-sidebar'></i>
            <form action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search icon'></i>
                </div>
            </form>


            <span class="divider"></span>
            <div class="profile">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
                <ul class="profile-link">
                    <li><a href="../profile/mostrar.php"><i class='bx bxs-user-circle icon'></i> Profile</a></li>

                    <li>
                        <a href="../salir.php"><i class='bx bxs-log-out-circle'></i> Logout</a>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
            <?php echo $rol ?>
            <ul class="breadcrumbs">
                <li><a href="escritorio.php">Home</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Dashboard</a></li>
            </ul>
            <div class="info-data">
                <div class="card">
                    <div class="head">
                        <div>

                            <?php
                            $sql = "SELECT COUNT(*) total FROM patients";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <h2><?php echo  $total; ?></h2>
                            <p>Pacientes</p>
                        </div>
                        <i class='bx bx-user icon'></i>
                    </div>

                </div>
                <div class="card">
                    <div class="head">
                        <div>

                            <?php
                            $sql = "SELECT COUNT(*) total FROM doctor";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <h2><?php echo  $total; ?></h2>
                            <p>Medicos</p>
                        </div>
                        <i class='bx bx-briefcase icon'></i>
                    </div>

                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <?php
                            $sql = "SELECT COUNT(*) total FROM users";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <h2><?php echo  $total; ?></h2>
                            <p>Usuarios</p>
                        </div>
                        <i class='bx bx-user-circle icon'></i>
                    </div>

                </div>
                <div class="card">
                    <div class="head">
                        <div>
                            <?php
                            $sql = "SELECT SUM(monto) total FROM events";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <h2>S/.<?php echo  $total; ?></h2>
                            <p>Citas</p>
                        </div>
                        <i class='bx bx-book-alt icon'></i>
                    </div>

                </div>
            </div>
            <div class="data">
                <div class="content-data">
                    <div class="table-responsive" style="overflow-x:auto;">
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
                            <table id="example" class="responsive-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nuevos médicos</th>

                                    </tr>
                                </thead>
                                <tbody>
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

                <div class="content-data">

                    <div class="table-responsive" style="overflow-x:auto;">
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
                            <table id="example" class="responsive-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nuevos pacientes</th>

                                    </tr>
                                </thead>
                                <tbody>
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

            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Calendario</h3>

                    </div>
                    <div id="calendar" class="col-centered">

                    </div>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- NAVBAR -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <!-- Incluir ApexCharts desde la CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
</body>

</html>