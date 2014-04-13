<?php

namespace LostSpace;

require_once(__DIR__.'/../src/ViewHelper.php');

class ViewHelperTest extends \PHPUnit_Framework_TestCase
{
    public function humanSizeProvider()
    {
        return [
            [10, '10K'],
            [1023, '1023K'],
            [1024, '1M'],
            [15*1024, '15M'],
            [20*1024*1024, '20G'],
            [25*1024*1024*1024, '25T'],
        ];
    }

    /**
     * @covers LostSpace\ViewHelper::humanSize
     * @dataProvider humanSizeProvider
     */
    public function testHumanSize($size, $humanSize)
    {
        $this->assertEquals($humanSize, ViewHelper::humanSize($size));
    }
}
