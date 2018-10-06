<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InfoRepository")
 */
class Info
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $Email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Answer")
     */
    private $Answer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question")
     */
    private $Question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->Answer;
    }

    public function setAnswer(?Answer $Answer): self
    {
        $this->Answer = $Answer;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->Question;
    }

    public function setQuestion(?Question $Question): self
    {
        $this->Question = $Question;

        return $this;
    }
}
