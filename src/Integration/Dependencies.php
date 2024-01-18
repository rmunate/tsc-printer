<?php

/**
 * Package dependencies for TSC printer management.
 */
return [

    /**
     * Indicates whether all dependencies are installed.
     */
    'OK' => true,

    /**
     * Indicates whether the system is running on Windows.
     */
    'windows' => true,

    /**
     * PYTHON
     * 
     * Install version 3 or higher.
     * << https://www.python.org/ >>
     */
    'python' => true,

    /**
     * PDF2IMAGE
     * 
     * Install the dependency using:
     * << pip install pdf2image Pillow >>
     * Dependency for Python
     */
    'pdf2image' => true,

    /**
     * POPPLER
     * 
     * Install the dependency:
     * https://github.com/oschwartz10612/poppler-windows/releases
     * Then, create an environment variable in the "path" for the poppler bin folder.
     */
    'poppler' => true,

];
