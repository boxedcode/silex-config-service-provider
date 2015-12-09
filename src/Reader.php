<?php

namespace BoxedCode\Silex\Configuration;

/**
 * Class Reader
 *
 * @package BoxedCode\Silex\Configuration
 */
class Reader implements ReaderInterface
{
    /**
     * Configuration
     *
     * @var array
     */
    protected $configuration;

    /**
     * Reader constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Find a configuration value by key
     *
     * @param string $key
     * @return mixed
     */
    public function find($key)
    {
        if (!array_key_exists($key, $this->configuration)) {
            throw new \InvalidArgumentException("Unknown configuration parameter with key: " . $key);
        }

        return $this->configuration[$key];
    }

}