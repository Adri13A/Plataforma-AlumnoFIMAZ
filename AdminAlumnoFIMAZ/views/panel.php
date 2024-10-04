<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit();
}

include('../core/baseURL.php')
?>


<!-- App Header -->
<?php include("./templates/header.php"); ?>

<!-- App Content -->
<div class="flex flex-1">

    <!-- Sidebar -->
    <?php include("./templates/sideBar.php") ?>


    <!-- Main content -->
    <div class="flex-1 p-6 bg-base-300 rounded-box mb-6 ml-6 mr-6 shadow-lg">

        <!-- Projects Section -->
        <!--  <div class="p-6 rounded-box">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Projects</h2>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <h3 class="text-xl font-semibold">45</h3>
                            <p class="text-sm">In Progress</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">24</h3>
                            <p class="text-sm">Upcoming</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">62</h3>
                            <p class="text-sm">Total Projects</p>
                        </div>
                    </div>
                </div> -->

        <!-- <div class="divider"></div> -->

        <!-- Categories Section -->
        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="rounded-box">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold"><i class="fa-solid fa-grip-vertical fa-rotate-90"></i>&nbsp; Categorias</h2>
                    <span>
                        <?php
                        $userTimezone = "America/Mazatlan";
                        // Obtener la hora actual para la zona horaria
                        $currentTime = new DateTime("now", new DateTimeZone($userTimezone));
                        // Obtener el año actual en texto
                        $dia_actual = $currentTime->format("l, F, Y");
                        ?>
                        <b><?php echo $dia_actual ?></b>
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                    <!-- Recursos -->
                    <a href="<?php echo BASE_URL; ?>views/recursos/recursos.php" class="card bg-base-100  transform transition-transform duration-300 hover:translate-y-[-5px]  rounded-box shadow-lg">
                        <div class="card-body">
                            <h3 class="card-title"> <i class="fa-solid fa-diagram-project"></i> Recursos</h3>
                            <p>Ver Recursos</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-active rounded-box shadow-lg"><i class="fa-solid fa-circle-plus"></i> Entrar</button>
                            </div>
                        </div>
                    </a>


                    <!-- Horario -->
                    <a href="#" class="card bg-base-100  transform transition-transform duration-300 hover:translate-y-[-5px]  rounded-box shadow-lg">
                        <div class="card-body">
                            <h3 class="card-title"><i class="fa-solid fa-calendar-days text-xl"></i> Horarios</h3>
                            <p>Ver Horarios</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-active rounded-box shadow-lg"><i class="fa-solid fa-circle-plus"></i> Entrar</button>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

</div>



<script src="../public/js/sideBar.js"></script>

<!-- Footer -->
<?php include("./templates/footer.php"); ?>