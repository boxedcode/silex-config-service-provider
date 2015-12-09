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
}