<?php

namespace LostSpace;

require_once(__DIR__.'/../src/Directory.php');

class DirectoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers LostSpace\Directory::getPath
     * @todo   Implement testGetPath().
     */
    public function testGetPath()
    {
        $path = __DIR__;
        $dir = new Directory($path);
        $this->assertEquals($path, $dir->getPath());
    }

    /**
     * @covers LostSpace\Directory::calculateList
     * @covers LostSpace\Directory::getSize
     * @covers LostSpace\Directory::getList
     * @todo   Implement testGetList().
     */
    public function testGetList()
    {
        $dir = new Directory(__DIR__);
        $this->assertTrue(is_array($list = $dir->getList()));
        $firstItem = current($list);
        $this->assertNotNull($filename = $firstItem['filename']);
        $this->assertNotNull($filetype = $firstItem['filetype']);
        $this->assertNotNull($size = $firstItem['size']);
        $expectedItem = [
            'filename' => $filename,
            'filetype' => $filetype,
            'size' => $size
        ];
        $this->assertEquals($expectedItem, $firstItem);
    }

    /**
     * @covers LostSpace\Directory::getParent
     * @todo   Implement testGetParent().
     */
    public function testGetParent()
    {
        $dir = new Directory(__DIR__);
        $this->assertEquals(dirname(__DIR__), $dir->getParent());
    }

    /**
     * @covers LostSpace\Directory::moveToTrash
     * @todo   Implement testMoveToTrash().
     */
    public function testMoveToTrash()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers LostSpace\Directory::getTrashPath
     * @todo   Implement testGetTrashPath().
     */
    public function testGetTrashPath()
    {
        $dir = new Directory(__DIR__, 'username');
        $this->assertEquals('/Users/username/.Trash/', $dir->getTrashPath());
    }

    /**
     * @covers LostSpace\Directory::getCurrentUser
     * @covers LostSpace\Directory::setCurrentUser
     * @todo   Implement testGetCurrentUser().
     */
    public function testGetAndSetCurrentUser()
    {
        $dir = new Directory(__DIR__, 'username');
        $this->assertEquals('username', $dir->getCurrentUser());
        $dir->setCurrentUser('changedUser');
        $this->assertEquals('changedUser', $dir->getCurrentUser());
    }

    /**
     * @covers LostSpace\Directory::getTotalSize
     * @todo   Implement testGetTotalSize().
     */
    public function testGetTotalSize()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
