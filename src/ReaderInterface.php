<?php

namespace BoxedCode\Silex\Configuration;

/**
 * Interface ReaderInterface
 *
 * @package BoxedCode\Silex\Configuration
 */
interface ReaderInterface
{
    /**
     * Find a configuration value by key
     *
     * @param string $key
     * @return mixed
     */
    public function find($key);

    /**
     * Determine if a configuration key exists
     *
     * @param string $key
     * @return boolean
     */
    public function has($key);

    /**
     * Set the configuration for this reader
     *
     * @param array $configuration
     * @return mixed
     */
    public function setConfiguration(array $configuration);
}