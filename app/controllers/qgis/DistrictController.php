<?php

namespace app\controllers\qgis;

use app\models\qgis\District;
use PDO;

class DistrictController
{
    private District $model;

    public function __construct()
    {
        $this->model = new District();
    }

    public function getAllGeoJSON(): void
    {
        $geojson = $this->model->toGeoJSONFeatureCollection();
        header('Content-Type: application/json');
        echo json_encode($geojson);
    }

    public function getByIdGeoJSON(int $id): void
    {
        $District = $this->model->getByIdWithGeoJSON($id);
        header('Content-Type: application/json');
        echo json_encode($District ?? ['error' => 'District non trouvée']);
    }
}
