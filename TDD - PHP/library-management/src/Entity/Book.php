<?php

namespace App\Entity;

// Utilisation de ORM pour faire une table dans la base de données
use Doctrine\ORM\Mapping as ORM;

// Classe permettant de faire une table dans la base de données
#[ORM\Entity]
class Book
{
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue] // Equivaut à l'AUTO_INCREMENT
    #[ORM\Id] // Permet de dire que c'est une clé primaire
    private int $id;

    // Titre du livre
    #[ORM\Column(type: "string", length: 255)]
    private string $title;

    // Auteur du livre
    #[ORM\Column(type: "string", length: 255)]
    private string $author;

    // Genre du livre
    #[ORM\Column(type: "string", length: 100)]
    private string $genre;

    // Savoir s'il est disponible à l'emprunt
    #[ORM\Column(type: "boolean")]
    private bool $isAvailable = true;

    /**
     * Returns the book ID
     *
     * @return int Id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the book title
     *
     * @return string Title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the book title
     *
     * @param string $title Book title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns the book author
     *
     * @return string Book author
     */

    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Set the book author
     *
     * @param string $author Book author
     * @return $this
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Returns the book genre
     *
     * @return string Book genre
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * Set the book genre
     *
     * @param string $genre Book genre
     *
     * @return $this
     */
    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * Returns if the book is available
     *
     * @return bool Is available
     */
    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    /**
     * Set if the book is available
     *
     * @param bool $isAvailable Is available
     * @return $this
     */
    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;
        return $this;
    }
}