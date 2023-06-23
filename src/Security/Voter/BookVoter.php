<?php

namespace App\Security\Voter;

use App\Entity\Book;
use Container3AsIJMN\getDebug_FileLinkFormatter_UrlFormatService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BookVoter extends Voter
{
    public const VIEW = 'book.view';
    public const EDIT = 'book.edit';

    public function __construct(private AuthorizationCheckerInterface $checker) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject instanceof Book
            && \in_array($attribute, [self::VIEW, self::EDIT]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->checker->isGranted('ROLE_ADMIN')) {
            return true;
        }

        /** @var Book $subject */
        return match ($attribute) {
            self::VIEW => true,
            self::EDIT => $subject->getCreatedBy() === $token->getUser(),
            default => false,
        };
    }
}
