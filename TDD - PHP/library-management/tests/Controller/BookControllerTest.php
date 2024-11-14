<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// Classe de test fonctionnel pour le contrôleur BookController.
class BookControllerTest extends WebTestCase // WebTestCase permet de "simuler" les interactions HTTP avec l'application.
{
    // Test création d'un livre
    public function testCreateNewBook()
    {
        // Création d'un client HTTP
        $client = static::createClient();

        // Réception d'une requête GET permettant d'accéder au formulaire de création d'un livre
        $crawler = $client->request('GET', '/books/new');

        // Créer un formulaire avec les données du livre
        // Selection du bouton pour ensuite récupérer le formulaire associé
        $form = $crawler->selectButton('Save')->form([
            'book[title]' => 'Test Book',
            'book[author]' => 'Author Name',
            'book[genre]' => 'Fiction',
            'book[isAvailable]' => true,
        ]);

        // Soumettre le formulaire
        $client->submit($form);

        // Vérifier la redirection après la création
        $this->assertResponseRedirects('/books');

        $client->followRedirect();

        // Vérifie si l'élément avec la classe .book-item est bien présent
        $this->assertSelectorTextContains('.book-item', 'Test Book by Author Name');
    }
}