<?php


namespace ScAnalytics\Core;


use ScAnalytics\Tests\Core\AParameterTest;

/**
 * Class AParameter. This class represents a parameter, which can be used to specify the type of information sent to the analytics handler.
 *
 * @author Jan-Nicklas Adler
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 * @copyright All Rights Reserved.
 * @see AParameterTest phpunit test
 */
abstract class AParameter
{

    /**
     * @var string Name of the parameter
     */
    private $name;
    /**
     * Indizes are used for parameters containing an index in the key. For example: product1, product2, ...
     *
     * @var int The next index to use with parameters
     */
    private $index;

    /**
     * GAParameter constructor.
     * @param string $name Name of the parameter
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->index = 1;
    }

    /**
     * @return string The name of the parameter
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Modifies the parameter with a custom value. Only works on supported parameters. It is intended to chain multiple parameters like follows: <code> $para->withValue("ab")->withValue("cd")</code>.
     * The first call of <code>withValue</code> on a parameter object will always clone it. The second call will <b>not</b> clone it.
     *
     * @param string|int|bool|float|null $value value to insert
     * @return $this An AParameter object
     */
    public function withValue($value): AParameter
    {
        $obj = $this->index === 1 ? clone $this : $this;
        $obj->name = str_replace("%p" . $obj->index . "%", is_null($value) ? "" : (string)$value, $obj->name);
        $obj->index++;
        return $obj;
    }

}