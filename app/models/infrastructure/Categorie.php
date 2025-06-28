<?php
namespace app\models\infrastructure;

use PDO;
use Flight;
use app\models\BaseSQL;

class Categorie extends BaseSQL {
    public function __construct() {
        parent::__construct(Flight::db(), 'categorie', 'id');
    }

    public static function getFormAjout() {
        return 'template/crud/add/formCategorie';
        
    }

    public static function getFormModif() {
        return 'template/crud/modif/formCategorie';        
    }
}
