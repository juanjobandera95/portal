<?php

namespace App\Entity;

use App\Core\IEntity;
use DateTime;

/**
 * Class News
 * @package App\Entity
 */
class News implements IEntity
{
    /**
     *
     */
    const DIR_PATH = "./img/";
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $title;
    /**
     * @var DateTime
     */
    private $publishedAt;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $image;
    /**
     * @var
     */
    private $categoryId;

    private $authorId;

    /**
     * @return mixed
     */
    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    /**
     * @param mixed $authorId
     */
    public function setAuthorId($authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }


    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * News constructor.
     */
    public function __construct()
    {
        $this->publishedAt = new DateTime();
    }

    /**
     * @return int | NULL
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return DateTime
     *
     */
    public function getPublishedAt():DateTime
    {
        if(is_string($this->publishedAt))
            $this->publishedAt=new DateTime($this->publishedAt);
        return $this->publishedAt;

    }

    /**
     * @param mixed
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = new DateTime();

    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }


    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }
//metodo donde pasamos los atributos de la entidad para la hora de pasarselo desde el modelo abstracto  desde  la interficie

    public function toArray(): array
    {
        // TODO: Implement toArray() method.

        return ["id" => $this->getId(),
            "title" => $this->getTitle(),
            "publishedAt" => $this->getPublishedAt()->format('Y-m-d'),
            "description" => $this->getDescription(),
            "image" => $this->getImage(),
            "categoryId" => $this->getCategoryId(),
            "authorId" => $this->getAuthorId()
        ];
    }
}