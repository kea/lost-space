<?php

namespace LostSpace;

class FlashBag
{
    public function add($type, $message)
    {
        if (!$this->has($type)) {
            $_COOKIE[$type] = [];
        }

        $_COOKIE[$type][] = $message;
    }

    public function get($type)
    {
        if (!$this->has($type)) {
            return null;
        }

        return $_COOKIE[$type];
    }

    public function has($type)
    {
        return !empty($_COOKIE[$type])
            && is_array($_COOKIE[$type]);
    }
}