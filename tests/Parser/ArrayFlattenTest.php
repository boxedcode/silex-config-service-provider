<?php

namespace BoxedCode\Silex\Configuration\Parser;

/**
 * Class ArrayFlattenTest
 *
 * @package BoxedCode\Silex\Configuration\Parser
 */
class ArrayFlattenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Parser
     *
     * @var ArrayFlatten
     */
    protected $parser;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->parser = new ArrayFlatten();
    }

    /**
     * Test that the ArrayFlatten parser implements the ParserInterface
     */
    public function testImplementsParserInterface()
    {
        $this->assertInstanceOf('\\BoxedCode\\Silex\\Configuration\\ParserInterface', $this->parser);
    }

    /**
     * Test that the ArrayFlatten parser can support an array
     */
    public function testCanSupportArray()
    {
        $this->assertTrue($this->parser->supports([
            'key' => 'value'
        ]));
    }

    /**
     * Test that the ArrayFlatten parser correctly flattens a multi-dimensional array
     */
    public function testParsesArrayCorrectly()
    {
        $configuration = [
            'application' => [
                'name' => 'Test Application',
                'location' => 'Europe'
            ],
            'image' => [
                'dimensions' => [
                    'thumb' => '60x60',
                    'large' => '600x600',
                ]
            ]
        ];

        $flattenedConfiguration = [
            'application.name' => 'Test Application',
            'application.location' => 'Europe',
            'image.dimensions.thumb' => '60x60',
            'image.dimensions.large' => '600x600',
        ];

        $this->assertEquals($flattenedConfiguration, $this->parser->parse($configuration));
    }
}