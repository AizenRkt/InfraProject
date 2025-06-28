<?php

namespace app\controllers\qgis;

use app\models\qgis\Commune;
use PDO;

class CommuneController
{
    private Commune $model;

    public function __construct()
    {
        $this->model = new Commune();
    }

    public function getAllGeoJSON(): void
    {
        $geojson = $this->model->toGeoJSONFeatureCollection();
        header('Content-Type: application/json');
        echo json_encode($geojson);
    }

    public function getByIdGeoJSON(int $id): void
    {
        $commune = $this->model->getByIdWithGeoJSON($id);
        header('Content-Type: application/json');
        echo json_encode($commune ?? ['error' => 'Commune non trouvée']);
    }
}
