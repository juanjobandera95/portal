<?php
namespace App;

use App\Core\App;
use App\Core\Response;
use App\Core\Router;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;



session_start();
if (!session_id()) @session_start();
require_once __DIR__ . "/../vendor/autoload.php";
$router = new Router();
require __DIR__ . '/../config/routes.php';
App::set('router', $router);

$response = new Response();
App::set('response', $response);

$config = require __DIR__ . '/../config/config.php';
App::set('config', $config);


App::set('connection', DBConnection::getConnection());

// create a log channel
$log = new Logger('xbqeLogger');
$log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
App::set('logger', $log);

$log->info('info');


if (!empty($_SESSION['loggedUser'])) {
    App::set('user', App::getModel(UserModel::class)->find($_SESSION['loggedUser']));
} else {
    App::set('user', null);
}