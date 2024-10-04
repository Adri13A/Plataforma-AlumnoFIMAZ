<?php
session_start();

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
    <title>Regístrate como Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="https://img.icons8.com/fluency-systems-filled/96/646ee4/dashboard-layout.png" type="image/x-icon">
    <script src="../public/js/switchMode.js"></script>
    <script src="https://kit.fontawesome.com/9705d6f157.js" crossorigin="anonymous"></script>

</head>

<body class="bg-base-300">
    <main class="flex items-center justify-center min-h-screen">
        <div class="card w-full max-w-md bg-base-100 shadow-md p-6 m-5">
            <a href="login.php">
                <button type="submit" class="btn btn-sm"><i class="fa-solid fa-arrow-left"></i></button>
            </a>
            <div class="flex justify-center mb-4">
                <img class="mb-4" src="../public/img/logofimazlight.png" alt="" width="152" height="152">
            </div>
            <form id="sign-up-form" novalidate action="../controllers/miniController/signupMiniC.php" method="POST">

                <h1 class="text-3xl font-semibold text-center mb-6">Regístrate como Administrador</h1>

                <div class="form-control">

                    <label for="username" class="label flex items-center space-x-2" style="display: flex; align-items: center; justify-content: start;">
                        <i class="fa-solid fa-user fa-xs"></i>
                        <span class="label-text">Nombre de usuario</span>
                    </label>
                    <input type="text" id="username" placeholder="--------" class="input input-bordered w-full" name="username" maxlength="20" required>


                    <label class="label hidden" id="username-error">
                        <span class="label-text-alt text-error">Por favor, ingresa un nombre de usuario válido.</span>
                    </label>

                    <?php
                    if (isset($_GET['error']) && $_GET['error'] == 'username_taken') : ?>

                        <label for="">
                            <span class="label-text-alt text-error">
                                El usuario ya esta en uso.
                            </span>
                        </label>
                    <?php
                    endif;
                    ?>

                </div>

                <div class="form-control mt-4">

                    <label for="password" class="label flex items-center space-x-2" style="display: flex; align-items: center; justify-content: start;">
                        <i class="fa-solid fa-key fa-xs"></i>
                        <span class="label-text">Contraseña</span>
                    </label>

                    <input type="password" id="password" placeholder="--------" class="input input-bordered w-full" name="password" required minlength="6">

                    <label class="label hidden" id="password-error">
                        <span class="label-text-alt text-error">La contraseña debe tener al menos 6 caracteres.</span>
                    </label>

                </div>

                <button type="submit" class="btn btn-active w-full mt-6">
                    <i class="fa-solid fa-pen fa-xs"></i>
                    Regístrate
                </button>

                <p class="mt-5 text-center text-sm text-gray-500">&copy; Alumno FIMAZ 2024</p>
            </form>
        </div>
    </main>

    <script>
        document.getElementById('sign-up-form').addEventListener('submit', function(event) {
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