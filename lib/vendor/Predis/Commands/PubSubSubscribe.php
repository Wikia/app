<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Commands;

use Predis\Helpers;

/**
 * @link http://redis.io/commands/subscribe
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class PubSubSubscribe extends Command implements IPrefixable
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'SUBSCRIBE';
    }

    /**
     * {@inheritdoc}
     */
    protected function filterArguments(Array $arguments)
    {
        return Helpers::filterArrayArguments($arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function prefixKeys($prefix)
    {
        PrefixHelpers::all($this, $prefix);
    }

    /**
     * {@inheritdoc}
     */
    protected function canBeHashed()
    {
        return false;
    }
}
