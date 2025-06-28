<?php

namespace app\controllers\stats;

use Countable;
use Flight;
use PDO;

class DashboardController {

    private function getDB(): PDO {
        return Flight::db();
    }

    /**
     * Compte le nombre de lignes dans une table donnée
     *
     * @param string $table 
     * @return int 
     */
    private function countTable(string $table): int {
        $stmt = $this->getDB()->prepare("SELECT COUNT(*) as total FROM $table");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    public function dashboard() {
        $nb_district = $this->countTable('vue_district_tana ');
        $nb_commune = $this->countTable('vue_communes_tana');
        $nb_infrastructure = $this->countTable('infrastructure');

        // Passer les stats à la vue
        Flight::render('template/dashboard', [
            'nb_district' => $nb_district,
            'nb_commune' => $nb_commune,
            'nb_infra' => $nb_infrastructure
        ]);
    }
}
