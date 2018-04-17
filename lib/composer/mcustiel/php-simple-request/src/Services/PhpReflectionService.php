<?php
namespace Mcustiel\SimpleRequest\Services;

use Mcustiel\SimpleRequest\Interfaces\ReflectionService;

class PhpReflectionService implements ReflectionService
{
    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\ReflectionService::getClassProperties()
     */
    public function getClassProperties($className)
    {
        $reflection = new \ReflectionClass($className);
        return $reflection->getProperties();
    }
}
