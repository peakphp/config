<?php

declare(strict_types=1);

namespace Peak\Config\Stream;

use Peak\Config\Config;

class ConfigStream implements StreamInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * ConfigStream constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->config->toArray();
    }
}
