<?php

namespace App\Services;

/**
 * Class CatalogServiceFactory
 * @author Gabriel Morgado <kazzxd1@gmail.com>
 */
class CpfFormatterServiceFactory
{
    public function __invoke(): CpfFormatterServiceInterface
    {
        return new CpfFormatterService();
    }
}
