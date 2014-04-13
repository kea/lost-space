<?php

namespace LostSpace;

class Directory
{
    private $currentUser;
    private $path;
    private $totalSize = 0;

    /**
     * get the file size in Kb
     */
    protected function getSize($name)
    {
        $path = $this->path.'/'.$name;
        $type = filetype($path);
        if ($type == 'link') {
            return 0;
        }

        if ($type != 'dir') {
            return filesize($path) / 1024;
        }

        $io = popen('/usr/bin/du -sk '.escapeshellarg($path), 'r');
        $size = fgets($io, 4096);
        $size = substr($size, 0, strpos($size, "\t"));
        pclose($io);

        return $size;
    }

    protected function calculateList()
    {
        $list = [];
        if ($dir = dir($this->path)) {
            while (($file = $dir->read()) !== false) {
                if ($file == '..') {
                    continue;
                }

                $filename = $file;
                $filetype = filetype($this->path .'/'. $file);
                $size = $this->getSize($file);

                if ($file == '.') {
                    $filename = 'Total';
                    $filetype = 'grand-total';
                    $this->totalSize = $size;
                }

                $list[] = [
                    'filename' => $filename,
                    'filetype' => $filetype,
                    'size' => $size
                ];
            }
            $dir->close();
        }

        usort($list, function($a, $b) {
            return $a['size'] < $b['size'];
        });
        $this->list = $list;
    }

    public function __construct($path, $currentUser = null)
    {
        $this->path = $path;
        $this->currentUser = $currentUser ?: get_current_user();
        $this->calculateList();
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getList()
    {
        return $this->list;
    }

    public function getParent()
    {
        return dirname($this->path);
    }

    public function moveToTrash()
    {
        if (!file_exists($this->path)) {
            return true;
        }

        $info = pathinfo($this->path);

        $name = $info['basename'];
        $ext = $info['extension'] ? '.'.$info['extension'] : '';
        $fileToTrash = $this->getTrashPath()."/".$name;
        while (file_exists($fileToTrash)) {
            $fileToTrash = sprintf(
                "%s/%s %s%s",
                $this->getTrashPath(),
                $name,
                date('H.i.s'),
                $ext
            );
            sleep(1);
        }

        return rename($this->path, $fileToTrash);
    }

    public function getTrashPath()
    {
        $trash = '';
        switch (PHP_OS) {
             case 'Linux':
                 $trash = "/home/".$this->currentUser."/.local/share/Trash";
                 break;
             case 'Darwin':
                 $trash = "/Users/".$this->currentUser."/.Trash/";
                 break;
             default:
                 throw new \Exception("Your operating system is not supported yet, modify Directory.php");
                 break;
        }

        return $trash;
    }

    public function setCurrentUser($user)
    {
        $this->currentUser = $user;
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * returns the space usage of the current directory
     * based on the browsed list
     */
    public function getTotalSize()
    {
        return $this->totalSize;
    }
}
