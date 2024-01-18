<?php

namespace Runate\TscPrinter\Utilities;

use Runate\TscPrinter\Utilities\JSON;
use Runate\TscPrinter\Validator\File;
use Runate\TscPrinter\Exception\TSCException;

class ArrayFile
{
    /**
     * @var string The content of the stub file.
     */
    private $stub;

    /**
     * Constructor: Initializes the class by loading the content of the stub file.
     */
    public function __construct()
    {
        $this->stub = file_get_contents(__DIR__ . "/../Integration/Dependencies.php");
    }

    /**
     * Update placeholder values in the stub.
     * 
     * @param string|array $find The placeholder(s) to find in the stub.
     * @param string|array $value The value(s) to replace the placeholder(s) with.
     * 
     * @return $this Returns the current instance for method chaining.
     */
    public function update($find, $value)
    {
        $this->stub = preg_replace("/'{$find}' =>\s*(true|false)/", "'{$find}' => {$value}", $this->stub);

        return $this;
    }

    /**
     * Write the updated stub to a file.
     * 
     * @return bool|int Returns the number of bytes written to the file on success, or false on failure.
     */
    public function put()
    {
        return file_put_contents(__DIR__. "/../Integration/Dependencies.php", $this->stub);
    }

    /**
     * Get the current configuration from the integration file.
     *
     * @return array The current configuration array.
     */
    public function get()
    {
        $data = require(__DIR__ . "/../Integration/Dependencies.php");

        return JSON::parse($data);
    }
}