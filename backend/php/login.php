<?php
require '../backend/bd/Conexion.php';

if (isset($_POST['login'])) {
  $errMsg = '';

  // Obtener datos del formulario
  $username = trim($_POST['username']);
  $password = md5(trim($_POST['password'])); // MD5 no es seguro, considera usar password_hash()

  // Validar campos vac���os
  if ($username == '') {
    $errMsg = 'Digite su usuario.';
  }
  if ($password == '') {
    $errMsg = 'Digite su contrase���a.';
  }

  if ($errMsg == '') {
    try {
      $stmt = $connect->prepare('SELECT id, username, name, email, password, rol FROM users WHERE username = :username');
      $stmt->execute([':username' => $username]);
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {

        // Si no se encuentra en 'users', buscar en la tabla 'doctor'
        $stmt = $connect->prepare('SELECT idodc AS id, username, nodoc AS name, corr AS email, password, rol FROM doctor WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
          $errMsg = "El usuario $username no se encuentra, puede solicitarlo con el administrador.";
        } else {
          // Validar contraseña para 'doctor'
          if ($password == $data['password']) {
            // Configurar variables de sesión
            $_SESSION['id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['name'] = $data['name'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['rol'] = $data['rol'];

            // Redirigir al escritorio de médico
            header('Location: ../frontend/medico/escritorio.php');
            exit;
          } else {
            $errMsg = 'Contraseña incorrecta.';
          }
        }
      } else {
        //validar contrase;a para user
        if ($password == $data['password']) { // Verifica la contrase���a
          // Configurar variables de sesi���n
          $_SESSION['id'] = $data['id'];
          $_SESSION['username'] = $data['username'];
          $_SESSION['name'] = $data['name'];
          $_SESSION['email'] = $data['email'];
          $_SESSION['rol'] = $data['rol'];

          // Redirigir seg���n el rol del usuario
          if ($_SESSION['rol'] == 1) {
            header('Location: ../frontend/admin/escritorio.php');
          } else if ($_SESSION['rol'] == 3) {
            header('Location: ../frontend/medico/medico_escritorio.php');
          }
          exit;
        } else {
          $errMsg = 'Contraseña incorrecta.';
        }
      }
    } catch (PDOException $e) {
      $errMsg = 'Error en la base de datos: ' . $e->getMessage();
    }
  }

  // Mostrar error (si existe)
  if ($errMsg) {
    echo "<p style='color:red;'>$errMsg</p>";
  }
}
