<?php

namespace app\controllers;

use app\models\infrastructure\Categorie;
use Flight;

class CrudController {

    public function __construct() {
    }
    
    public function crud($type = null) {
        $categorie = new Categorie();
        Flight::set('categorie', $categorie->getAll());

        $titre = "Gestion des " . ($type ? ucfirst($type) : "Objets");
        $data = [];
        $col = [];
        $foreignKeys = [];
        $formAjout = "";
        $formModif = "";
    
        if ($type) {
            $className = "app\\models\\" . ucfirst($type);
            if (!class_exists($className)) {
                $className = "app\\models\\infrastructure\\" . ucfirst($type);
            }

            if (class_exists($className)) {
                $instance = new $className(); 
                if (method_exists($instance, 'getFormAjout')) {
                    $formAjout = $instance->getFormAjout();
                }
    
                if (method_exists($instance, 'getFormModif')) {
                    $formModif = $instance->getFormModif();
                }

                if (method_exists($instance, 'getAll')) {
                    $data = $instance->getAll();
                }

                if (method_exists($instance, 'getTableCol')) {
                    $col = $instance->getTableCol();
                }

                if (method_exists($instance, 'getManualForeignKey')) {
                    $foreignKeys = $instance->getManualForeignKey();
                    $foreignKeyData = $instance->fetchForeignKeyData($foreignKeys);
    
                    foreach ($foreignKeys as $fk) {
                        $col[] = ['field' => $fk['displayer']]; 
                    }
                    unset($fk);
    
                    foreach ($data as &$row) {
                        foreach ($foreignKeys as $fk) {
                            if (isset($row[$fk['column']]) && isset($foreignKeyData[$fk['column']][$row[$fk['column']]])) {
                                $row[$fk['displayer']] = $foreignKeyData[$fk['column']][$row[$fk['column']]];
                            }
                        }
                    }
                    unset($row);  
                }
            }
        }

        Flight::render('template/crud/crud', [
            'titre' => $titre,
            'minititre' => $titre,
            'type' => $type,
            'data' => $data,
            'col' => $col,
            'primaryKey' => $instance->getPrimaryKey(), 
            'foreignKey' => $foreignKeys, 
            'formAjout' => $formAjout,
            'formModif' => $formModif
        ]);
        
    }
    public function add($type) {
        $data = [];
        foreach ($_GET as $key => $value) {
            $data[$key] = $value;
        }  

        $type = "";
        $referer = $_SERVER['HTTP_REFERER'];
        if ($referer) {
            $urlParts = explode('/', parse_url($referer, PHP_URL_PATH));

            if (count($urlParts) > 0) {
                $type = $urlParts[count($urlParts) - 1];
            }
        }
        $className = "app\\models\\" . $type;
        if (!class_exists($className)) {
            $className = "app\\models\\infrastructure\\" . ucfirst($type);
        }

        if (class_exists($className)) {
            $instance = new $className();
            
            if (method_exists($instance, 'insert')) {
                $instance->insert($data);
            }
        }
        Flight::redirect("/crud/$type");
    }
    
    public function delete($type) {
        $type = "";
        $referer = $_SERVER['HTTP_REFERER'];
        if ($referer) {
            $urlParts = explode('/', parse_url($referer, PHP_URL_PATH));

            if (count($urlParts) > 0) {
                $type = $urlParts[count($urlParts) - 1];
            }
        }
        $className = "app\\models\\" . $type;
        if (!class_exists($className)) {
            $className = "app\\models\\infrastructure\\" . ucfirst($type);
        }

        if (class_exists($className)) {
            $instance = new $className();
            
            if (method_exists($instance, 'delete')) {
                $instance->delete($_GET['id']);
            }
        }
        Flight::redirect("/crud/$type");
    }
    
    public function update($type) {
        if(isset($_SESSION['pKey'])) {

            $data = [];
            foreach ($_GET as $key => $value) {
                if (!empty($value)) {
                    $data[$key] = $value;
                }
            }  
    
            $type = "";
            $referer = $_SERVER['HTTP_REFERER'];
            if ($referer) {
                $urlParts = explode('/', parse_url($referer, PHP_URL_PATH));
    
                if (count($urlParts) > 0) {
                    $type = $urlParts[count($urlParts) - 1];
                }
            }
            $className = "app\\models\\" . $type;
            if (!class_exists($className)) {
                $className = "app\\models\\infrastructure\\" . ucfirst($type);
            }

            if (class_exists($className)) {
                $instance = new $className();
                if (method_exists($instance, 'update')) {
                    $instance->update($_GET[$_SESSION['pKey']], $data);
                    unset($_SESSION['pKey']); 
                }
            }
            Flight::redirect("/crud/$type");    
        }
        Flight::redirect("/crud/$type");    
    }

    public function uploadFile(array $file, string $uploadDir): ?string {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
    
        $fileInfo = pathinfo($file['name']);
        $extension = isset($fileInfo['extension']) ? strtolower($fileInfo['extension']) : '';
    
        $newFileName = $fileInfo['filename'] . "_" . time() . "." . $extension;
        $destination = rtrim($uploadDir, "/") . "/" . $newFileName;
    
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $newFileName; 
        }
    
        return null;
    }
    
    public function import($type) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
            Flight::redirect("/crud/$type?error=Aucun fichier reçu.");
            return;
        }
    
        $file = $_FILES['file'];
    
        if ($file['error'] !== UPLOAD_ERR_OK) {
            Flight::redirect("/crud/$type?error=Erreur lors de l'upload. Code " . $file['error']);
            return;
        }
    
        $maxFileSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxFileSize) {
            Flight::redirect("/crud/$type?error=Le fichier est trop volumineux (max 5MB).");
            return;
        }
    
        $allowedExtensions = ['csv'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
        if (!in_array($fileExtension, $allowedExtensions)) {
            Flight::redirect("/crud/$type?error=Format de fichier non autorisé (CSV uniquement).");
            return;
        }
    
        $uploadDir = dirname(__DIR__, 2) . "/public/csv";
    
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                Flight::redirect("/crud/$type?error=Impossible de créer le dossier d'upload.");
                return;
            }
        }
    
        $uploadedFileName = $this->uploadFile($file, $uploadDir);
    

        if ($uploadedFileName) {
            $path = str_replace('/', '\\', $uploadDir) . '\\' . str_replace('/', '\\', $uploadedFileName);
            
            $className = "app\\models\\" . $type;
            $instance = new $className();
            $instance->insertFromCSV("$path");

            Flight::redirect("/crud/$type?success=Fichier importé avec succès.");
        } else {
            Flight::redirect("/crud/$type?error=Erreur lors de l'importation du fichier.");
        }
    }       
}
