<?php

namespace Runate\TscPrinter\Validator;

class File
{
    /**
     * Check if a file exists.
     *
     * @param string $path The path to the file.
     *
     * @return bool Returns true if the file exists, otherwise false.
     */
    public static function exists(string $path)
    {
        $path = trim($path);

        if (empty($path)) {
            return false;
        }

        return file_exists($path);
    }
}
