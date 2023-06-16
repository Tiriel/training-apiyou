<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $repository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $repository->findAll(),
        ]);
    }

    #[Route('/{id<\d+>?1}', name: 'app_book_show', methods: ['GET', 'POST'])]
    //#[Route('/show/{id}', name: 'app_book_show', requirements: ['id' => '\d+'], defaults: ['id' => 1])]
    public function show(int $id, BookRepository $repository): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $repository->find($id),
        ]);
    }
}
