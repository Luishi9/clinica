<?php
include_once '../backend/php/login.php'
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clínica | Salud</title>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../backend/css/style.css" />
  <link rel="icon" type="image/png" sizes="96x96" href="../backend/img/ico.svg">

  

</head>

<body>
  <div class="form-container">
    <h1 class="heading">
      Clínica
      <br>
      Salud
    </h1>
    <?php
    if (isset($errMsg)) {
      echo '<div style="color:#FF0000;text-align:center;font-size:20px; font-weight:bold;">' . $errMsg . '</div>';
    }

    ?>
    <form action="" method="POST" autocomplete="off">
      <input
        type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off"
        class="form-input span-2"
        placeholder="Nombre de usuario " />
      <input type="password" required="true" name="password" value="<?php if (isset($_POST['password'])) echo MD5($_POST['password']) ?>" class="form-input span-2" placeholder="Contraseña" />

      <button class="btn btn-primary submit-btn span-2" name='login' type="submit">Iniciar sesión</button>
    </form>
    <p class="btm-line">
      By joining, you agree to our Terms of Service and Privacy Policy
    </p>
  </div>
</body>

</html>