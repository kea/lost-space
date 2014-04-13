<?php

namespace LostSpace;

class ViewHelper
{
    public static function humanSize($size)
    {
        if ($size < 1024) {
            return round($size).'K';
        }

        if (($size /= 1024) < 1024) {
            return round($size).'M';
        }

        if (($size /= 1024) < 1024) {
            return round($size).'G';
        }

        return round($size / 1024).'T';
    }

    public static function classForType($type)
    {
        $classForType = [
            'dir' => 'fi-folder',
            'file' => 'fi-page',
            'link' => 'fi-link',
            'socket' => 'fi-puzzle',
            'grand-total' => 'fi-clipboard-notes'
        ];

        return isset($classForType[$type]) ? $classForType[$type] : $classForType['page'];
    }
}
