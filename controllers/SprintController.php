<?php

require_once __DIR__ . '/../models/Historia.php';
require_once __DIR__ . '/../models/Sprint.php';

class HistoriaController {
    private Historia $model;
    private Sprint   $sprintModel;

    public function __construct() {
        $this->model       = new Historia();
        $this->sprintModel = new Sprint();
    }

    
    public function index(): void {
        $historias = $this->model->getAll();

        $porSprint = [];
        foreach ($historias as $h) {
            $porSprint[$h['sprint_nombre']][] = $h;
        }
        require __DIR__ . '/../views/historias/index.php';
    }

    
    public function verSprint(?string $id): void {
        $sprint    = $this->sprintModel->getById((int)$id);
        if (!$sprint) { $this->notFound(); return; }
        $historias = $this->model->getBySprint((int)$id);
        require __DIR__ . '/../views/historias/index.php';
    }

    
    public function create(): void {
        $sprints = $this->sprintModel->getAll();
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titulo'             => trim($_POST['titulo']),
                'descripcion'        => trim($_POST['descripcion']),
                'responsable'        => trim($_POST['responsable']),
                'estado'             => $_POST['estado'],
                'puntos'             => (int)$_POST['puntos'],
                'fecha_creacion'     => $_POST['fecha_creacion'],
                'fecha_finalizacion' => $_POST['fecha_finalizacion'] ?? '',
                'sprint_id'          => (int)$_POST['sprint_id'],
            ];

            if (empty($data['titulo']))      $errores[] = "El título es obligatorio.";
            if (empty($data['descripcion'])) $errores[] = "La descripción es obligatoria.";
            if (empty($data['responsable'])) $errores[] = "El responsable es obligatorio.";
            if ($data['puntos'] <= 0)        $errores[] = "Los puntos deben ser mayor a 0.";
            if (!in_array($data['estado'], Historia::ESTADOS)) $errores[] = "Estado inválido.";
            if (empty($data['fecha_creacion'])) $errores[] = "La fecha de creación es obligatoria.";

            if (empty($errores)) {
                $this->model->create($data);
                header('Location: index.php?controller=historia&action=index&msg=historia_creada');
                exit;
            }
        }
        require __DIR__ . '/../views/historias/create.php';
    }

    public function edit(?string $id): void {
        $historia = $this->model->getById((int)$id);
        if (!$historia) { $this->notFound(); return; }

        $sprints = $this->sprintModel->getAll();
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titulo'             => trim($_POST['titulo']),
                'descripcion'        => trim($_POST['descripcion']),
                'responsable'        => trim($_POST['responsable']),
                'estado'             => $_POST['estado'],
                'puntos'             => (int)$_POST['puntos'],
                'fecha_creacion'     => $_POST['fecha_creacion'],
                'fecha_finalizacion' => $_POST['fecha_finalizacion'] ?? '',
                'sprint_id'          => (int)$_POST['sprint_id'],
            ];

            if (empty($data['titulo']))      $errores[] = "El título es obligatorio.";
            if (empty($data['descripcion'])) $errores[] = "La descripción es obligatoria.";
            if (empty($data['responsable'])) $errores[] = "El responsable es obligatorio.";
            if ($data['puntos'] <= 0)        $errores[] = "Los puntos deben ser mayor a 0.";

            if (empty($errores)) {
                $this->model->update((int)$id, $data);
                header('Location: index.php?controller=historia&action=index&msg=historia_actualizada');
                exit;
            }
            $historia = array_merge($historia, $data);
        }
        require __DIR__ . '/../views/historias/edit.php';
    }

    
    public function delete(?string $id): void {
        $this->model->delete((int)$id);
        header('Location: index.php?controller=historia&action=index&msg=historia_eliminada');
        exit;
    }

    private function notFound(): void {
        http_response_code(404);
        echo "<h2>Historia no encontrada.</h2>";
    }
}