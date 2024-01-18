<?php

/**
 * Global configuration for TSC printing
 */

return [

    /**
     * Network printer name
     */
    'port' => env("TSC_PRINTER_NAME", null),

    /**
     * GAP label size
     */
    'size' => env("TSC_GAP_SIZE", "100 mm, 80 mm"),

    /**
     * GAP margins
     */
    'margins' => env("TSC_GAP_MARGINS", "2.5 mm, 0 mm"),

    /**
     * Print direction on GAP
     */
    'direction' => env("TSC_DIRECTION_PAGE", 1),

    /**
     * Image size scaling on GAP
     */
    'scale' => env("TSC_SCALE_PDF", 100),

    /**
     * Vanishing point on the X axis
     */
    'vanishingPointX' => env("TSC_VANISHING_POINT_X", 50),

    /**
     * Vanishing point on the Y axis
     */
    'vanishingPointY' => env("TSC_VANISHING_POINT_Y", 0),

    /**
     * Printing speed
     */
    'speed' => env("TSC_SPEED", 4),

    /**
     * Printing density
     */
    'density' => env("TSC_DENSITY", 8),

];
