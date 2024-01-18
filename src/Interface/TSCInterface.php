<?php

namespace Runate\TscPrinter\Interface;

use Runate\TscPrinter\Exception\TSCException;

/**
 * Interface for TSC Printer.
 */
interface TSCInterface
{
    /**
     * Set the path to the PDF document.
     *
     * @param string $path The path to the PDF document
     *
     * @return TSCInterface
     * @throws TSCException If the path to the PDF document is not valid
     */
    public function pdf(string $path);

    /**
     * Set the number of copies.
     *
     * @param int $copies Number of copies
     *
     * @return TSCInterface
     */
    public function copies(int $copies = 1);

    /**
     * Set the size of the print.
     *
     * @param string $size Size of the print
     *
     * @return TSCInterface
     */
    public function size(string $size = "100 mm, 80 mm");

    /**
     * Set the margins for the print.
     *
     * @param string $margins Margins for the print
     *
     * @return TSCInterface
     */
    public function margins(string $margins = "2.5 mm, 0 mm");

    /**
     * Set the direction of the print.
     *
     * @param int $direction Direction of the print
     *
     * @return TSCInterface
     */
    public function direction(int $direction = 1);

    /**
     * Set the scaling factor.
     *
     * @param int $scala Scaling factor
     *
     * @return TSCInterface
     */
    public function scala(int $scala = 100);

    /**
     * Set the horizontal offset.
     *
     * @param int $shaftX Horizontal offset
     *
     * @return TSCInterface
     */
    public function shaftX(int $shaftX = 50);

    /**
     * Set the vertical offset.
     *
     * @param int $shaftY Vertical offset
     *
     * @return TSCInterface
     */
    public function shaftY(int $shaftY = 0);

    /**
     * Set the printing speed.
     *
     * @param int $speed Printing speed
     *
     * @return TSCInterface
     */
    public function speed(int $speed = 4);

    /**
     * Set the printing density.
     *
     * @param int $density Printing density
     *
     * @return TSCInterface
     */
    public function density(int $density = 8);

    /**
     * Execute the TSC printing command.
     *
     * @return mixed
     * @throws TSCException If no valid path to a PDF document has been defined
     */
    public function execute();
}
