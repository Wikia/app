<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Protocol\Text;

use Predis\Helpers;
use Predis\Protocol\IResponseReader;
use Predis\Protocol\IResponseHandler;
use Predis\Protocol\ProtocolException;
use Predis\Network\IConnectionComposable;

/**
 * Implements a pluggable response reader using the standard wire protocol
 * defined by Redis.
 *
 * @link http://redis.io/topics/protocol
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class TextResponseReader implements IResponseReader
{
    private $handlers;

    /**
     *
     */
    public function __construct()
    {
        $this->handlers = $this->getDefaultHandlers();
    }

    /**
     * Returns the default set of response handlers for all the type of replies
     * that can be returned by Redis.
     */
    private function getDefaultHandlers()
    {
        return array(
            TextProtocol::PREFIX_STATUS     => new ResponseStatusHandler(),
            TextProtocol::PREFIX_ERROR      => new ResponseErrorHandler(),
            TextProtocol::PREFIX_INTEGER    => new ResponseIntegerHandler(),
            TextProtocol::PREFIX_BULK       => new ResponseBulkHandler(),
            TextProtocol::PREFIX_MULTI_BULK => new ResponseMultiBulkHandler(),
        );
    }

    /**
     * Sets a response handler for a certain prefix that identifies a type of
     * reply that can be returned by Redis.
     *
     * @param string $prefix Identifier for a type of reply.
     * @param IResponseHandler $handler Response handler for the reply.
     */
    public function setHandler($prefix, IResponseHandler $handler)
    {
        $this->handlers[$prefix] = $handler;
    }

    /**
     * Returns the response handler associated to a certain type of reply that
     * can be returned by Redis.
     *
     * @param string $prefix Identifier for a type of reply.
     * @return IResponseHandler
     */
    public function getHandler($prefix)
    {
        if (isset($this->handlers[$prefix])) {
            return $this->handlers[$prefix];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function read(IConnectionComposable $connection)
    {
        $header = $connection->readLine();
        if ($header === '') {
            $this->protocolError($connection, 'Unexpected empty header');
        }

        $prefix = $header[0];
        if (!isset($this->handlers[$prefix])) {
            $this->protocolError($connection, "Unknown prefix '$prefix'");
        }

        $handler = $this->handlers[$prefix];

        return $handler->handle($connection, substr($header, 1));
    }

    /**
     * Helper method used to handle a protocol error generated while reading a
     * reply from a connection to Redis.
     *
     * @param IConnectionComposable $connection Connection to Redis that generated the error.
     * @param string $message Error message.
     */
    private function protocolError(IConnectionComposable $connection, $message)
    {
        Helpers::onCommunicationException(new ProtocolException($connection, $message));
    }
}
