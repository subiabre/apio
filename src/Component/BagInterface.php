<?php

namespace Apio\Component;

interface BagInterface
{
    public function __set($name, $value);

    public function __get($name);

    public function __call($name, $arguments);
}
