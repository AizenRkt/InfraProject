<?php

namespace app\models;

use PDO;
use PDOException;
use Exception;

class BaseSQL {
    protected $db;
    protected $table;
    protected $primaryKey;

    public function __construct(PDO $db, string $table, string $primaryKey) {
        $this->db = $db;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    public function getDb() {
        return $this->db;
    }

    public function getTable() {
        return $this->table;
    }

    public function getPrimaryKey() {
        return $this->primaryKey;
    }

    public function insert(array $data): bool {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            print($e);
            return false;
        }
    }

    public function update($id, array $data): bool {
        try {
            $setPart = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
            $sql = "UPDATE {$this->table} SET $setPart WHERE {$this->primaryKey} = :id";
            $stmt = $this->db->prepare($sql);
            $data['id'] = $id;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            print($e);
            return false;
        }
    }

    public function delete($id): bool {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAll(): array {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById($id): ?array {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getWhere(array $conditions): array {
        try {
            $where = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($conditions)));
            $sql = "SELECT * FROM {$this->table} WHERE $where";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($conditions);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getTableCol() {
        try {
            $sql = "
                SELECT column_name AS field
                FROM information_schema.columns
                WHERE table_name = :table
                ORDER BY ordinal_position
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['table' => strtolower($this->table)]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getForeignKeys(): array {
        try {
            $sql = "
                SELECT 
                    kcu.column_name AS column_name,
                    ccu.table_name AS referenced_table,
                    ccu.column_name AS referenced_column
                FROM 
                    information_schema.key_column_usage kcu
                JOIN 
                    information_schema.constraint_column_usage ccu 
                    ON kcu.constraint_name = ccu.constraint_name
                JOIN 
                    information_schema.table_constraints tc 
                    ON tc.constraint_name = kcu.constraint_name
                WHERE 
                    tc.constraint_type = 'FOREIGN KEY'
                    AND kcu.table_name = :table
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['table' => strtolower($this->table)]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // public function fetchForeignKeyData(array $foreignKeys): array {
    //     $foreignKeyData = [];

    //     foreach ($foreignKeys as $fk) {
    //         $query = "SELECT {$fk['column']}, {$fk['display']} FROM {$fk['table']}";
    //         $stmt = $this->db->query($query);
    //         $foreignKeyData[$fk['column']] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    //     }

    //     return $foreignKeyData;
    // }

    public function fetchForeignKeyData(array $foreignKeys): array {
        $foreignKeyData = [];

        foreach ($foreignKeys as $fk) {
            $ref = $fk['ref'];
            $query = "SELECT {$ref}, {$fk['display']} FROM {$fk['table']}";
            $stmt = $this->db->query($query);
            $foreignKeyData[$fk['column']] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    return $foreignKeyData;
}
    public function insertFromCSV(string $filePath): array {
        $results = ['inserted' => 0, 'errors' => []];

        if (!file_exists($filePath) || !is_readable($filePath)) {
            $results['errors'][] = "Fichier introuvable ou illisible.";
            return $results;
        }

        try {
            $handle = fopen($filePath, "r");
            if (!$handle) {
                $results['errors'][] = "Impossible d'ouvrir le fichier.";
                return $results;
            }

            $header = fgetcsv($handle, 0, ";");
            if (!$header || !is_array($header)) {
                $results['errors'][] = "Fichier CSV vide ou mal formaté.";
                fclose($handle);
                return $results;
            }

            $header = array_map(fn($col) => trim($col, "\" \t\n\r\0\x0B"), $header);

            while (($row = fgetcsv($handle, 0, ";")) !== false) {
                if (!is_array($row)) continue;

                $row = array_map(fn($val) => trim($val, "\" \t\n\r\0\x0B"), $row);

                if (count($row) !== count($header)) {
                    $results['errors'][] = "Ligne invalide : " . implode(";", $row);
                    continue;
                }

                $data = array_combine($header, $row);
                if ($this->insert($data)) {
                    $results['inserted']++;
                } else {
                    $results['errors'][] = "Échec insertion : " . implode(";", $row);
                }
            }

            fclose($handle);
        } catch (Exception $e) {
            $results['errors'][] = "Erreur : " . $e->getMessage();
        }

        return $results;
    }
}
