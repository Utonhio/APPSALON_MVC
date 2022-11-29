<?php

namespace Controllers;

use Model\Cita;
use MVC\Router;
use Model\Servicio;
use Model\CitaServicio;

class ServicioController
{
    public static function index(Router $router)
    {
        isAdmin();
        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router)
    {
        isAdmin();
        $servicio = new Servicio;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router)
    {
        isAdmin();
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id = filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            header('Location: /servicios');
        };
        $servicio = Servicio::find($id);
        if ($servicio === null) {
            header('Location: /servicios');
        }
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar()
    {
        isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();

            header('Location: /servicios');
        }
    }
}
