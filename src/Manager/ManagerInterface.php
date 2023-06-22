<?php

namespace App\Manager;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.manager')]
interface ManagerInterface
{
    public function getOne(string $title): object;

    public function getList(): iterable;
}
