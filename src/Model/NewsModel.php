<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\App;
use App\Core\IEntity;
use App\Core\Model;
use App\Entity\Category;
use App\Entity\News;
use App\Entity\User;
use App\Utils\UploadedFile;
use App\Exception\UploadedFileException;
use App\Exception\NotFoundException;
use DateTime;
use PDO;
use PDOException;


/**
 * Class NewsModel
 * @package App\Model
 */
class NewsModel extends Model
{

    public function __construct(PDO $pdo)
    {
        $this->entity = News::class;
        $this->table = 'news';
        parent::__construct($pdo);
    }
    /**
     *
     * metodo que obtiene las noticias paginadas
     */
    /**
     * @param int $currentPage
     * @param $totalPages
     * @return array
     */
    public function getAll(int $currentPage, &$totalPages): array
    {

        //paginas-limite
        $pageSize = 4;
        $recordCount = 0;
        //total de paginas
        $totalPages = 0;

        //compensacion
        $offset = ($currentPage - 1) * $pageSize;
        //obtendremos el total de las noticias
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM news");
        $total = $stmt->fetch();

        $recordCount = $total["total"];
        //redondearemos
        $totalPages = (int)ceil($recordCount / $pageSize);
        $stmt = $this->pdo->prepare("SELECT * FROM news ORDER BY publishedAt DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $news = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);

        return $news;

    }


    /**
     * @param $id
     * @return array
     */
    /**
     *
     *
     * obtiene las noticias filtradas por categorias
     *
     */
    public function getByCat(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM news WHERE categoryId = :categoryId ');
        $stmt->bindValue(':categoryId', $id, PDO::PARAM_INT);
        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        return $news;
    }

    /**
     * @param $id
     * @param $currentPage
     * @param $totalPages
     * @return array
     */


    public function getByCategoryPaginated($id, $currentPage, &$totalPages): array
    {
        /**
         *
         * obtiene las noticias filtradas por categorias paginadas
         *
         *
         */
        $pageSize = 4;
        $recordCount = 0;
        $totalPages = 0;

        $offset = ($currentPage - 1) * $pageSize;

        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS total FROM news WHERE categoryId = :categoryId ');
        $stmt->bindValue(':categoryId', $id, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->fetch();

        $recordCount = $total["total"];
        $totalPages = (int)ceil($recordCount / $pageSize);

        $stmt = $this->pdo->prepare('SELECT * FROM news WHERE categoryId = :categoryId LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':categoryId', $id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        return $news;
    }



    /**
     * @param $date1
     * @param $date2
     * @return array
     */
    public function getByDate($date1, $date2): array
    {

        /***
         *
         * obtiene un array con las noticias filtradas por fechas
         *
         *
         */

        $stmt = $this->pdo->prepare('SELECT * FROM news  WHERE publishedAt BETWEEN :date1 AND :date2');
        $stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
        $stmt->bindValue(':date2', $date2, PDO::PARAM_STR);
        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        return $news;
    }

    /**
     * @param $date1
     * @param $date2
     * @param $currentPage
     * @param $totalPages
     * @return array
     */
    public function getByDatePaginated($date1, $date2, $currentPage, &$totalPages): array
    {
        /**
         *
         * obtiene las noticias filtradas paginadas
         *
         *
         **/
        $pageSize = 4;
        $recordCount = 0;
        $totalPages = 0;

        $offset = ($currentPage - 1) * $pageSize;

        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS total FROM news  WHERE publishedAt BETWEEN :date1 AND :date2');
        $stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
        $stmt->bindValue(':date2', $date2, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->fetch();

        $recordCount = $total["total"];
        $totalPages = (int)ceil($recordCount / $pageSize);

        $stmt = $this->pdo->prepare('SELECT * FROM news  WHERE publishedAt BETWEEN :date1 AND :date2 LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
        $stmt->bindValue(':date2', $date2, PDO::PARAM_STR);
        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        return $news;
    }

    /**
     * @param $text
     * @return array
     */
    public function getByText($text): array
    {
        /**
         *
         * array de noticias buscadas por titulo-descripcion
         *
         *
         **/
        $text = "%$text%";
        $stmt = $this->pdo->prepare('SELECT * FROM news  WHERE title LIKE :text OR description LIKE :text2');
        $stmt->bindValue(':text', $text, PDO::PARAM_STR);
        $stmt->bindValue(':text2', $text, PDO::PARAM_STR);
        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        return $news;
    }

    /**
     * @param $text
     * @param $currentPage
     * @param $totalPages
     * @return array
     */
    public function getByTextPaginated($text, $currentPage, &$totalPages): array
    {

        /**
         *
         * paginamos a la vez que hacemos la consulta por busqueda
         *
         */
        $pageSize = 4;
        $recordCount = 0;
        $totalPages = 0;

        $offset = ($currentPage - 1) * $pageSize;

        //contar total de registros de la palabra busqueda
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM news  WHERE title LIKE :text OR description LIKE :text2");
        $stmt->bindValue(':text', $text, PDO::PARAM_STR);
        $stmt->bindValue(':text2', $text, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->fetch();

        $recordCount = $total["total"];
        $totalPages = (int)ceil($recordCount / $pageSize);

        $text = "%$text%";
        //obtenido el dataset
        $stmt = $this->pdo->prepare('SELECT * FROM news  WHERE title LIKE :text OR description LIKE :text2
LIMIT :limit OFFSET :offset
');
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':text', $text, PDO::PARAM_STR);
        $stmt->bindValue(':text2', $text, PDO::PARAM_STR);
        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        return $news;
    }

    /**
     * @param $id
     * @return News|null
     * @throws NotFoundException
     */
    public function getById($id): ?News
    {
        /**
         *
         * Obtiene un objeto
         *
         */
        $stmt = $this->pdo->prepare('SELECT * FROM news WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->entity);
        $stmt->execute();
        $new = $stmt->fetch();
        if ($new == false) {
            throw new NotFoundException("La noticia no existe con el id  " . $id);
        } else {
            return $new;
        }
    }

    /**
     * @param News $new
     * @return Category|null
     * @throws NotFoundException
     */
    public function getCategories(News $new): ?Category
    {
        /**
         *
         * Obtiene un objeto
         *
         */
        $categoryModel = new CategoryModel($this->pdo);
        $category = $categoryModel->getById($new->getCategoryId());
        return $category;
    }

    /**
     * @param News $new
     * @return IEntity|null
     * @throws NotFoundException
     */
    public function getUsers(News $new): ?IEntity
    {
        /**
         *
         * obtiene el objeto user
         *
         */
        $userModel = new UserModel($this->pdo);
        $user = $userModel->find($new->getAuthorId());
        return $user;
    }

    /**
     * @return News
     * @throws UploadedFileException
     */
    public function getData(): News
    {
        /**
         *
         * Obtiene los datos del formulario
         *
         */
        $new = new News();
        $new->setTitle(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
         $new->setDescription(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
        $publishedAt = filter_input(INPUT_POST, 'publishedAt', FILTER_SANITIZE_STRING);
        $new->setImage(filter_input(INPUT_POST, 'image-name', FILTER_SANITIZE_STRING));
        $new->setCategoryId(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT));
        $new->setAuthorId((filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_NUMBER_INT)));

        if(isset($_FILES['image']) || empty($_FILES['image']))
        $uploadImage = $_FILES['image'];
        $uploadFile = new UploadedFile($uploadImage, 512508, array('image/jpg', 'image/png', 'image/jpeg'));

            $validateImage = $uploadFile->validate();
            if ($validateImage === true) {
                if ($uploadFile->save(News::DIR_PATH) === true) {
                    $urlImg = $uploadFile->getFileName();
                    $new->setImage($urlImg);
                }
            } else {
                $new->setImage(filter_input(INPUT_POST, 'image-name', FILTER_SANITIZE_STRING));
            }


        $publishedAtDate = DateTime::createFromFormat('Y-m-d', $publishedAt);
        if ($publishedAtDate === false)
            $new->setPublishedAt($publishedAtDate);


        return $new;


    }


    /**
     * @return array
     */
    public function validateFilterByDate(): array
    {
        /**
         *
         *
         * validamos
         *
         */
        $errors = [];

        $date1 = filter_input(INPUT_GET, 'date1', FILTER_SANITIZE_STRING);
        $date2 = filter_input(INPUT_GET, 'date2', FILTER_SANITIZE_STRING);


        if (DateTime::createFromFormat("Y-m-d", $date1) === false) {
            array_push($errors, "La fecha de inicio debe estar a este formato Y-m-d <br/>");
        } elseif (empty($date1)) {
            array_push($errors, "La fecha de inicio de inicio esta vacia <br>");
        } elseif ($date1 === NULL) {
            array_push($errors, "La fecha de inicio esta nula <br>");
        }
        if (DateTime::createFromFormat("Y-m-d", $date2) === false) {
            array_push($errors, "La fecha de acabada debe estar a este formato Y-m-d <br/>");
        } elseif (empty($date2)) {
            array_push($errors, "La fecha de acabada esta vacia <br>");
        } elseif ($date2 === NULL) {
            array_push($errors, "La fecha esta nula <br>");
        }

        return $errors;
    }



    //validamos si esta vacio o no, en el caso de la longitud del titulo y la descripcion

    /**
     * @param News $new
     * @return array
     */
    public function validate(News $new): array
    {
        $errors = [];
        //por cambiar
        $title = filter_var($new->getTitle(), FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_var($new->getDescription(), FILTER_SANITIZE_SPECIAL_CHARS);
        $publishedAt = filter_var($new->getPublishedAt()->format('Y-m-d'), FILTER_SANITIZE_STRING);
        $dataFormat = DateTime::createFromFormat('Y-m-d', $publishedAt);

        if (strlen($title) > 300) {
            array_push($errors, "titulo tiene un limite de caracteres <br>");
        } elseif (!is_string($title)) {
            array_push($errors, "El titulo debe ser una cadena de texto <br/>");
        } elseif (empty($title)) {
            array_push($errors, "titulo esta vacio <br>");
        } elseif ($title === NULL) {
            array_push($errors, "titulo esta nulo <br>");
        }

        if (strlen($description) > 12000) {
            array_push($errors, "La descripcion tiene un limite de caracteres<br>");
        } elseif (!is_string($description)) {
            array_push($errors, "La descripcion debe ser una cadena de texto <br/>");
        } elseif (empty($description)) {
            array_push($errors, "La descripcion esta vacia <br>");
        } elseif ($description === NULL) {
            array_push($errors, "La descripcion esta nula <br>");
        }

        if ($dataFormat == 'Y-m-d') {
            array_push($errors, 'La fecha tiene que ser en este formato Y-m-d <br/>');

        } elseif (empty($dataFormat)) {
            array_push($errors, 'La fecha tiene que ser en este formato <br/>');

        } elseif ($dataFormat === NULL) {
            array_push($errors, 'La fecha tiene que ser en este formato <br/>');
        }


        return $errors;
    }
}