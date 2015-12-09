<?php

namespace BoxedCode\Silex\Configuration\Parser;

use BoxedCode\Silex\Configuration\ParserInterface;

/**
 * Class Environment
 * A parser that returns the contents of the $_SERVER and $_ENV environment variables
 *
 * @package BoxedCode\Silex\Configuration\Parser
 */
class Environment implements ParserInterface
{
    /**
     * Can this parser support a specific configuration source
     *
     * @param $source
     * @return mixed
     */
    public function supports($source)
    {
        return false;
    }

    /**
     * Does this parser require a source
     *
     * @return boolean
     */
    public function requiresSource()
    {
        return false;
    }

    /**
     * Parse the configuration source
     *
     * @param $source
     * @return array
     */
    public function parse($source = null)
    {
        return ($_SERVER + $_ENV);
    }

}