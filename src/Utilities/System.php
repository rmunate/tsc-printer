<?php

namespace Runate\TscPrinter\Utilities;

use Runate\TscPrinter\Validator\Python;
use Runate\TscPrinter\Validator\Poppler;
use Runate\TscPrinter\Utilities\ArrayFile;
use Runate\TscPrinter\Exception\TSCException;

class System
{
    /**
     * Check and update dependencies for TSC printer management.
     * 
     * @throws TSCException Throws an exception if dependencies are not met.
     */
    public static function dependencies()
    {
        // Get the current configuration from the file
        $currentConfig = (new ArrayFile)->get();

        // Check if all dependencies are already installed
        if (!$currentConfig->OK) {

            // Check for Windows environment
            if (!$currentConfig->windows) {
                if (!strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    throw TSCException::create("The TSC driver can only run on Windows.");
                } else {
                    (new ArrayFile)->update("windows", "true")->put();
                }
            }

            // Check for Python installation
            if (!$currentConfig->python) {
                if (!Python::isInstalled()) {
                    throw TSCException::create("You must have Python installed on your operating system. Visit 'https://www.python.org/'.");
                } else {
                    (new ArrayFile)->update("python", "true")->put();
                }
            }

            // Check for pdf2image Python library
            if (!$currentConfig->pdf2image) {
                if (!Python::library("pdf2image")) {
                    throw TSCException::create("You must have the pdf2image extension installed. Install it with the following command: 'pip install pdf2image Pillow'.");
                } else {
                    (new ArrayFile)->update("pdf2image", "true")->put();
                }
            }

            // Check for Poppler installation
            if (!$currentConfig->poppler) {
                if (!Poppler::isInstalled()) {
                    throw TSCException::create("You must have Poppler installed on your operating system. Visit 'https://github.com/oschwartz10612/poppler-windows/releases'.");
                } else {
                    (new ArrayFile)->update("poppler", "true")->put();
                }
            }

            // Update the general OK status in the configuration file
            (new ArrayFile)->update("OK", "true")->put();
        }
    }
}
