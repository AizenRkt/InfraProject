<?php

namespace app\controllers\infrastructure;

use app\models\infrastructure\Type;
use app\models\infrastructure\Infrastructure;
use Flight;

class InfraController {
     private Infrastructure $model;

    public function __construct() {
        $this->model = new Infrastructure();
    }

    public function editionMap() {
        $type = new Type();
        Flight::render('edition', ['type' => $type->getAll()]);
    }
    public function getAllGeoJSON() {
        Flight::json($this->model->toGeoJSONFeatureCollection());
    }

    public function add() {
        $nom = $_GET['nom'] ?? null;
        $descriptif = $_GET['descriptif'] ?? null;
        $type_id = $_GET['type_id'] ?? null;
        $lat = $_GET['latitude'] ?? null;
        $lon = $_GET['longitude'] ?? null;

        $data = compact('nom', 'descriptif', 'type_id', 'lat', 'lon');

        if ($this->model->insert($data)) {
            $params = http_build_query([
                'success' => 'Infrastructure ajoutée avec succès',
                'lat' => $lat,
                'lon' => $lon
            ]);
            Flight::redirect('/edition?' . $params);
        } else {
            Flight::redirect('/edition?error=Échec de l\'ajout de l\'infrastructure');
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id || !$this->model->delete((int) $id)) {
            Flight::json(['status' => 'error', 'message' => 'Suppression échouée'], 400);
            return;
        }

        Flight::json(['status' => 'success', 'message' => 'Infrastructure supprimée']);
    }

    public function update() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            Flight::json(['status' => 'error', 'message' => 'ID manquant'], 400);
            return;
        }

        $data = $_GET;
        if ($this->model->update((int) $id, $data)) {
            Flight::json(['status' => 'success', 'message' => 'Infrastructure mise à jour']);
        } else {
            Flight::json(['status' => 'error', 'message' => 'Erreur de mise à jour'], 400);
        }
    }
}
