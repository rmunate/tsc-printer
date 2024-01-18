<?php

namespace Runate\TscPrinter\Validator;

class Python
{
    /**
     * Check if Python is installed on the machine.
     * 
     * @return bool Returns true if Python is installed, otherwise false.
     */
    public static function isInstalled()
    {
        try {
            $pythonVersion = shell_exec("python --version 2>&1");

            if ($pythonVersion === null) {
                return false;
            }

            return (strpos($pythonVersion, 'Python') !== false);

        } catch (\Throwable $th) {

            return false;
        }
    }

    /**
     * Check if a Python library is installed.
     * 
     * @param string $name The name of the Python library to check.
     * 
     * @return bool Returns true if the library is installed, otherwise false.
     */
    public static function library(string $name)
    {
        try {
            $libraryInfo = shell_exec("pip show {$name} Pillow 2>&1");

            if ($libraryInfo === null) {

                return false;
            }

            return (strpos($libraryInfo, $name) !== false);

        } catch (\Throwable $th) {

            return false;
        }
    }
}
