<?php

namespace Mcustiel\Creature;

class SingletonLazyCreator extends LazyCreator implements CreatorInterface
{
    use Singleton;
}
