<?php
session_start();

//Verificar si hay un mensaje de error en la sesion
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);


// Si el usuario ya está logueado, redirigir al panel
if (isset($_SESSION['user'])) {
    header('Location: ../views/panel.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="shortcut icon" href="https://img.icons8.com/fluency-systems-filled/96/646ee4/dashboard-layout.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/9705d6f157.js" crossorigin="anonymous"></script>
    <script src="../public/js/switchMode.js"></script>


</head>

<body class="bg-base-300">
    <main class="flex items-center justify-center min-h-screen">
        <div class="card w-full max-w-md bg-base-100 shadow-md p-6 m-5">

            <!-- Mostrar mensaje de error si existe -->
            <?php if (!empty($error_message)) :  ?>
                <div id="mensajeError" role="alert" class="alert alert-error mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>
                        <?php echo $error_message; ?>
                    </span>
                </div>
            <?php endif; ?>

            <form id="login-form" novalidate action="../controllers/miniController/loginMiniC.php" method="POST">

                <div class="flex justify-center mb-4">
                    <img class="mb-4" src="../public/img/logofimazlight.png" alt="" width="152" height="152">
                </div>

                <h1 class="text-3xl font-semibold text-center mb-6">Iniciar Sesión</h1>

                <div class="form-control">
                    <label for="username" class="label flex items-center space-x-2" style="display: flex; align-items: center; justify-content: start;">
                        <i class="fa-solid fa-user fa-xs"></i>
                        <span class="label-text">Nombre de usuario</span>
                    </label>
                    <input type="text" id="username" placeholder="--------" class="input input-bordered w-full" name="username" required maxlength="20">

                    <label class="label hidden" id="username-error">
                        <span class="label-text-alt text-error">Por favor, ingrese un nombre de usuario válido.</span>
                    </label>
                </div>

                <div class="form-control mt-4">
                    <label for="password" class="label flex items-center space-x-2" style="display: flex; align-items: center; justify-content: start;">
                        <i class="fa-solid fa-key fa-xs"></i>
                        <span class="label-text">Contraseña</span>
                    </label>
                    <input type="password" id="password" placeholder="--------" class="input input-bordered w-full" name="password" required minlength="6">
                    <label class="label hidden" id="password-error">
                        <span class="label-text-alt text-error">La contraseña es incorrecta.</span>
                    </label>
                </div>

                <button class="btn btn-block btn-active mt-6" type="submit">
                    <i class="fa-solid fa-right-to-bracket fa-xs"></i>
                    Iniciar Sesión
                </button>

            </form>
            <!-- <div class="mt-6 text-center">
                <p>¿Eres nuevo administrador? <a href="signup.php" class="link link-active">Regístrate</a></p>
            </div> -->
            <p class="mt-5 text-center text-sm text-gray-500">&copy; Alumno FIMAZ 2024</p>

            <!-- MODOS DARK / LIGHT -->
            <label class="swap swap-rotate mt-5">
                <!-- this hidden checkbox controls the state -->
                <input type="checkbox" class="theme-controller" />

                <!-- moon icon -->
                <svg class="swap-off h-10 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                </svg>

                <!-- sun icon -->
                <svg class="swap-on h-10 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                </svg>
            </label>

        </div>
    </main>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            let valid = true;

            // Username validation
            const username = document.getElementById('username');
            const usernameError = document.getElementById('username-error');
            if (!username.value.match(/^[a-zA-Z0-9_-]{3,16}$/)) {
                username.classList.add('input-error');
                usernameError.classList.remove('hidden');
                valid = false;
            } else {
                username.classList.remove('input-error');
                usernameError.classList.add('hidden');
            }

            // Password validation
            const password = document.getElementById('password');
            const passwordError = document.getElementById('password-error');
            if (!password.validity.valid) {
                password.classList.add('input-error');
                passwordError.classList.remove('hidden');
                valid = false;
            } else {
                password.classList.remove('input-error');
                passwordError.classList.add('hidden');
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
</body>

</html>