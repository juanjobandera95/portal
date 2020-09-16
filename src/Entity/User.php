<?php


namespace App\Entity;


use App\Core\IEntity;

class User implements IEntity
{
    const DIR_PATH = "./avatar/";

    private $id;
    private $username;
    private $password;
    private $role;
    private $avatar;
    private $language;

    /**
     * @return mixed
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language): void
    {
        $this->language = $language;
    }


    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRole(): ?string
    {
                return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

//metodo donde pasamos los atributos de la entidad para la hora de pasarselo desde el modelo abstracto  desde  la interficie

    public function toArray(): array
    {
        // TODO: Implement toArray() method.

        return ["id" => $this->getId(),
            "username" => $this->getUsername(),
            "password" => $this->getPassword(),
            "role" => $this->getRole(),
            "avatar" => $this->getAvatar(),
            "language" => $this->getLanguage()
        ];

    }
}