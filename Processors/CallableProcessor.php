<?php

declare(strict_types=1);

namespace Peak\Config\Processors;

use Peak\Config\Exceptions\ProcessorException;
use Peak\Config\ProcessorInterface;

class CallableProcessor implements ProcessorInterface
{
    /**
     * Process
     * @throws ProcessorException
     */
    public function process($data): array
    {
        if (!is_callable($data)) {
            throw new ProcessorException(__CLASS__.' expects data to be callable. '.gettype($data).' given.');
        }

        $content = $data();

        if (!is_array($content)) {
            throw new ProcessorException(__CLASS__.' expects callable data to return an array');
        }

        return $content;
    }
}
