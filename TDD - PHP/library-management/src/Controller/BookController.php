<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController // AbstractController permet la génération de vues et la gestion de redirections
{
    // Affiche tous les livres
    #[Route("/books", name: "book_index")]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupère tous les livres de la base de données
        $books = $em->getRepository(Book::class)->findAll();

        // Rendre la vue avec les livres
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route("/books/list", name: "book_list")]
    public function list(EntityManagerInterface $em): Response
    {
        // Récupère tous les livres de la base de données
        $books = $em->getRepository(Book::class)->findAll();

        // Rendre la vue avec les livres
        return $this->render('book/list.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route("/books/new", name: "book_new")]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // Crée une nouvelle instance de Book
        $book = new Book();

        // Crée un formulaire avec le type BookType
        $form = $this->createForm(BookType::class, $book);

        // Traite la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistre le livre dans la base de données
            $em->persist($book);
            $em->flush();

            // Redirige l'utilisateur vers la page d'index des livres
            return $this->redirectToRoute('book_index');
        }

        // Rendre la vue avec le formulaire
        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/books/{id}", name: "book_show")]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        // Récupère le livre par son ID
        $book = $em->getRepository(Book::class)->find($id);

        // Si le livre n'existe pas, on génère une page 404
        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        // Rendre la vue pour afficher le livre
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}
