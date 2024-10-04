<?php
//editarRecurso.php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}

include('../../core/baseURL.php');

require_once('../../controllers/recursoController.php');

//Obtener el id del recurso por la URL
$id_recurso = isset($_GET['id_recurso']) ? intval($_GET['id_recurso']) : 0;

$objControlR = new recursoController();
$rowsRecursos = $objControlR->obtenerRecursoPorID($id_recurso);

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
                    <li><a href="<?php echo BASE_URL; ?>views/recursos/actualizarRecurso.php?id_recurso=<?php echo $id_recurso; ?>"><b>Actualizar Recurso</b></a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-base-300 rounded-box ml-6 mb-6 shadow-lg">

            <!-- Form -->
            <div id="recursos">
                <h1 class="text-2xl sm:text-3xl lg:text-3xl font-bold mb-4"><i class="fa-solid fa-pen"></i> Actualizar Recurso</h1>
                <?php if (empty($rowsRecursos)) : ?>
                    <div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>No se encontró el recurso seleccionado</span>
                    </div>
                <?php else : ?>
                    <?php foreach ($rowsRecursos as $rowRecurso) : ?>
                        <form id="resourceForm" method="POST" enctype="multipart/form-data">
                            <!-- Alerta de éxito -->
                            <div id="mensajeConfirmacion" role="alert" class="alert alert-success hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Datos guardados exitosamente!</span>
                            </div>

                            <!-- Alerta de Error -->
                            <div id="mensajeError" role="alert" class="alert alert-error hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Error! No se guardarón los datos</span>
                            </div>


                            <!-- ID Recurso -->
                            <div class="form-control w-full ">
                                <label class="label">
                                    <span class="label-text">ID Recurso</span>
                                </label>
                                <input type="number " class="input input-bordered rounded-box shadow-lg" name="id_recurso" id="id_recurso" value="<?php echo htmlspecialchars($rowRecurso['id_recurso']); ?>" readonly />
                            </div>


                            <!-- Nombre Recurso -->
                            <div class="form-control w-full mt-4">
                                <label class="label">
                                    <span class="label-text">Nombre del Recurso </span>
                                </label>
                                <input type="text" placeholder="Nombre del Recurso" class="input input-bordered rounded-box shadow-lg" name="nombreRecurso" id="nombreRecurso" value="<?php echo htmlspecialchars($rowRecurso['nombreRecurso']); ?>" />
                                <label class="label hidden" id="nombreRecurso-error">
                                    <span class="label-text-alt text-error">Por favor, ingresa el nombre del recurso.</span>
                                </label>
                            </div>

                            <!-- Img Recurso -->
                            <div class="form-control w-full mt-4">
                                <label class="label">
                                    <span class="label-text">Imagen del Recurso </span>
                                </label>
                                <input type="file" class="file-input file-input-bordered  rounded-box shadow-lg" accept=".png,.jpg,.jpeg" name="imgRecurso" id="imgRecurso" />
                                <input type="text" name="imgRecurso" value="<?php echo htmlspecialchars($rowRecurso['imgRecurso']) ?>" hidden>
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
                                    <option value="1" <?php if ($rowRecurso['id_Carrera'] == 1) echo 'selected'; ?>>LICENCIATURA EN INFORMÁTICA</option>
                                    <option value="2" <?php if ($rowRecurso['id_Carrera'] == 2) echo 'selected'; ?>>LICENCIATURA EN INGENIERÍA EN SISTEMAS DE INFORMACION</option>
                                    <option value="3" <?php if ($rowRecurso['id_Carrera'] == 3) echo 'selected'; ?>>LICENCIATURA EN INGENIERÍA EN SISTEMAS DE INFORMACION VIRTUAL</option>

                                </select>
                                <label class="label hidden" id="idCarrera-error">
                                    <span class="label-text-alt text-error">Por favor, selecciona una carrera.</span>
                                </label>
                            </div>

                            <!-- Tipo de Recurso -->
                            <div class="form-control w-full mt-4">
                                <label class="label">
                                    <span class="label-text">Tipo</span>
                                </label>
                                <select name="tipo" class="select select-bordered rounded-box shadow-lg" id="tipo">
                                    <option value="">Selecciona un tipo</option>
                                    <option value="ofertaEducativa" <?php if ($rowRecurso['tipo'] == 'ofertaEducativa') echo 'selected' ?>>Oferta Educativa</option>
                                    <option value="calendario" <?php if ($rowRecurso['tipo'] == 'calendario') echo 'selected' ?>>Calendario</option>
                                </select>
                                <label class="label hidden" id="tipo-error">
                                    <span class="label-text-alt text-error">Por favor, selecciona un tipo.</span>
                                </label>
                            </div>

                            <!-- Fecha de Creacion -->
                            <div class="form-control w-full mt-4 ">
                                <label class="label">
                                    <span class="label-text">Fecha de Creación</span>
                                </label>
                                <input type="date" class="input input-bordered rounded-box shadow-lg" value="<?php echo $rowRecurso['fecha_publicacion']; ?>" readonly />
                            </div>


                            <div class="form-control w-full mt-10">
                                <button type="submit" class="btn btn-warning rounded-box shadow-lg"><i class="fa-solid fa-floppy-disk"></i> Guardar edición</button>
                            </div>
                        </form>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>

    </div>

</div>
</div>

<script>
    $(document).ready(function() {
        $('#resourceForm').submit(function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe normalmente

            // Obtener datos del formulario
            var formData = new FormData(this);

            // Enviar la petición AJAX
            $.ajax({
                type: 'POST',
                url: '../../controllers/miniController/actualizar_recurso.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        $('#mensajeConfirmacion').removeClass('hidden');
                        setTimeout(function() {
                            $('#mensajeConfirmacion').addClass('hidden');
                        }, 3000);
                    } else {
                        $('#mensajeError').removeClass('hidden');
                        setTimeout(function() {
                            $('#mensajeError').addClass('hidden');
                        }, 8000);
                    }
                },
                error: function() {
                    $('#mensajeError').removeClass('hidden');
                    setTimeout(function() {
                        $('#mensajeError').addClass('hidden');
                    }, 3000);
                }
            });
        });
    });
</script>
<script src="../../public/js/sideBar.js"></script>
<!-- Footer -->
<?php include("../templates/footer.php"); ?>