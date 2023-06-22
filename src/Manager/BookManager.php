<?php

namespace App\Manager;

use App\Entity\Book;
use App\Repository\BookRepository;
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
        #[Autowire(service: 'mailer.mailer')]
        private readonly MailerInterface $mailer,
    ) {}

    public function getOne(string $title): Book
    {
        //

        return $this->repository->findOneBy(['title' => $title]);
    }

    public function getList(): iterable
    {
        //

        $this->mailer->send(new Message());
        return $this->repository->findBy([], ['id' => 'DESC'], $this->booksPerPage);
    }
}
