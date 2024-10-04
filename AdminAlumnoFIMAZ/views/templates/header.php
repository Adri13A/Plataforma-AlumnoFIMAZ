<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="https://img.icons8.com/fluency-systems-filled/96/646ee4/dashboard-layout.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>public/css/style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/9705d6f157.js" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_URL ?>public/js/switchMode.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('sidebar');
            var toggleButton = document.getElementById('toggleSidebar');
            var recursosDetails = document.getElementById('recursos-details');

            // Alternar el estado de la barra lateral
            toggleButton.addEventListener('click', function() {
                var isSidebarOpen = sidebar.classList.toggle('open');
                if (!isSidebarOpen) {
                    recursosDetails.removeAttribute('open'); // Cierra el <details> si la barra lateral se cierra
                }
            });

            // Asegura que la sidebar se expanda si el elemento details está abierto
            if (recursosDetails.open) {
                sidebar.classList.add('open');
            }

            // Detecta el evento de apertura del elemento details
            recursosDetails.addEventListener('toggle', function() {
                if (recursosDetails.open) {
                    sidebar.classList.add('open');
                } else {
                    sidebar.classList.remove('open');
                }
            });
        });
    </script>
    <title>Panel Administrativo</title>
</head>

<body class="bg-base-200">
    <div class="flex flex-col min-h-screen">

        <button id="toggleSidebar" class="toggle-btn bg-base-100">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <header class="p-4 pl-9 ps-9">
            <div class="flex justify-between items-center">
                <!-- Left Section -->
                <div class="flex items-center space-x-4  transform transition-transform duration-300 hover:translate-y-[-5px]">

                    <a href="<?php echo BASE_URL; ?>/views/panel.php">
                        <img src="https://img.icons8.com/fluency-systems-filled/96/646ee4/dashboard-layout.png" alt="App Icon" class="w-10 h-10">
                    </a>

                    <a class="text-2xl sm:text-3xl lg:text-3xl font-bold" href="<?php echo BASE_URL; ?>/views/panel.php">Panel Administrativo</a>

                    <div class="form-control">
                        <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto rounded-box" hidden />
                    </div>

                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <label class="swap swap-rotate">
                        <!-- this hidden checkbox controls the state -->
                        <input type="checkbox" class="theme-controller" />

                        <!-- sun icon -->
                        <svg class="swap-off h-7 w-7 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                        </svg>

                        <!-- moon icon -->
                        <svg class="swap-on h-7 w-7 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                        </svg>
                    </label>

                    <button class="btn btn-primary" hidden>
                        <i class="fa-solid fa-plus"></i> Nuevo Proyecto
                    </button>

                    <button class="btn btn-ghost" hidden>
                        <i class="fa-solid fa-bell"></i>
                    </button>

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar online">
                            <div class="w-24 rounded-full bg-neutral">
                                <img src="<?php echo BASE_URL; ?>public/img/logofimazlight.png" class="p-1" />
                            </div>
                        </div>

                        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box mt-3 w-52 p-2 shadow">
                            <li>
                                <a class="justify-between">
                                    Profile
                                </a>
                            </li>
                            <li><a>Settings</a></li>
                            <li><a href="<?php echo BASE_URL; ?>controllers/miniController/logoutMiniC.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>