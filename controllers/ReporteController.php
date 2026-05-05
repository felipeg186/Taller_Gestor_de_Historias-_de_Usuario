<?php

require_once __DIR__ . '/../models/Historia.php';
require_once __DIR__ . '/../models/Sprint.php';

class ReporteController {
    private Historia $historiaModel;
    private Sprint   $sprintModel;

    public function __construct() {
        $this->historiaModel = new Historia();
        $this->sprintModel   = new Sprint();
    }

    public function index(?string $id = null): void {
        $sprints     = $this->sprintModel->getAll();
        $sprintSel   = null;
        $resumen     = null;
        $porResponsable = [];

        
        $sprintId = (int)($_GET['sprint_id'] ?? $_POST['sprint_id'] ?? $id ?? 0);

        if ($sprintId > 0) {
            $sprintSel      = $this->sprintModel->getById($sprintId);
            $resumen        = $this->historiaModel->getReportePorSprint($sprintId);
            $porResponsable = $this->historiaModel->getReportePorResponsable($sprintId);
        }

        require __DIR__ . '/../views/reportes/index.php';
    }
}