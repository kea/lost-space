<?php

namespace LostSpace;

require_once(__DIR__.'/../src/FlashBag.php');

class FlashBagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FlashBag
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new FlashBag;
    }

    /**
     * @covers LostSpace\FlashBag::add
     * @covers LostSpace\FlashBag::get
     * @todo   Implement testAdd().
     */
    public function testAddAndGet()
    {
        $this->object->add('testKey', 'testValue');
        $this->assertEquals(['testValue'], $this->object->get('testKey'));
        $this->object->add('testKey', 'testValue2');
        $this->assertEquals(['testValue', 'testValue2'], $this->object->get('testKey'));
        $this->assertEquals(['testValue', 'testValue2'], $this->object->get('testKey'));
        $this->assertEquals(null, $this->object->get('testEmptyKey'));
    }

    /**
     * @covers LostSpace\FlashBag::has
     * @todo   Implement testHas().
     */
    public function testHas()
    {
        $this->assertEquals(false, $this->object->has('testKey'));
        $this->object->add('testKey', 'testValue');
        $this->assertEquals(true, $this->object->has('testKey'));
        $this->object->add('testKey', 'testValue2');
        $this->assertEquals(true, $this->object->has('testKey'));
    }
}
