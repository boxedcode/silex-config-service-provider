<?php

namespace BoxedCode\Silex\Configuration;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ConfigServiceProvider
 *
 * @package BoxedCode\Silex
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * Source of the configuration
     * Can be an array or a single source
     *
     * @var mixed
     */
    protected $source;

    /**
     * Parsers
     *
     * @var ParserInterface[]
     */
    protected $parsers = [
        'sourced' => [],
        'unsourced' => []
    ];

    /**
     * The parsed configuration
     *
     * @var array
     */
    protected $configuration = [];


    /**
     * ConfigServiceProvider constructor.
     *
     * @param mixed $source
     * @param bool $useBundledParsers
     */
    public function __construct($source = null, $useBundledParsers = true)
    {
        $this->source = $source;
        if ($useBundledParsers) {
            $this->loadBundledParsers();
        }
    }

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $this->loadSourcedParsers();
        $this->loadUnsourcedParsers();

        $this->initialiseReader($pimple);
    }

    /**
     * Set custom parsers.
     * Can be objects or an array of namespaced classes that implement ParserInterface
     *
     * @param ParserInterface[] $parsers
     */
    public function setParsers(array $parsers)
    {
        foreach ($parsers as $parser) {
            $object = $parser;
            if (!is_object($object)) {
                $object = new $parser();
            }
            if (!($object instanceof ParserInterface)) {
                throw new \InvalidArgumentException('Custom parsers must implement BoxedCode\Silex\Configuration\ParserInterface');
            }
            if ($object->requiresSource()) {
                $this->parsers['sourced'][] = $object;
            } else {
                $this->parsers['unsourced'][] = $object;
            }
        }
    }

    /**
     * Load parsers which require a source
     */
    protected function loadSourcedParsers()
    {
        if (isset($this->source)) {
            if (is_array($this->source)) {
                foreach ($this->source as $single) {
                    $this->process($single);
                }
            } else {
                $this->process($this->source);
            }
        }
    }

    /**
     * Load unsourced parsers
     */
    protected function loadUnsourcedParsers()
    {
        foreach ($this->parsers['unsourced'] as $parser) {
            $this->configuration = array_merge($this->configuration, $parser->parse());
        }
    }

    /**
     * Initialise the reader
     *
     * @param Container $pimple
     */
    protected function initialiseReader(Container $pimple)
    {
        $pimple['config.reader'] = new Reader($this->configuration);
    }

    /**
     * Load bundled parsers
     */
    private function loadBundledParsers()
    {
        $fileSystemIterator = new \FilesystemIterator(__DIR__ . '/Parser', \FilesystemIterator::SKIP_DOTS);

        foreach ($fileSystemIterator as $fileInfo) {
            $file = $fileInfo->getRealPath();
            $class = sprintf('\BoxedCode\Silex\Configuration\Parser\%s', $this->getClassFromFile($file));
            $object = new $class();
            $this->parsers[] = $object;
        }
    }

    /**
     * Process a configuration source
     *
     * @param $source
     */
    private function process($source)
    {
        foreach ($this->parsers['sourced'] as $parser) {
            if ($parser->supports($source)) {
                $this->configuration = array_merge($this->configuration, $parser->parse($source));
            }
        }
    }

    /**
     * Extract a class name from a file
     *
     * @param $file
     * @return mixed
     */
    private function getClassFromFile($file)
    {
        $contents = file_get_contents($file);
        $tokens = token_get_all($contents);
        $class_token = false;

        foreach ($tokens as $token) {
            if (is_array($token)) {
                if (T_CLASS == $token[0]) {
                    $class_token = true;
                } else {
                    if ($class_token && T_STRING == $token[0]) {
                        return $token[1];
                    }
                }
            }
        }
    }
}