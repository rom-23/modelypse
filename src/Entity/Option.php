<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OptionRepository")
 * @ORM\Table(name="`option`")
 */
class Option
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Model", mappedBy="options")
     */
    private $models;

    /**
     * Option constructor.
     */
    public function __construct()
    {
        $this -> models = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Model[]
     */
    public function getModels(): Collection
    {
        return $this -> models;
    }

    public function addModel( Model $model ): self
    {
        if(!$this -> models -> contains( $model )) {
            $this -> models[] = $model;
        }

        return $this;
    }

    public function removeModel( Model $model ): self
    {
        if($this -> models -> contains( $model )) {
            $this -> models -> removeElement( $model );
        }

        return $this;
    }
}
