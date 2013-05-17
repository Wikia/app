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

/**
 * @link http://redis.io/commands/client
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ServerClient extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'CLIENT';
    }

    /**
     * {@inheritdoc}
     */
    protected function canBeHashed()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function parseResponse($data)
    {
        $args = array_change_key_case($this->getArguments(), CASE_UPPER);
        switch (strtoupper($args[0])) {
            case 'LIST':
                return $this->parseClientList($data);

            case 'KILL':
            default:
                return $data;
        }
    }

    /**
     * Parses the reply buffer and returns the list of clients returned by
     * the CLIENT LIST command.
     *
     * @param string $data Reply buffer
     * @return array
     */
    protected function parseClientList($data)
    {
        $clients = array();

        foreach (explode("\n", $data, -1) as $clientData) {
            $client = array();
            foreach (explode(' ', $clientData) as $kv) {
                @list($k, $v) = explode('=', $kv);
                $client[$k] = $v;
            }
            $clients[] = $client;
        }

        return $clients;
    }
}
