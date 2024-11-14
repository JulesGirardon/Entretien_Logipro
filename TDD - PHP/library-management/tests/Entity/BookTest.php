<?php

namespace App\Tests\Entity;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testSettersAndGetters()
    {
        // Créer une instance de l'entité Book
        $book = new Book();

        // Tester le setter et getter pour le titre
        $book->setTitle('1984');
        $this->assertEquals('1984', $book->getTitle());

        // Tester le setter et getter pour l'auteur
        $book->setAuthor('George Orwell');
        $this->assertEquals('George Orwell', $book->getAuthor());

        // Tester le setter et getter pour le genre
        $book->setGenre('Dystopian');
        $this->assertEquals('Dystopian', $book->getGenre());

        // Tester le setter et getter pour la disponibilité
        $book->setIsAvailable(true);
        $this->assertTrue($book->isAvailable());

        // Tester que la modification de la disponibilité fonctionne aussi
        $book->setIsAvailable(false);
        $this->assertFalse($book->isAvailable());
    }
}