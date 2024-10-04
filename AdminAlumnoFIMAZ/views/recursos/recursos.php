<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../views/login.php');
    exit();
}

include('../../core/baseURL.php');

require_once('../../controllers/recursoController.php');

$objControlR = new recursoController();
$rowsRecursos = $objControlR->obtenerRecurso();

$tipoMap = array(
    'calendario' => 'Calendario',
    'ofertaEducativa' => 'Oferta Educativa'
);

$tipoCarrera = array(
    '1' => 'LICENCIATURA EN INFORMÁTICA (LI)',
    '2' => 'LICENCIATURA EN INGENIERÍA EN SISTEMAS DE INFORMACIÓN (LISI)'
);
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
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-base-300 rounded-box ml-6 mb-6 shadow-lg">
            <h1 class="text-2xl sm:text-3xl lg:text-3xl font-bold mb-4">Recursos</h1>

            <!-- Alert Exito -->
            <div id="mensajeConfirmacion" role="alert" class="alert alert-success hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>El recurso ha sido eliminado correctamente.</span>
            </div>

            <!-- Alerta de Error -->
            <div id="mensajeError" role="alert" class="alert alert-error hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Error! No se eliminó el recurso</span>
            </div>

            <!-- Recursos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4" id="recurso-cards">

                <a href="<?php echo BASE_URL; ?>views/recursos/agregarRecurso.php" class="card bg-base-100 rounded-box transform transition-transform duration-300 hover:-translate-y-1 relative overflow-hidden shadow-lg" style="height: 15rem;">
                    <div class="card-body justify-center" style="align-items:center;">
                        <i class="fa-solid fa-plus text-6xl sm:text-7xl lg:text-8xl"></i>
                    </div>
                </a>

                <?php if (empty($rowsRecursos)) : ?>

                <?php else : ?>
                    <?php foreach ($rowsRecursos as $rowRecurso) : ?>
                        <div class="relative card bg-base-100 rounded-box overflow-hidden flex transform transition-transform duration-300 hover:translate-y-[-5px] shadow-lg" style="height: 15rem;" id="card-<?php echo htmlspecialchars($rowRecurso['id_recurso']); ?>">
                            <!-- Contenedor de la imagen a la derecha -->
                            <div class="absolute right-0 w-3/2">
                            <img class="object-cover" src="<?php echo BASE_URL; ?>/views/imgUploads/<?php echo empty($rowRecurso['imgRecurso']) ? '../../public/img/noImage.png' : htmlspecialchars($rowRecurso['imgRecurso']); ?>" >
                            </div>
                            <!-- Contenedor del desenfoque -->
                            <div class="blur-overlay absolute top-0 left-0 w-full h-full transition duration-300"></div>
                            <!-- Contenedor del degradado a la izquierda -->
                            <div class="relative h-full flex items-center text-white p-4">
                                <div class="">
                                    <h3 class="card-title text-base sm:text-lg lg:text-xl text-white mb-2"><?php echo htmlspecialchars($rowRecurso['nombreRecurso']) ?></h3>
                                    <p>
                                        <?php echo htmlspecialchars($tipoCarrera[$rowRecurso['id_Carrera']] ?? ''); ?>
                                    </p>
                                    <span class="stat-desc text-white">
                                        <?php echo htmlspecialchars($tipoMap[$rowRecurso['tipo']] ?? 'Desconocido'); ?>
                                    </span>
                                    <br>
                                    <span class="stat-desc text-white"><?php echo htmlspecialchars($rowRecurso['fecha_publicacion']); ?></span>
                                    <div class="card-actions justify-start mt-4">
                                        <a href="actualizarRecurso.php?id_recurso=<?php echo htmlentities($rowRecurso['id_recurso']) ?>" class="btn btn-sm btn-warning rounded-box"><i class="fa-solid fa-pen"></i></a>
                                        <button class="btn btn-sm btn-error rounded-box" onclick="eliminarRecurso(<?php echo htmlspecialchars($rowRecurso['id_recurso']) ?>)"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<input type="checkbox" id="my_modal_7" class="modal-toggle" />
<div class="modal shadow-lg" role="dialog" style=" backdrop-filter: blur(6px);">
    <div class="modal-box">
        <h3 class="text-lg font-bold"><i class="fa-solid fa-trash"></i> Eliminar Recurso</h3>
        <p class="py-4">¿Está seguro de que desea eliminar el recurso (<?php echo htmlspecialchars($rowRecurso['nombreRecurso']) ?>) permanentemente?</p>
        <form action="<?php echo BASE_URL ?>controllers/miniController/eliminar_recurso.php" method="POST" id="delete-form">
            <label class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" for="my_modal_7">✕</label>
            <input type="hidden" name="id_recurso" id="delete-id">
            <div class="modal-action">
                <button type="submit" class="btn btn-sm btn-error rounded-box"><i class="fa-solid fa-trash fa-bounce"></i>Eliminar</button>
            </div>
        </form>
    </div>
    <label class="modal-backdrop" for="my_modal_7">Close</label>
</div>

<script>
    function eliminarRecurso(idRecurso) {
        // Configurar el modal
        $('#delete-id').val(idRecurso);
        $('#my_modal_7').prop('checked', true);

        // Procesar la eliminación al enviar el formulario
        $('#delete-form').on('submit', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Eliminar el card del DOM
                        $('#card-' + idRecurso).fadeOut(function() {
                            $(this).remove();
                        });

                        // Mostrar el mensaje de confirmación
                        $('#mensajeConfirmacion').removeClass('hidden').fadeIn();
                        setTimeout(function() {
                            $('#mensajeConfirmacion').fadeOut();
                        }, 6000);

                    } else {
                        $('#mensajeError span').text(response.message);
                        $('#mensajeError').removeClass('hidden').fadeIn();
                        setTimeout(function() {
                            $('#mensajeError').fadeOut();
                        }, 8000);
                    }
                    $('#my_modal_7').prop('checked', false);
                },
                error: function() {
                    $('#mensajeError span').text('Error al eliminar el recurso.');
                    $('#mensajeError').removeClass('hidden').fadeIn();
                    setTimeout(function() {
                        $('#mensajeError').fadeOut();
                    }, 8000);
                    $('#my_modal_7').prop('checked', false);
                }
            });
        });
    }
</script>
<script src="../../public/js/sideBar.js"></script>
<!-- Footer -->
<?php include("../templates/footer.php"); ?>