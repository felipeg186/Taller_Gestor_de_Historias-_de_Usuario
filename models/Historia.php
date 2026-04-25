<?php

require_once __DIR__ . '/config/database.php';

class Historia {
    private PDO $db;

    public const ESTADOS = ['nueva', 'activa', 'finalizada', 'impedimento'];

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    
    public function getAll(): array {
        $sql = "SELECT h.*, s.nombre AS sprint_nombre
                FROM historias h
                JOIN sprints s ON h.sprint_id = s.id
                ORDER BY h.sprint_id, h.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    
    public function getBySprint(int $sprintId): array {
        $stmt = $this->db->prepare(
            "SELECT * FROM historias WHERE sprint_id = ? ORDER BY id DESC"
        );
        $stmt->execute([$sprintId]);
        return $stmt->fetchAll();
    }

    
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT h.*, s.nombre AS sprint_nombre
             FROM historias h
             JOIN sprints s ON h.sprint_id = s.id
             WHERE h.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    
    public function create(array $data): bool {
        $sql = "INSERT INTO historias
                    (titulo, descripcion, responsable, estado, puntos, fecha_creacion, fecha_finalizacion, sprint_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['responsable'],
            $data['estado'],
            $data['puntos'],
            $data['fecha_creacion'],
            $data['fecha_finalizacion'] ?: null,
            $data['sprint_id']
        ]);
    }

   
    public function update(int $id, array $data): bool {
        $sql = "UPDATE historias SET
                    titulo = ?, descripcion = ?, responsable = ?, estado = ?,
                    puntos = ?, fecha_creacion = ?, fecha_finalizacion = ?, sprint_id = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['responsable'],
            $data['estado'],
            $data['puntos'],
            $data['fecha_creacion'],
            $data['fecha_finalizacion'] ?: null,
            $data['sprint_id'],
            $id
        ]);
    }

    
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM historias WHERE id = ?");
        return $stmt->execute([$id]);
    }

    
    public function getReportePorSprint(int $sprintId): array {
        $sql = "SELECT
                    COUNT(*) AS total,
                    SUM(CASE WHEN estado = 'finalizada'  THEN 1 ELSE 0 END) AS finalizadas,
                    SUM(CASE WHEN estado = 'impedimento' THEN 1 ELSE 0 END) AS impedimentos,
                    SUM(CASE WHEN estado IN ('nueva','activa') THEN 1 ELSE 0 END) AS pendientes,
                    SUM(puntos) AS puntos_totales,
                    SUM(CASE WHEN estado = 'finalizada' THEN puntos ELSE 0 END) AS puntos_completados
                FROM historias WHERE sprint_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sprintId]);
        return $stmt->fetch();
    }

   
    public function getReportePorResponsable(int $sprintId): array {
        $sql = "SELECT responsable,
                    COUNT(*) AS total,
                    SUM(CASE WHEN estado = 'finalizada'  THEN 1 ELSE 0 END) AS finalizadas,
                    SUM(CASE WHEN estado = 'impedimento' THEN 1 ELSE 0 END) AS impedimentos,
                    SUM(CASE WHEN estado IN ('nueva','activa') THEN 1 ELSE 0 END) AS pendientes,
                    SUM(puntos) AS puntos_totales
                FROM historias WHERE sprint_id = ?
                GROUP BY responsable
                ORDER BY responsable";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sprintId]);
        return $stmt->fetchAll();
    }
}