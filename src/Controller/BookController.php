<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class BookController extends AbstractController
{
    #[Route('/books', name: 'create_book', methods: ['POST'])]
public function createBook(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $book = new Book();
        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->json(['message' => 'Book created', 'id' => $book->getId()]);
    }
    #[Route('/books', name: 'get_book', methods: ['GET'])]
public function getBooks(EntityManagerInterface $entityManager): JsonResponse
    {
        $books = $entityManager->getRepository(Book::class)->findAll();
        return $this->json(['books' => $books]);
    }
    #[Route('/books/{id}', name: 'get_book', methods: ['GET'])]
public function getBook(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['message' => 'Book not found'], 404);
        }

        return $this->json($book);
    }
    #[Route('/books/{id}', name: 'update_book', methods: ['PUT'])]
public function updateBook(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse{

        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['message' => 'Book not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);

        $entityManager->flush();
        return $this->json(['message' => 'Book updated', 'id' => $book->getId()]);
    }

    #[Route('/books/{id}', name: 'delete_book', methods: ['DELETE'])]
public function deleteBook(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            return $this->json(['message' => 'Book not found'], 404);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json(['message' => 'Book deleted']);
    }


}
