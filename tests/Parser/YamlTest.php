<?php

namespace BoxedCode\Silex\Configuration\Parser;

use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlTest
 *
 * @package tests\BoxedCode\Silex\Configuration\Parser
 */
class YamlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Parser
     *
     * @var \BoxedCode\Silex\Configuration\Parser\Yaml
     */
    protected $parser;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->parser = new \BoxedCode\Silex\Configuration\Parser\Yaml();
    }

    /**
     * Test that the Yaml parser implements the ParserInterface
     */
    public function testImplementsParserInterface()
    {
        $this->assertInstanceOf('\\BoxedCode\\Silex\\Configuration\\ParserInterface', $this->parser);
    }

    /**
     * Test that the Yaml parser can support Yaml files
     */
    public function testCanSupportYamlFile()
    {
        $this->assertTrue($this->parser->supports(__DIR__ . '/../resource/test_config_a.yml'));
    }

    /**
     * Test that a yaml configuration file without imports is parsed correctly
     */
    public function testParsesNonImportFileCorrectly()
    {
        $configuration = Yaml::parse(file_get_contents(__DIR__ . '/../resource/test_config_a.yml'));
        $this->assertEquals($configuration, $this->parser->parse(__DIR__ . '/../resource/test_config_a.yml'));
    }

    /**
     * Test that a yaml configuration file with imports is parsed correctly
     */
    public function testParsesImportFileCorrectly()
    {
        $this->assertEquals([
            'swiftmailer' => [
                'host' => 'smtp.example.com',
                'port' => 999,
                'username' => 'test',
                'password' => 'user',
                'encryption' => false,
                'auth_mode' => ''
            ],
            'application' => [
                'name' => 'Test Application',
                'defaults' => [
                    'page_title' => 'Welcome to Test Application',
                    'page_description' => 'Welcome to Test Application',
                ],
                'domain' => 'example.com'
            ]
        ], $this->parser->parse(__DIR__ . '/../resource/test_config_b.yml'));
    }
}