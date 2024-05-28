<?php

namespace Runate\TscPrinter;

use Runate\TscPrinter\Base\TSCBase;
use Runate\TscPrinter\Validator\File;
use Runate\TscPrinter\Utilities\System;
use Runate\TscPrinter\Exception\TSCException;
use Runate\TscPrinter\Interface\TSCInterface;

/**
 * Class TSC
 *
 * @package Runate\TscPrinter
 */
class TSC extends TSCBase implements TSCInterface
{
    /**
     * @var string The printer name
     */
    private $printer;

    /**
     * @var string The path to the PDF document
     */
    private $pdf;

    /**
     * @var int Number of copies
     */
    private $copies = 1;

    /**
     * @var string Size of the print
     */
    private $size;

    /**
     * @var string Margins for the print
     */
    private $margins;

    /**
     * @var int Direction of the print
     */
    private $direction;

    /**
     * @var int Scaling factor
     */
    private $scala;

    /**
     * @var int Horizontal offset
     */
    private $shaftX;

    /**
     * @var int Vertical offset
     */
    private $shaftY;

    /**
     * @var int Printing speed
     */
    private $speed;

    /**
     * @var int Printing density
     */
    private $density;

    /**
     * @var string The path to the TSC Python driver
     */
    private string $driver;

    /**
     * @var array List of parameters
     */
    private array $params = ['size', 'margins', 'direction', 'scala', 'shaftX', 'shaftY', 'speed', 'density'];

    /**
     * TSC constructor.
     *
     * @param string $printer The name of the printer
     */
    public function __construct(string $printer)
    {
        // Validate that all dependencies are added.
        System::dependencies();

        // Set printer value.
        $this->printer = trim($printer);

        // Set Driver
        $this->driver = __DIR__ . "/Driver/TSC.py";
    }

    /**
     * Set the path to the PDF document.
     *
     * @param string $path The path to the PDF document
     *
     * @return $this
     * @throws TSCException If the path to the PDF document is not valid
     */
    public function pdf(string $path)
    {
        // $path = str_replace('/', '\\', $path);

        if (!File::exists($path)) {
            throw TSCException::create("No valid path to a PDF document has been defined.");
        }

        $this->pdf = trim($path);

        return $this;
    }

    /**
     * Set the number of copies.
     *
     * @param int $copies Number of copies
     *
     * @return $this
     */
    public function copies(int $copies = 1)
    {
        $this->copies = ($copies <= 0) ? 1 : $copies;

        return $this;
    }

    /**
     * Set the size of the print.
     *
     * @param string $size Size of the print
     *
     * @return $this
     */
    public function size(string $size = "100 mm, 80 mm")
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Set the margins for the print.
     *
     * @param string $margins Margins for the print
     *
     * @return $this
     */
    public function margins(string $margins = "2.5 mm, 0 mm")
    {
        $this->margins = $margins;

        return $this;
    }

    /**
     * Set the direction of the print.
     *
     * @param int $direction Direction of the print
     *
     * @return $this
     */
    public function direction(int $direction = 1)
    {
        $this->direction = ($direction > 2) ? 1 : $direction;

        return $this;
    }

    /**
     * Set the scaling factor.
     *
     * @param int $scala Scaling factor
     *
     * @return $this
     */
    public function scala(int $scala = 100)
    {
        $this->scala = ($scala > 100) ? 100 : $scala;

        return $this;
    }

    /**
     * Set the horizontal offset.
     *
     * @param int $shaftX Horizontal offset
     *
     * @return $this
     */
    public function shaftX(int $shaftX = 50)
    {
        $this->shaftX = $shaftX;

        return $this;
    }

    /**
     * Set the vertical offset.
     *
     * @param int $shaftY Vertical offset
     *
     * @return $this
     */
    public function shaftY(int $shaftY = 0)
    {
        $this->shaftY = $shaftY;

        return $this;
    }

    /**
     * Set the printing speed.
     *
     * @param int $speed Printing speed
     *
     * @return $this
     */
    public function speed(int $speed = 4)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Set the printing density.
     *
     * @param int $density Printing density
     *
     * @return $this
     */
    public function density(int $density = 8)
    {
        $this->density = $density;

        return $this;
    }

    /**
     * Execute the TSC printing command.
     *
     * @throws TSCException If no valid path to a PDF document has been defined
     */
    public function execute()
    {
        if (empty($this->pdf)) {
            throw TSCException::create("No valid path to a PDF document has been defined.");
        }

        $command = sprintf(
            'python "%s" --printer="%s" --pdf="%s" --copies="%d"',
            $this->driver,
            $this->printer,
            $this->pdf,
            $this->copies
        );

        foreach ($this->params as $param) {
            if (!empty($this->{$param})) {
                $command .= sprintf(
                    ' --%s="%s"',
                    $param,
                    $this->{$param}
                );
            }
        }

        $output = shell_exec($command);

        if ($output != 'OK' || $output === null) {
            throw new TSCException("Failed to execute the TSC printing command.");
        }

    }

}
