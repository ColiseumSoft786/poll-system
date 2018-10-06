<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Statment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatment(): ?string
    {
        return $this->Statment;
    }

    public function setStatment(?string $Statment): self
    {
        $this->Statment = $Statment;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }
}
