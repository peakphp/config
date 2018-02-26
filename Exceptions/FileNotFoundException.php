<?php

namespace Peak\Config\Exceptions;

class FileNotFoundException extends \Exception
{
    /**
     * UnknownTypeException constructor.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        parent::__construct('Config file '.$file.' not found');
    }
}
