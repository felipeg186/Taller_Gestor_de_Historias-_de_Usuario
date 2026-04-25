<?php

require_once __DIR__ . '/config/database.php';

class Sprint {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM sprints ORDER BY fecha_inicio DESC");
        return $stmt->fetchAll();
    }

    
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM sprints WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO sprints (nombre, fecha_inicio, fecha_fin) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['fecha_inicio'],
            $data['fecha_fin']
        ]);
    }

    
    public function update(int $id, array $data): bool {
        $sql = "UPDATE sprints SET nombre = ?, fecha_inicio = ?, fecha_fin = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $id
        ]);
    }

    
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM sprints WHERE id = ?");
        return $stmt->execute([$id]);
    }

    
    public function getAllWithCount(): array {
        $sql = "SELECT s.*, COUNT(h.id) AS total_historias,
                    SUM(CASE WHEN h.estado = 'finalizada' THEN 1 ELSE 0 END) AS finalizadas,
                    SUM(h.puntos) AS total_puntos
                FROM sprints s
                LEFT JOIN historias h ON h.sprint_id = s.id
                GROUP BY s.id
                ORDER BY s.fecha_inicio DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}