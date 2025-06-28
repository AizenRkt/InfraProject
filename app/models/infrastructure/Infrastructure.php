<?php
namespace app\models\infrastructure;

use PDO;
use PDOException;
use Flight;

class Infrastructure {
    private string $table = 'infrastructure';
    private string $primaryKey = 'id';

    private function getDB(): PDO {
        return Flight::db();
    }

    public function getAll(): array {
        try {
            $sql = "SELECT i.*, 
                           ST_AsGeoJSON(geom)::json AS geometry,
                           ST_Y(geom) AS lat,
                           ST_X(geom) AS lon,
                           t.nom AS type_nom,
                           t.icon as icon
                    FROM {$this->table} i
                    JOIN type t ON i.type_id = t.id";
            return $this->getDB()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById(int $id): ?array {
        try {
            $stmt = $this->getDB()->prepare("
                SELECT i.*, 
                       ST_AsGeoJSON(geom)::json AS geometry,
                       ST_Y(geom) AS lat,
                       ST_X(geom) AS lon,
                       t.nom AS type_nom
                FROM {$this->table} i
                JOIN type t ON i.type_id = t.id
                WHERE i.{$this->primaryKey} = :id
            ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function insert(array $data): bool {
        try {
            $lat = $data['lat'] ?? null;
            $lon = $data['lon'] ?? null;
            $nom = $data['nom'] ?? null;
            $descriptif = $data['descriptif'] ?? null;
            $type_id = $data['type_id'] ?? null;
            
            if ($lat === null || $lon === null || $nom === null || $type_id === null) return false;
            
            $sql = "INSERT INTO {$this->table} (nom, descriptif, type_id, geom)
                    VALUES (:nom, :descriptif, :type_id, ST_SetSRID(ST_MakePoint(:lon, :lat), 4326))";

            $stmt = $this->getDB()->prepare($sql);
            
            return $stmt->execute([
                'nom' => $nom,
                'descriptif' => $descriptif,
                'type_id' => $type_id,
                'lat' => $lat,
                'lon' => $lon
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(int $id, array $data): bool {
        try {
            $lat = $data['lat'] ?? null;
            $lon = $data['lon'] ?? null;
            unset($data['lat'], $data['lon'], $data['geom']);

            $set = implode(", ", array_map(fn($col) => "\"$col\" = :$col", array_keys($data)));

            if ($lat !== null && $lon !== null) {
                $set .= ", geom = ST_SetSRID(ST_MakePoint(:lon, :lat), 4326)";
                $data['lat'] = $lat;
                $data['lon'] = $lon;
            }

            $sql = "UPDATE {$this->table} SET $set WHERE {$this->primaryKey} = :id";
            $stmt = $this->getDB()->prepare($sql);
            $data['id'] = $id;

            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            $stmt = $this->getDB()->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function toGeoJSONFeatureCollection(): array {
        $features = [];
        foreach ($this->getAll() as $row) {
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
