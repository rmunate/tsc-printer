<?php

namespace Runate\TscPrinter\Base;

use Runate\TscPrinter\Utilities\JSON;
use Runate\TscPrinter\Validator\File;
use Runate\TscPrinter\Exception\TSCException;

class TSCBase
{
    /**
     * Initialize the service indicating the printer to use.
     *
     * @param string $name The name of the printer.
     *
     * @return static
     * @throws TSCException Throws an exception if no valid printer name is defined.
     */
    public static function printer(string $name)
    {
        if (empty($name)) {
            throw TSCException::create("No valid printer name has been defined.");
        }

        return new static(trim($name));
    }

}
