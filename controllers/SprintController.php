<?php
require_once __DIR__ . '/../models/Sprint.php';

class SprintController {
    private Sprint $model;

    public function __construct() {
        $this->model = new Sprint();
    }

    public function index(): void {
        $sprints = $this->model->getAllWithCount();
        require __DIR__ . '/../views/sprints/index.php';
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre'       => trim($_POST['nombre']),
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin'    => $_POST['fecha_fin'],
            ];

            $errores = [];
            if (empty($data['nombre']))       $errores[] = "El nombre es obligatorio.";
            if (empty($data['fecha_inicio'])) $errores[] = "La fecha de inicio es obligatoria.";
            if (empty($data['fecha_fin']))    $errores[] = "La fecha de fin es obligatoria.";
            if ($data['fecha_fin'] < $data['fecha_inicio']) $errores[] = "La fecha de fin no puede ser anterior a la de inicio.";

            if (empty($errores)) {
                $this->model->create($data);
                header('Location: index.php?controller=sprint&action=index&msg=sprint_creado');
                exit;
            }
            require __DIR__ . '/../views/sprints/create.php';
        } else {
            $errores = [];
            require __DIR__ . '/../views/sprints/create.php';
        }
    }

    public function edit(?string $id): void {
        $sprint = $this->model->getById((int)$id);
        if (!$sprint) { $this->notFound(); return; }

        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre'       => trim($_POST['nombre']),
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin'    => $_POST['fecha_fin'],
            ];

            if (empty($data['nombre']))       $errores[] = "El nombre es obligatorio.";
            if (empty($data['fecha_inicio'])) $errores[] = "La fecha de inicio es obligatoria.";
            if (empty($data['fecha_fin']))    $errores[] = "La fecha de fin es obligatoria.";
            if ($data['fecha_fin'] < $data['fecha_inicio']) $errores[] = "La fecha de fin no puede ser anterior.";

            if (empty($errores)) {
                $this->model->update((int)$id, $data);
                header('Location: index.php?controller=sprint&action=index&msg=sprint_actualizado');
                exit;
            }
            $sprint = array_merge($sprint, $data);
        }
        require __DIR__ . '/../views/sprints/edit.php';
    }

    public function delete(?string $id): void {
        $this->model->delete((int)$id);
        header('Location: index.php?controller=sprint&action=index&msg=sprint_eliminado');
        exit;
    }

    private function notFound(): void {
        http_response_code(404);
        echo "<h2>Sprint no encontrado.</h2>";
    }
}