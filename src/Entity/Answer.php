<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 */
class Answer
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
    private $Ans;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $Color;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question")
     */
    private $Question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAns(): ?string
    {
        return $this->Ans;
    }

    public function setAns(?string $Ans): self
    {
        $this->Ans = $Ans;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(?string $Color): self
    {
        $this->Color = $Color;

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
