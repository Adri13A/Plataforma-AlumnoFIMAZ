<?php

class Router {
    private $routes = [];

    // Método para agregar rutas
    public function addRoute($route, $handler) {
        $this->routes[$route] = $handler;
    }

    // Método para manejar la solicitud
    public function handleRequest($url) {
        // Obtener la parte de la ruta después del nombre de dominio
        $urlParts = parse_url($url);
        $path = $urlParts['path'];

        // Buscar una ruta coincidente en las rutas definidas
        foreach ($this->routes as $route => $handler) {
            if ($route === $path) {
                // Si hay una coincidencia, llamar al controlador y acción correspondiente
                list($controllerName, $actionName) = explode('@', $handler);
                $controllerFile = '../controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controller = new $controllerName($pdo);
                    return $controller->$actionName();
                } else {
                    die('Controlador no encontrado.');
                }
            }
        }

        // Manejar el caso de ruta no encontrada
        die('Ruta no encontrada.');
    }
}
