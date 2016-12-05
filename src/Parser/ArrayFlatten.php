<?php

namespace BoxedCode\Silex\Configuration\Parser;

use BoxedCode\Silex\Configuration\ParserInterface;

/**
 * Class ArrayFlatten
 *
 * @package BoxedCode\Silex\Configuration\Parser
 */
class ArrayFlatten implements ParserInterface
{
    /**
     * Can this parser support a specific configuration source
     *
     * @param $source
     * @return mixed
     */
    public function supports($source)
    {
        if (is_array($source)) {
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
        return $this->flattenArray($source);
    }

    /**
     * Flatten an array
     *
     * @param $source
     * @param string $prefix
     * @return array
     */
    private function flattenArray($source, $prefix = '')
    {
        $result = [];

        foreach ($source as $key => $value) {
            $newKey = $prefix . (empty($prefix) ? '' : '.') . $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }
}