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
  <!-- Custom CSS 
  <link rel="stylesheet" href="../backend/css/style.css" />-->
  <link rel="icon" type="image/png" sizes="96x96" href="../backend/img/ico.svg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


</head>

<body>
  <!-- Login 13 - Bootstrap Brain Component -->
  <section class="bg-light py-3 py-md-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
          <div class="card border border-light-subtle rounded-3 shadow-sm">
            <div class="card-body p-3 p-md-4 p-xl-5">
              <div class="text-center mb-3">
                <a href="#!">
                  <img src="./assets/img/bsb-logo.svg" alt="BootstrapBrain Logo" width="175" height="57">
                </a>
              </div>
              <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Inicia sesión con tu cuenta</h2>
              <?php
              if (isset($errMsg)) {
                echo '<div style="color:#FF0000;text-align:center;font-size:20px; font-weight:bold;">' . $errMsg . '</div>';
              }

              ?>
              <form action="" method="POST" autocomplete="off">
                <div class="row gy-2 overflow-hidden">
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input
                        type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off"
                        class="form-control"
                        placeholder="Nombre de usuario " />
                      <label for="email" class="form-label">Usuario</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" required="true" name="password" value="<?php if (isset($_POST['password'])) echo MD5($_POST['password']) ?>" class="form-control" placeholder="Contraseña" />
                      <label for="password" class="form-label">Contraseña</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="d-grid my-3">
                      <button class="btn btn-primary btn-lg" type="submit" name='login'>Iniciar sesión</button>
                    </div>
                  </div>
                  <div class="col-12">
                    <p class="m-0 text-secondary text-center">Al unirte, aceptas nuestros Términos de servicio y Política de privacidad.</p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ⬇️⬇️⬇️ Versión antigua ⬇️⬇️⬇️ -->
  <!--
  <div class="container">
    <h1 class="heading">
      Clínica
      <br>
      Salud
    </h1>

    <form action="" method="POST" autocomplete="off">
      <input
        type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off"
        class="form-control"
        placeholder="Nombre de usuario " />
      <input type="password" required="true" name="password" value="<?php if (isset($_POST['password'])) echo MD5($_POST['password']) ?>" class="form-control" placeholder="Contraseña" />

      <button class="btn btn-primary submit-btn span-2" name='login' type="submit">Iniciar sesión</button>
    </form>
    <p class="btm-line">
      By joining, you agree to our Terms of Service and Privacy Policy
    </p>
  </div>
  -->


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>