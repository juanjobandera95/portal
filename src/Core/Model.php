<?php


namespace App\Core;


use App\Exception\NotFoundException;
use Exception;
use PDO;
use PDOException;

/**
 * Class Model
 * @package App\Core
 */
abstract class Model
{
    /**
     * @var
     */
    protected $entity;
    /**
     * @var PDO
     */
    protected $pdo;
    /**
     * @var
     */
    protected $table;

    /**
     * Model constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * @return array
     */
    public function findAll($order = []): array
    {
        if (empty($order))

            //hacemos la consulta
            $smt = $this->pdo->query("SELECT * FROM $this->table");

        else //Order By publishedAt

        {
            $orderClause = array_map(function ($v, $k) {
                return sprintf("%s %s", $k, $v);
            }, $order,
                array_keys($order));

            //[0] =>"publishedAt" DESC
            $orderClause = implode(', ,', $orderClause);
            $smt = $this->pdo->query("SELECT * FROM $this->table ORDER BY $orderClause");
        }
        // retorna todas las entidades
        $entities = $smt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        return $entities;
    }


    /**
     * @param int $id
     * @return IEntity|null
     * @throws NotFoundException
     */
    public function find(int $id): ?IEntity
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table  WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        $stmt->execute();
        $entity = $stmt->fetch();
        if ($entity == false) {
            throw new NotFoundException("La $this->entity no existe con el id  " . $id);
        } else {
            return $entity;
        }


    }


    /**
     * @param array $data
     * @return array
     */
    public function findBy(array $data = []): array
    {

        $sql = "SELECT * FROM $this->table WHERE %s";


        $whereClause = implode(',', array_map(
            function ($k) {
                return sprintf("%s=:%s", $k, $k);
            },
            array_keys($data)));

        $selectSQL = sprintf($sql, $whereClause);
        $stmt = $this->pdo->prepare($selectSQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        $stmt->execute($data);
        $entities = $stmt->fetchAll();
        return $entities;
    }


    /**
     * @param IEntity $entity
     * @return bool
     */
    public function update(IEntity $entity): bool
    {
        try {
            $data = $entity->toArray();
            // prepare la consulta preparada SQL de modificar en la BB.DD.
            $sql = ("UPDATE %s SET %s WHERE id=:id");

            $dataWithoutID = array_filter($data, function ($e) {
                return ($e !== 'id');
            }, ARRAY_FILTER_USE_KEY);

            $setClause = implode(',', array_map(function ($k) {
                return sprintf("%s = :%s", $k, $k);
            }, array_keys($dataWithoutID)));

            $updateSQL = sprintf($sql, $this->table, $setClause);

            $stmt = $this->pdo->prepare($updateSQL);

            $stmt->execute($data);
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $PDOException) {
            die ('Error: ' . $PDOException->getMessage() . 'y su linea es ' . $PDOException->getLine());
        }
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data = [])
    {
        $entities = $this->findBy($data);
        return $entities[0];

    }

    /**
     * @param IEntity $entity
     * @return bool
     */
    public function delete(IEntity $entity): bool
    {
        try {
            //hacemos el get para cogerlo despues como parametro
            $id = $entity->getId();
            //preparamos la sentencia
            $stmt = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
            $stmt->bindParam(':id', $id);
            //ejecutamos la sentencia
            $stmt->execute();
            //si es igual a 1 dara true si no false
            if ($stmt->rowCount() == 1) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage() . 'y su linea es ' . $e->getLine());
        }

    }

    /**
     * @param IEntity $entity
     * @return bool
     */
    public function insert(IEntity $entity): bool
    {
        try {
            $data = $entity->toArray();
            $sql = "INSERT INTO %s (%s)VALUES(:%s)";
            $insertSQL = sprintf($sql, $this->table, implode(',', array_keys($data)), implode(', :', array_keys($data)));
            $stmt = $this->pdo->prepare($insertSQL);
            $stmt->execute($data);
            if ($stmt->rowCount() == 1) {
                $entity->setId((int)$this->pdo->lastInsertId());
                return true;
            } else {
                return false;
            }
        } catch (PDOException $PDOException) {
            die($PDOException->getMessage());
        }
    }


}