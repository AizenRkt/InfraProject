<?php
namespace app\models\infrastructure;

use PDO;
use Flight;
use app\models\BaseSQL;

class Type extends BaseSQL {
    public function __construct() {
        parent::__construct(Flight::db(), 'type', 'id');
    }

    public static function getManualForeignKey() {
        return [
            [
                'column' => 'categorie_id',
                'table' => 'categorie',
                'ref' => 'id',
                'display' => 'nom',
                'displayer' => 'categorie'
            ]
        ];
    }

    public static function getFormAjout() {
        return 'template/crud/add/formType';
        
    }

    public static function getFormModif() {
        return 'template/crud/modif/formType';        
    }
}
