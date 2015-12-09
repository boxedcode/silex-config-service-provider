<?php

namespace BoxedCode\Silex\Configuration\Parser;

/**
 * Class EnvironmentTest
 *
 * @package BoxedCode\Silex\Configuration\Parser
 */
class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Parser
     *
     * @var Environment
     */
    protected $parser;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->parser = new Environment();
    }

    /**
     * Test that the Environment parser implements the ParserInterface
     */
    public function testImplementsParserInterface()
    {
        $this->assertInstanceOf('\\BoxedCode\\Silex\\Configuration\\ParserInterface', $this->parser);
    }

    /**
     * Test that the parser does not require a source
     */
    public function testDoesNotRequireSource()
    {
        $this->assertFalse($this->parser->requiresSource());
    }

    /**
     * Test that the parser gets its values from the $_SERVER and $_ENV environment variables
     */
    public function testUsesEnvironmentVariables()
    {
        $_SERVER['foo'] = 'bar';
        $_ENV['test'] = 'example';

        $configuration = $this->parser->parse();
        $this->assertArrayHasKey('foo', $configuration);
        $this->assertArrayHasKey('test', $configuration);
    }
}