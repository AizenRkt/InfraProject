<?php

namespace app\models\qgis;

use Flight;
use PDO;
use PDOException;

class District
{
    private string $table = 'vue_district_tana'; 
    private string $primaryKey = 'gid';

    private function getDB(): PDO {
        return Flight::db();
    }

    public function getAll(): array
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            return $this->getDB()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAllWithGeoJSON(): array
    {
        try {
            $sql = "SELECT *, ST_AsGeoJSON(geom)::json AS geometry FROM {$this->table}";
            return $this->getDB()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->getDB()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getByIdWithGeoJSON(int $id): ?array
    {
        try {
            $stmt = $this->getDB()->prepare("SELECT *, ST_AsGeoJSON(geom)::json AS geometry FROM {$this->table} WHERE {$this->primaryKey} = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function insert(array $data): bool
    {
        try {
            $geom = $data['geom'] ?? null;
            unset($data['geom']);

            $columns = implode(", ", array_map(fn($col) => "`$col`", array_keys($data)));
            $placeholders = implode(", ", array_map(fn($col) => ":$col", array_keys($data)));

            $sql = "INSERT INTO {$this->table} ($columns, geom) VALUES ($placeholders, ST_GeomFromText(:geom, 4326))";

            $stmt = $this->getDB()->prepare($sql);
            $data['geom'] = $geom;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $geom = $data['geom'] ?? null;
            unset($data['geom']);

            $set = implode(", ", array_map(fn($col) => "`$col` = :$col", array_keys($data)));
            if ($geom !== null) {
                $set .= ", geom = ST_GeomFromText(:geom, 4326)";
                $data['geom'] = $geom;
            }

            $sql = "UPDATE {$this->table} SET $set WHERE {$this->primaryKey} = :id";
            $stmt = $this->getDB()->prepare($sql);
            $data['id'] = $id;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->getDB()->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function toGeoJSONFeatureCollection(): array
    {
        $features = [];
        foreach ($this->getAllWithGeoJSON() as $row) {
            $geometry = json_decode($row['geometry'], true);
            unset($row['geometry'], $row['geom']);

            $features[] = [
                'type' => 'Feature',
                'geometry' => $geometry,
                'properties' => $row
            ];
        }

        return [
            'type' => 'FeatureCollection',
            'features' => $features
        ];
    }
}
