<?php
namespace App;

use App\Core\AppException;
use App\Exception\DBException;
use PDO;
use PDOException;

/**
 * Class DBConnection
 * @package App
 */
class DBConnection
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * DBConnection constructor.
     */
    private function __construct()
    {
        try {

            $config = require __DIR__ . '/../config/config.php';

            $name = $config['database']['name'];
            $user = $config['database']['username'];
            $pass = $config['database']['password'];
            $connection = $config['database']['connection'];
            $options = $config['database']['options'];

            $this->connection = new PDO("$connection;dbname=$name", $user, $pass, $options);

        } catch (PDOException $e) {
            throw new DBException('Se ha producido un error al intentar conectar al servidor MySQL: ' . $e->getMessage() . "" . $e->getLine());

        }
    }

    /**
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        try {
            $PDO = new DBConnection();
            return $PDO->connection;

        } catch (PDOException $e) {
            throw new  DBException('Se ha producido un error al intentar conectar al servidor MySQL: ' . $e->getMessage() . "" . $e->getLine());

        }

    }

}