<?php declare(strict_types=1);

namespace Apio\Storage;

interface BagInterface
{
    public function __set($name, $value);

    public function __get($name);

    public function __call($name, $arguments);

    public function toArray(array $ignore = []): array;
}
