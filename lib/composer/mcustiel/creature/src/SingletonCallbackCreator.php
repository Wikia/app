<?php

namespace Mcustiel\Creature;

class SingletonCallbackCreator extends CallbackCreator implements CreatorInterface
{
    use Singleton;
}
