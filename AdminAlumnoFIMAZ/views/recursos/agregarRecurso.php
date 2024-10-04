<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}

include('../../core/baseURL.php');
?>


<!-- App Header -->
<?php include("../templates/header.php"); ?>

<!-- App Content -->
<div class="flex flex-1">

    <!-- Sidebar -->
    <?php include("../templates/sideBar.php"); ?>


    <div class="flex-1 mr-6">
        <!-- Breadcrumbs -->
        <div class="bg-base-300 rounded-box shadow-lg mb-4 ml-6 ps-6 w-full">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>views/panel.php"><b>Inicio</b></a></li>
                    <li><a href="<?php echo BASE_URL; ?>views/recursos/recursos.php"><b>Recursos</b></a></li>
                    <li><a href="<?php echo BASE_URL; ?>views/recursos/agregarRecurso.php"><b>Agregar Recurso</b></a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-base-300 rounded-box mb-6 ml-6 shadow-lg">

            <!-- Form -->
            <div id="recursos">
                <h1 class="text-2xl sm:text-3xl lg:text-3xl font-bold mb-4"> <i class="fa-solid fa-plus"></i> Agregar Recurso</h1>

                <div class="badge badge-error badge-outline">* Obligatorio</div>

                <form id="resourceForm" method="POST" enctype="multipart/form-data">
                    <!-- Alerta de éxito -->
                    <div id="mensajeConfirmacion" role="alert" class="alert alert-success hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Datos guardados exitosamente!</span>
                    </div>

                    <!-- Alerta de Error -->
                    <div id="mensajeError" role="alert" class="alert alert-error mt-2 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Error! No se guardarón los datos</span>
                    </div>

                    <!-- Nombre Recurso -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Nombre del Recurso <span class="text-error">*</span></span>
                        </label>
                        <input type="text" placeholder="Nombre del Recurso" class="input input-bordered rounded-box shadow-lg" name="nombreRecurso" id="nombreRecurso" />
                        <label class="label hidden" id="nombreRecurso-error">
                            <span class="label-text-alt text-error">Por favor, ingresa el nombre del recurso.</span>
                        </label>
                    </div>

                    <!-- Img Recurso -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text">Imagen del Recurso <span class="text-error">*</span></span>
                        </label>
                        <input type="file" class="file-input file-input-bordered  rounded-box shadow-lg" accept=".png,.jpg,.jpeg" name="imgRecurso" id="imgRecurso" />
                        <label class="label hidden" id="imgRecurso-error">
                            <span class="label-text-alt text-error">Por favor, selecciona alguna imagen.</span>
                        </label>
                    </div>

                    <!-- ID Carrera -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text">ID Carrera</span>
                            <span class="badge badge-outline">Opcional</span>

                        </label>
                        <select name="idCarrera" class="select select-bordered rounded-box shadow-lg" id="idCarrera">
                            <option value="">Selecciona una carrera</option>
                            <option value="1">LICENCIATURA EN INFORMÁTICA</option>
                            <option value="2">LICENCIATURA EN INGENIERÍA EN SISTEMAS DE INFORMACION</option>
                            <option value="3">LICENCIATURA EN INGENIERÍA EN SISTEMAS DE INFORMACION VIRTUAL</option>
                        </select>
                        <label class="label hidden" id="idCarrera-error">
                            <span class="label-text-alt text-error">Por favor, selecciona una carrera.</span>
                        </label>
                    </div>

                    <!-- Tipo de Recurso -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text">Tipo <span class="text-error">*</span></span>
                        </label>
                        <select name="tipo" class="select select-bordered rounded-box shadow-lg" id="tipo">
                            <option value="">Selecciona un tipo</option>
                            <option value="ofertaEducativa">Oferta Educativa</option>
                            <option value="calendario">Calendario</option>
                        </select>
                        <label class="label hidden" id="tipo-error">
                            <span class="label-text-alt text-error">Por favor, selecciona un tipo.</span>
                        </label>
                    </div>

                    <!-- Dia de creacion -->
                    <div class="form-control w-full mt-4 ">
                        <label class="label">
                            <span class="label-text">Fecha </span>
                        </label>
                        <?php
                        $userTimezone = "America/Mazatlan";

                        // Get the current time for the timezone
                        $currentTime = new DateTime("now", new DateTimeZone($userTimezone));
                        ?>
                        <input type="datetime" class="input input-bordered rounded-box shadow-lg" name="fecha" id="" value="<?php echo $currentTime->format("Y/m/d"); ?>" readonly />
                    </div>


                    <!-- Boton de guardar -->
                    <div class="form-control w-full mt-10">
                        <button type="submit" class="btn btn-success rounded-box shadow-lg"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
</div>

<script>
    $(document).ready(function() {
        $('#resourceForm').submit(function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe normalmente

            // Validar el formulario aquí si es necesario
            let valid = true;

            // Nombre del Recurso validation
            const nombreRecurso = document.getElementById('nombreRecurso');
            const nombreRecursoError = document.getElementById('nombreRecurso-error');
            if (!nombreRecurso.value.trim()) {
                nombreRecurso.classList.add('input-error');
                nombreRecursoError.classList.remove('hidden');
                valid = false;
            } else {
                nombreRecurso.classList.remove('input-error');
                nombreRecursoError.classList.add('hidden');
            }

            // Imagen del Recurso validation
            const imgRecurso = document.getElementById('imgRecurso');
            const imgRecursoError = document.getElementById('imgRecurso-error');
            if (!imgRecurso.value.trim()) {
                imgRecurso.classList.add('input-error');
                imgRecursoError.classList.remove('hidden');
                valid = false;
            } else {
                imgRecurso.classList.remove('input-error');
                imgRecursoError.classList.add('hidden');
            }

            // ID de Carrera validation
            const idCarrera = document.getElementById('idCarrera');
            const idCarreraError = document.getElementById('idCarrera-error');
            if (idCarrera.value.trim() === "") {
                if (idCarrera.hasAttribute('required')) {
                    idCarrera.classList.add('select-error');
                    idCarreraError.classList.remove('hidden');
                    valid = false;
                } else {
                    idCarrera.classList.remove('select-error');
                    idCarreraError.classList.add('hidden');
                }
            } else {
                idCarrera.classList.remove('select-error');
                idCarreraError.classList.add('hidden');
            }

            // Tipo validation
            const tipo = document.getElementById('tipo');
            const tipoError = document.getElementById('tipo-error');
            if (!tipo.value.trim()) {
                tipo.classList.add('select-error');
                tipoError.classList.remove('hidden');
                valid = false;
            } else {
                tipo.classList.remove('select-error');
                tipoError.classList.add('hidden');
            }

            // Si el formulario no es válido, salir
            if (!valid) {
                return;
            }

            // Obtener datos del formulario
            var formData = new FormData(this);

            // Enviar la petición AJAX
            $.ajax({
                type: 'POST',
                url: '../../controllers/miniController/agregar_recursos.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    // Mostrar el mensaje de confirmación
                    $('#mensajeConfirmacion').removeClass('hidden');

                    // Ocultar el mensaje después de 3 segundos
                    setTimeout(function() {
                        $('#mensajeConfirmacion').addClass('hidden');
                    }, 6000); // 6000 milisegundos = 6 segundos

                    // Limpiar el formulario
                    $('#resourceForm')[0].reset();
                },
                error: function(response) {
                    // Mostrar el mensaje de error
                    $('#mensajeError').removeClass('hidden');

                    // Ocultar el mensaje después de 8 segundos
                    setTimeout(function() {
                        $('#mensajeError').addClass('hidden');
                    }, 8000);
                }
            });
        });
    });
</script>
<script src="../../public/js/sideBar.js"></script>
<!-- Footer -->
<?php include("../templates/footer.php"); ?>