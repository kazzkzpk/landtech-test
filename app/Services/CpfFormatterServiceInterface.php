<?php
namespace App\Services;

/**
 * Interface CpfFormatterServiceInterface
 * @author Gabriel Morgado <kazzxd1@gmail.com>
 */
interface CpfFormatterServiceInterface
{
    /**
     * Clean non numeric characters, force length to 11 characters and apply mask
     *
     * @param array $cpfs
     * @return array
     */
    public function format(array $cpfs): array;
}
