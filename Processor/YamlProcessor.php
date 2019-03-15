<?php

declare(strict_types=1);

namespace Peak\Config\Processor;

use Peak\Blueprint\Common\ResourceProcessor;
use Peak\Config\Exception\ProcessorException;
use Symfony\Component\Yaml\Yaml;

use function class_exists;

class YamlProcessor implements ResourceProcessor
{
    /**
     * @param string $data
     * @return array
     * @throws ProcessorException, ParseException
     */
    public function process($data): array
    {
        if (!class_exists(Yaml::class)) {
            throw new ProcessorException(__CLASS__.' require symfony/yaml to work properly');
        }

        return Yaml::parse($data) ?? [];
    }
}
