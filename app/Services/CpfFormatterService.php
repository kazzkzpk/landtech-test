<?php

namespace App\Services;

/**
 * Class CpfFormatterService
 * @author Gabriel Morgado <kazzxd1@gmail.com>
 */
class CpfFormatterService implements CpfFormatterServiceInterface
{
    /**
     * @inheritdoc
     */
    public function format(array $cpfs): array
    {
        /**
         * array<int, string>
         */
        $cpfsFormatted = [];

        foreach ($cpfs as $cpf) {
            $cpf = $this->clean($cpf);
            $cpf = $this->forceLength($cpf);
            $cpfsFormatted[] = $this->mask($cpf);
        }

        return $cpfsFormatted;
    }

    /**
     * Clean CPF non numeric characters
     *
     * @param string $cpf
     * @return string
     */
    protected function clean(string $cpf): string
    {
        return preg_replace('/[^0-9]/', '', $cpf);
    }

    /**
     * Force CPF length to 11 characters (add zeros at left)
     *
     * @param string $cpf
     * @return string
     */
    protected function forceLength(string $cpf): string
    {
        $cpfLength = strlen($cpf);

        while ($cpfLength < 11) {
            $cpf = ('0' . $cpf);
            $cpfLength = strlen($cpf);
        }

        return $cpf;
    }

    /**
     * Apply CPF mask
     *
     * @param string $cpf
     * @return string
     */
    protected function mask(string $cpf): string
    {
        return (
            substr($cpf, 0, 3) . '.' .
            substr($cpf, 3, 3) . '.' .
            substr($cpf,6, 3) . '-' .
            substr($cpf,9, 2)
        );
    }
}
