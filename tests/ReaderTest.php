<?php

namespace BoxedCode\Silex\Configuration;

/**
 * Class ReaderTest
 *
 * @package BoxedCode\Silex\Configuration
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that it implements the reader interface
     */
    public function testImplementsReaderInterface()
    {
        $reader = new Reader([]);
        $this->assertInstanceOf('\\BoxedCode\\Silex\\Configuration\\ReaderInterface', $reader);
    }

    /**
     * Test that the reader can read configuration
     */
    public function testCanReadConfiguration()
    {
        $reader = new Reader([
            'foo' => 'bar'
        ]);

        $this->assertNotEmpty($reader->find('foo'));
    }

    /**
     * Test that the reader throws an exception for an invalid configuration key
     *
     * @expectedException \InvalidArgumentException
     */
    public function testReaderThrowsExceptionOnInvalidConfigurationKey()
    {
        $reader = new Reader([]);
        $reader->find('test');
    }

    /**
     * Test that the "has" method behaves as expected
     */
    public function testHas()
    {
        $reader = new Reader([]);
        $this->assertFalse($reader->has('foo'));
    }
}