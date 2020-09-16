<?php
namespace App\Entity;

use App\Core\IEntity;

class Category implements IEntity
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $name;

    /**
     * @return int | null
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

//metodo donde pasamos los atributos de la entidad para la hora de pasarselo desde el modelo abstracto  desde  la interficie
    public function toArray(): array
    {
        // TODO: Implement toArray() method.

        return ["id" => $this->getId(),
            "name" => $this->getName()
        ];
    }
}