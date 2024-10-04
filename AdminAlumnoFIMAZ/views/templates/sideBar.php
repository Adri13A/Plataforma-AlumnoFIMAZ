<?php
// Determina la URL actual
$current_url = $_SERVER['REQUEST_URI'];

// Función para verificar si el enlace es el actual
function isActive($link)
{
    global $current_url;
    return strpos($current_url, $link) !== false ? 'active' : '';
}

// Determina si la sección de Recursos está activa
function isRecursosActive()
{
    global $current_url;
    return strpos($current_url, 'recursos') !== false;
}
?>

<nav class="sidebar ml-6 mb-6 bg-base-300 rounded-box" id="sidebar">
    <div class="sidebar-content ">
        <ul class="menu rounded-box" style="align-items: flex-start;">
            <!-- Inicio -->
            <li class="mb-4">
                <a href="<?php echo BASE_URL; ?>views/panel.php" class="<?php echo isActive('panel.php') || isActive('panel-subsection.php') ? 'active' : ''; ?> flex items-center hover:bg-neutral-focus p-2 rounded-box">
                    <i class="fa-solid fa-house text-xl"></i><span class="sidebar-text">Inicio</span>
                </a>
            </li>

            <!-- Recursos -->
            <li class="mb-4" style="padding-right: 0rem;">
                <details id="recursos-details" class="<?php echo isRecursosActive() ? 'active' : ''; ?>">
                    <summary class="flex items-center hover:bg-neutral-focus p-2 rounded-box">
                        <i class="fa-solid fa-diagram-project text-xl"></i><span class="sidebar-text">Recursos</span>
                    </summary>
                    <ul class="submenu">
                        <li><a href="<?php echo BASE_URL; ?>views/recursos/recursos.php" class="<?php echo isActive('recursos.php') ? 'active' : ''; ?> rounded-box mt-2"><i class="fa-solid fa-eye"></i> Recursos</a></li>
                        <li><a href="<?php echo BASE_URL; ?>views/recursos/agregarRecurso.php" class="<?php echo isActive('agregarRecurso.php') ? 'active' : ''; ?> rounded-box mt-2 mb-2"><i class="fa-solid fa-plus"></i> Agregar Recursos</a></li>
                    </ul>
                </details>
            </li>

            <!-- Horarios -->
            <li class="mb-4">
                <a href="#" class="<?php echo isActive('horarios') || isActive('horarios-subsection.php') ? 'active' : ''; ?> flex items-center hover:bg-neutral-focus p-2 rounded-box">
                    <i class="fa-solid fa-calendar-days text-xl"></i><span class="sidebar-text">Horarios</span>
                </a>
            </li>

            <!-- Configuración -->
            <li class="mb-4">
                <a href="#" class="<?php echo isActive('configuracion') || isActive('configuracion-subsection.php') ? 'active' : ''; ?> flex items-center hover:bg-neutral-focus p-2 rounded-box">
                    <i class="fa-solid fa-gear text-xl"></i><span class="sidebar-text">Configuración</span>
                </a>
            </li>
        </ul>
    </div>

</nav>