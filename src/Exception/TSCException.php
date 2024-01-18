<?php

namespace Runate\TscPrinter\Exception;

use Exception;

class TSCException extends Exception
{
    /**
     * Create an exception for the package.
     * 
     * @param string $message The error message.
     * @param int $code The error code (default: 500).
     * 
     * @return self
     */
    public static function create(string $message, int $code = 500)
    {
        return new self("TSCException - {$message}", $code);
    }
}
