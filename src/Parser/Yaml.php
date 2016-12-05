<?php

namespace BoxedCode\Silex\Configuration\Parser;

use BoxedCode\Silex\Configuration\ParserInterface;

/**
 * Class Yaml
 *
 * @package BoxedCode\Silex\Configuration\Parser
 */
class Yaml implements ParserInterface
{
    /**
     * Parsed configuration
     *
     * @var array
     */
    protected $configuration = [];

    /**
     * Can this parser support a specific configuration source
     *
     * @param $source
     * @return mixed
     */
    public function supports($source)
    {
        if (is_string($source) && file_exists($source) && ('yml' === pathinfo($source, PATHINFO_EXTENSION))) {
            return true;
        }

        return false;
    }

    /**
     * Does this parser require a source
     *
     * @return boolean
     */
    public function requiresSource()
    {
        return true;
    }

    /**
     * Parse the configuration source
     *
     * @param $source
     * @return array
     */
    public function parse($source = null)
    {
        $this->configuration = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($source));

        if (is_array($this->configuration)) {
            $this->processImports($this->configuration, $source);
        }

        return $this->configuration;
    }

    /**
     * Process any imports
     *
     * @param array $configuration
     * @param $source
     */
    protected function processImports(array &$configuration, $source)
    {
        foreach ($configuration as $key => $value) {
            if ($key == 'imports') {
                foreach ($value as $resource) {
                    $basePath = str_replace(basename($source), '', $source);
                    $parser = new Yaml();
                    $this->configuration = array_merge($parser->parse($basePath . $resource['resource']),
                        $configuration);
                }
                unset($configuration['imports']);
            }
        }
    }
}