<?php

namespace Runate\TscPrinter\Validator;

class Poppler
{
    /**
     * Check if pdftoppm utility is installed.
     * 
     * @return bool Returns true if pdftoppm is installed, otherwise false.
     */
    public static function isInstalled()
    {
        try {
            $output = shell_exec("pdftoppm -v 2>&1");

            if ($output === null) {
                return false;
            }

            return (strpos($output, 'pdftoppm') !== false);

        } catch (\Throwable $th) {
            
            return false;
        }
    }
}
