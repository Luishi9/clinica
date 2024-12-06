<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3)) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../backend/css/admin.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../../backend/img/ico.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Clínica Salud | Nuevo médico</title>

    <style>
        /* Estilos del Popup */
        main{
            background: #F1F0F6;
            border-radius: 8px;
        }
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 300px;
        }

        .popup img {
            width: 50px;
            height: 50px;
        }

        .popup .closebtn {
            font-size: 20px;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        /* Para hacer que el popup se vea */
        .popup.show {
            display: flex;
        }

        
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <section id="sidebar">

        <a href="../admin/escritorio.php" class="brand"><i class='bx bxs-heart icon'></i> Clínica Salud</a>
        <ul class="side-menu">
            <li><a href="../admin/escritorio.php"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>
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
                <a href="#" class="active"><i class='bx bxs-briefcase icon'></i> Médicos <i class='bx bx-chevron-right icon-right'></i></a>
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

    <!-- CONTENIDO -->
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
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../medicos/mostrar.php">Listado de los médicos</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nuevo médico</a></li>
            </ul>

            <!-- multistep form -->


            <form action="" enctype="multipart/form-data" method="POST" autocomplete="off" onsubmit="return validacion()">
                <div class="containerss">
                    <h1>Nuevo médico</h1>
                    <?php include_once '../../backend/php/add_doctor.php' ?>

                    <!-- Aquí se controlará si se muestra el popup de éxito o error -->
                    <?php if (isset($errMSG)) { ?>
                        <div id="popup" class="popup">
                            <div class="popup-content">
                                <span class="closebtn" onclick="closePopup()">&times;</span>
                                <img src="<?php echo (isset($showPopup) && $showPopup) ? '../../backend/img/error.png' : '../../backend/img/404-tick.png'; ?>" />
                                <p><?php echo $errMSG; ?></p>
                                <button type="button" class="btn btn-info" id="acceptCookie"  onclick="closePopup()">OK</button>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="alert-danger">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>Importante!</strong> Es importante rellenar los campos con &nbsp;<span class="badge-warning">*</span>
                    </div>
                    <hr>

                    <label for="email"><b>Cédula del médico</b></label><span class="badge-warning">*</span>
                    <input class="form-control" type="text" placeholder="ejm: 09741478" name="cem" maxlength="8" required>

                    <label for="psw"><b>Nombre del médico</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: Juan Raul" name="named" required>

                    <label for="psw"><b>Apellido del médico</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: Ramirez Requena" name="apeme" required>

                    <label for="psw"><b>Dirección del médico</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: calle los medanos" name="dime" required>

                    <label for="psw"><b>Género del médico</b></label><span class="badge-warning">*</span>
                    <select required name="geme" id="gep">
                        <option>Seleccione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>

                    <label for="psw"><b>Especialidad del médico</b></label><span class="badge-warning">*</span>
                    <select required name="espm" id="espm">
                        <option>Seleccione</option>
                        <option value="Pediatría">Pediatría</option>
                        <option value="Rehabilitación">Rehabilitación</option>
                        <option value="Endocrinología">Endocrinología</option>
                        <option value="Cardiología">Cardiología</option>
                        <option value="Dermatología">Dermatología</option>
                        <option value="Gastroenterología">Gastroenterología</option>
                        <option value="Psiquiatría">Psiquiatría</option>
                        <option value="Neurología">Neurología</option>
                        <option value="Neumología">Neumología</option>
                        <option value="Reumatología">Reumatología</option>
                        <option value="Hematología">Hematología</option>
                        <option value="Oncología">Oncología</option>
                    </select>


                    <label for="psw"><b>Teléfono del médico</b></label><span class="badge-warning">*</span>
                    <input type="text" maxlength="13" placeholder="ejm: +51 999 888 111" name="telme" required>

                    <label for="psw"><b>Fecha de nacimiento del médico</b></label><span class="badge-warning">*</span>
                    <input type="date" name="cumme" required>

                    <hr>

                    <button type="submit" name="add_doctor" class="registerbtn">Guardar</button>
                </div>

            </form>


        </main>
        <!-- MAIN -->
    </section>
    <script src="../../backend/js/jquery.min.js"></script>


    <!-- NAVBAR -->

    <!-- <script src="../../backend/js/script.js"></script> -->
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/valNuevoDoc.js"></script>


    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            const popup = document.getElementById("popup");
            if (popup) {
                popup.classList.add("show");
            } else {
                console.error("Elemento 'popup' no encontrado en el DOM.");
            }


        });

        function closePopup() {
            const popup = document.getElementById("popup");
            if (popup) {
                popup.classList.remove("show");
            }
        }
    </script>

</body>

</html>