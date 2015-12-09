<?php

namespace BoxedCode\Silex\Configuration;

/**
 * Interface ParserInterface
 * @package BoxedCode\Silex\Configuration
 */
interface ParserInterface
{
    /**
     * Can this parser support a specific configuration source
     *
     * @param $source
     * @return mixed
     */
    public function supports($source);

    /**
     * Does this parser require a source
     *
     * @return boolean
     */
    public function requiresSource();

    /**
     * Parse the configuration source
     *
     * @param $source
     * @return array
     */
    public function parse($source = null);
}