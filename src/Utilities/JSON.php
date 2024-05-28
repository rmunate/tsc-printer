<?php

namespace Runate\TscPrinter\Utilities;

class JSON
{
    /**
     * Create an object from the supplied array data.
     *
     * @param array $data The array data to be converted to an object.
     *
     * @return object Returns an object created from the input array data.
     */
    public static function parse(array $data)
    {
        return json_decode(json_encode($data), false);
    }
}
