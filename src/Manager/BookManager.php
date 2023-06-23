<?php

namespace App\Manager;

use App\Entity\Book;
use App\Entity\User;
use App\Repository\BookRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Message;

class BookManager implements ManagerInterface
{
    public function __construct(
        private readonly BookRepository $repository,
        #[Autowire('%app.books_per_page%')]
        private readonly int $booksPerPage,
        private readonly Security $security,
    ) {}

    public function getOne(string $title): Book
    {
        //

        return $this->repository->findOneBy(['title' => $title]);
    }

    public function getList(): iterable
    {
        //

        return $this->repository->findBy([], ['id' => 'DESC'], $this->booksPerPage);
    }

    public function new(Book $book): Book
    {
        if (($user = $this->security->getUser()) instanceof User) {
            $book->setCreatedBy($user);
        }

        $this->repository->save($book, true);

        return $book;
    }
}
