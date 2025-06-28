<?php

//importation de controller
use app\controllers\Controller;
use app\controllers\CrudController;
use app\controllers\qgis\CommuneController;
use app\controllers\qgis\DistrictController;
use app\controllers\infrastructure\InfraController;
use app\controllers\stats\DashboardController;

//importation lié flight
use flight\Engine;
use flight\net\Router;

//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$Controller = new Controller();
$router->get('/', [ $Controller, 'acceuil' ]);

$Dashboard = new DashboardController();
$router->get('/dashboard', [ $Dashboard, 'dashboard' ]);

$Crud = new CrudController();
$router->get('/crud/@type', [$Crud, 'crud']);
$router->get('/crud/@type/add', [$Crud, 'add']);
$router->get('/crud/@type/delete', [$Crud, 'delete']);
$router->get('/crud/@type/update', [$Crud, 'update']);
$router->post('/crud/@type/import', [$Crud, 'import']);

$Commune = new CommuneController();
$router->get('/commune/getAll', [$Commune, 'getAllGeoJSON']);

$District = new DistrictController();
$router->get('/district/getAll', [$District, 'getAllGeoJSON']);

$InfraC = new InfraController();
$router->get('/infrastructure/getAll', [$InfraC, 'getAllGeoJSON']);
$router->get('/edition', [$InfraC, 'editionMap']);
$router->get('/edition/add', [$InfraC, 'add']);

// $router->get('/', \app\controllers\WelcomeController::class.'->home'); 

// $router->get('/hello-world/@name', function($name) {
// 	echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
// });

// $router->group('/api', function() use ($router, $app) {
// 	$Api_Example_Controller = new ApiExampleController($app);
// 	$router->get('/users', [ $Api_Example_Controller, 'getUsers' ]);
// 	$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);
// 	$router->post('/users/@id:[0-9]', [ $Api_Example_Controller, 'updateUser' ]);
// });

?>