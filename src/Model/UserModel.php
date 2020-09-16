<?php


namespace App\Model;


use App\Core\App;
use App\Core\Security;
use App\Core\Model;
use App\Entity\News;
use App\Entity\User;
use App\Exception\UploadedFileException;
use App\Utils\UploadedFile;
use PDO;
use PDOException;

/**
 * Class UserModel
 * @package App\Model
 */
class UserModel extends Model
{
    /**
     * UserModel constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->entity = User::class;
        $this->table = 'user';
        parent::__construct($pdo);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function register(User $user): bool
    {

        /**
         *
         * registra el usuario por username y contraseña
         *
         *
         */
        $stmt = $this->pdo->prepare('INSERT INTO user (username,password) VALUES (:username,:password)');
        $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user->setId((int)$this->pdo->lastInsertId());
            return true;
        } else
            return false;


    }

    /**
     * @return User
     *
     */
    public function getDataInsert(): User
    {
        /**
         * obtenemos solo username y contraseña para insertar usuario en el backoffice
         *
         */
        $security = new Security();
        $user = new User();
        $user->setUsername(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
        $user->setPassword($security->encrypt($user->getPassword()));

        return $user;
    }

    /**
     * @return User
     */
    public function getDataUpdate(): User
    {
        /**
         *
         * obtenemos el usuario y el role para que lo pueda modificar el admin
         *
         */
        $user = new User();
        $user->setUsername(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        $user->setRole(filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS));
        return $user;
    }

    /**
     * @return User
     */
    public function getDataRegister(): User
    {
        /**
         *
         * obtenemos los datos del formulario para registrar el usuario
         *
         */
        $user = new User();
        $security = new Security();
        $user->setUsername(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        $user->setPassword($security->encrypt($user->getPassword()));
        // $user->setRole('ROLE_USER');
        return $user;
    }

    /**
     * @return User
     * @throws UploadedFileException
     */
    public function getDataProfile(): User
    {
        /**
         *
         * obtenemos los datos del formulario del perfil de usuario
         *
         */
        $user = new User();
        $security = new Security();
        $user->setUsername(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        $user->setPassword($security->encrypt($user->getPassword()));
        $user->setAvatar(filter_input(INPUT_POST, 'avatar-name', FILTER_SANITIZE_STRING));
        $user->setRole(filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING));
        $user->setLanguage(filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING));


        $uploadImage = $_FILES['avatar'];
        $uploadFile = new UploadedFile($uploadImage, 512508, array('image/jpg', 'image/png', 'image/jpeg'));

        $validateImage = $uploadFile->validate();
        if ($validateImage === true) {
            if ($uploadFile->save(News::DIR_PATH) === true) {
                $urlImg = $uploadFile->getFileName();
                $user->setAvatar($urlImg);
            }
        } else {
            $user->setAvatar(filter_input(INPUT_POST, 'avatar-name', FILTER_SANITIZE_STRING));
        }

        return $user;
    }

    /**
     * @param User $user
     * @return array
     */
    public function validateUpdate(User $user): array
    {
        /**
         *
         *
         * validamos en el caso de modificar/cambiar perfil o usuario en backoffice
         *
         */
        $errors = [];
        $name = trim(filter_var($user->getUsername(), FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim(filter_var($user->getPassword()));
        $role = trim(filter_var($user->getRole(), FILTER_SANITIZE_SPECIAL_CHARS));

        if (strlen($name) > 50) {
            array_push($errors, "Nombre del usuario no puede tener mas de 50 caracteres <br>");
        } elseif (empty($name)) {
            array_push($errors, "Nombre de usuario esta vacio <br>");
        } elseif ($name === NULL) {
            array_push($errors, "Nombre de usuario esta nulo <br>");
        }


        if (strlen($role) > 30) {
            array_push($errors, "El role usuario no puede tener mas de 30 caracteres <br>");
        } elseif (empty($role)) {
            array_push($errors, "El role de usuario esta vacio <br>");
        } elseif ($role === NULL) {
            array_push($errors, "El role de usuario esta nulo <br>");
        }
        return $errors;
    }

    /**
     * @param User $user
     * @return array
     */
    public function validateInsert(User $user): array
    {
        /**
         *
         * validamos al insertar
         *
         */
        $errors = [];
        $name = trim(filter_var($user->getUsername(), FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim(filter_var($user->getPassword(), FILTER_SANITIZE_SPECIAL_CHARS));

        if (strlen($name) > 50) {
            array_push($errors, "Nombre del usuario no puede tener mas de 50 caracteres <br>");
        } elseif (empty($name)) {
            array_push($errors, "Nombre de usuario esta vacio <br>");
        } elseif ($name === NULL) {
            array_push($errors, "Nombre de usuario esta nulo <br>");
        }

        $security = new Security();

        if (!$security->checkPasswordPolicy($password)) {
            array_push($errors, "La contraseña debe cumplir la normativa establecida <br>");
        } elseif (empty($password)) {
            array_push($errors, "La contraseña de usuario esta vacio <br>");
        } elseif ($password === NULL) {
            array_push($errors, "La contraseña de usuario esta nula <br>");
        }
        return $errors;
    }

    /**
     * @param User $user
     * @return array
     */
    public function validateRegister(User $user): array
    {
        /***
         *
         * validamos en el caso de registrar
         *
         *
         */
        $errors = [];

        $username = filter_var($user->getUsername());
        $password = filter_var($user->getPassword());

        if ($username === null)
            array_push($errors, 'Debes de introducir el nombre del usuario');
        else if (!is_string($username))
            array_push($errors, 'Hubo un problema con el nombre del usuario');
        else if (strlen($username) > 60)
            array_push($errors, 'El nombre del usuario supera el maximo de carecteres(60)');
        else if (!Security::checkPasswordPolicy($password))
            array_push($errors, 'La contraseña no cumple la normativa establecida');
        return $errors;
    }

    /**
     * @param User $user
     * @return array
     */
    public function validateProfileUser(User $user): array
    {
        /**
         *
         * validamos en el caso del cambio en el perfil
         *
         */
        $errors = [];
        $username = filter_var($user->getUsername());
        $password = filter_var($user->getPassword());
        $role = filter_var($user->getRole());

        if ($username == null)
            array_push($errors, 'Debes de introducir el nombre del usuario');
        else if (!is_string($username))
            array_push($errors, 'Hubo un problema con el nombre del usuario');
        else if (strlen($username) > 60)
            array_push($errors, 'El nombre del usuario supera el maximo de carecteres(60)');
        else if (!Security::checkPasswordPolicy($password))
            array_push($errors, 'La contraseña no cumple la normativa establecida');


        return $errors;
    }
}
