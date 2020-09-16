<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;
use App\Entity\Category;
use App\Exception\NotFoundException;
use PDO;
use PDOException;

/**
 * Class CategoryModel
 * @package App\Model
 */
class CategoryModel extends Model
{

    /**
     * CategoryModel constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        /**
         *
         *
         * obtenemos el nombre de la classe, de la tabla y tambien la conexion pdo
         */
        $this->entity = Category::class;
        $this->table = 'category';
        parent::__construct($pdo);
    }


    /**
     * @param $id
     * @return Category|null
     * @throws NotFoundException
     */
    public function getById($id): ?Category
    {

        /**
         *
         * obtenemos una categoria
         *
         *
         */
        $stmt = $this->pdo->prepare('SELECT * FROM category WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        $stmt->execute();
        $category = $stmt->fetch();
        if ($category === false)
            throw new NotFoundException("La categoria no existe con el id  " . $id);
        return $category;
    }
    /**
     * @return Category
     */
    public function getData(): Category
    {
        /**
         *
         * cogemos los atributos a cambiar o a insertar
         *
         */
        $category = new Category();
        $category->setName(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        return $category;
    }

    /**
     * @param Category $category
     * @return array
     */
    public function validate(Category $category): array
    {

        /***
         *
         * validamos los datos
         *
         *
         ***/

        $errors = [];
        $nameCat = trim(filter_var($category->getName(), FILTER_SANITIZE_SPECIAL_CHARS));
        if (strlen($nameCat) > 50) {
            array_push($errors, "Nombre no puede tener mas de 20 caracteres <br>");
        } elseif (empty($nameCat)) {
            array_push($errors, "Nombre esta vacio <br>");
        } elseif ($nameCat === NULL) {
            array_push($errors, "Nombre esta nulo <br>");
        }
        return $errors;
    }
}