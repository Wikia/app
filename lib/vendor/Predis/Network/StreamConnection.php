<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Network;

use Predis\ResponseError;
use Predis\ResponseQueued;
use Predis\ServerException;
use Predis\NotSupportedException;
use Predis\IConnectionParameters;
use Predis\Commands\ICommand;
use Predis\Iterators\MultiBulkResponseSimple;

/**
 * Connection abstraction to Redis servers based on PHP's streams.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class StreamConnection extends ConnectionBase
{
    private $mbiterable;
    private $throwErrors;

    /**
     * Disconnects from the server and destroys the underlying resource when
     * PHP's garbage collector kicks in only if the connection has not been
     * marked as persistent.
     */
    public function __destruct()
    {
        if (!$this->parameters->connection_persistent) {
            $this->disconnect();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function initializeProtocol(IConnectionParameters $parameters)
    {
        $this->throwErrors = $parameters->throw_errors;
        $this->mbiterable = $parameters->iterable_multibulk;
    }

    /**
     * {@inheritdoc}
     */
    protected function createResource()
    {
        $parameters = $this->parameters;
        $initializer = "{$parameters->scheme}StreamInitializer";

        return $this->$initializer($parameters);
    }

    /**
     * Initializes a TCP stream resource.
     *
     * @param IConnectionParameters $parameters Parameters used to initialize the connection.
     * @return resource
     */
    private function tcpStreamInitializer(IConnectionParameters $parameters)
    {
        $uri = "tcp://{$parameters->host}:{$parameters->port}/";

        $flags = STREAM_CLIENT_CONNECT;
        if ($parameters->connection_async) {
            $flags |= STREAM_CLIENT_ASYNC_CONNECT;
        }
        if ($parameters->connection_persistent) {
            $flags |= STREAM_CLIENT_PERSISTENT;
        }

        $resource = @stream_socket_client(
            $uri, $errno, $errstr, $parameters->connection_timeout, $flags
        );

        if (!$resource) {
            $this->onConnectionError(trim($errstr), $errno);
        }

        if (isset($parameters->read_write_timeout)) {
            $rwtimeout = $parameters->read_write_timeout;
            $rwtimeout = $rwtimeout > 0 ? $rwtimeout : -1;
            $timeoutSeconds  = floor($rwtimeout);
            $timeoutUSeconds = ($rwtimeout - $timeoutSeconds) * 1000000;
            stream_set_timeout($resource, $timeoutSeconds, $timeoutUSeconds);
        }

        return $resource;
    }

    /**
     * Initializes a UNIX stream resource.
     *
     * @param IConnectionParameters $parameters Parameters used to initialize the connection.
     * @return resource
     */
    private function unixStreamInitializer(IConnectionParameters $parameters)
    {
        $uri = "unix://{$parameters->path}";

        $flags = STREAM_CLIENT_CONNECT;
        if ($parameters->connection_persistent) {
            $flags |= STREAM_CLIENT_PERSISTENT;
        }

        $resource = @stream_socket_client(
            $uri, $errno, $errstr, $parameters->connection_timeout, $flags
        );

        if (!$resource) {
            $this->onConnectionError(trim($errstr), $errno);
        }

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
        parent::connect();

        if (count($this->initCmds) > 0){
            $this->sendInitializationCommands();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        if ($this->isConnected()) {
            fclose($this->getResource());

            parent::disconnect();
        }
    }

    /**
     * Sends the initialization commands to Redis when the connection is opened.
     */
    private function sendInitializationCommands()
    {
        foreach ($this->initCmds as $command) {
            $this->writeCommand($command);
        }
        foreach ($this->initCmds as $command) {
            $this->readResponse($command);
        }
    }

    /**
     * Performs a write operation on the stream of the buffer containing a
     * command serialized with the Redis wire protocol.
     *
     * @param string $buffer Redis wire protocol representation of a command.
     */
    protected function writeBytes($buffer)
    {
        $socket = $this->getResource();

        while (($length = strlen($buffer)) > 0) {
            $written = fwrite($socket, $buffer);
            if ($length === $written) {
                return;
            }
            if ($written === false || $written === 0) {
                $this->onConnectionError('Error while writing bytes to the server');
            }
            $buffer = substr($buffer, $written);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function read()
    {
        $socket = $this->getResource();

        $chunk  = fgets($socket);
        if ($chunk === false || $chunk === '') {
            $this->onConnectionError('Error while reading line from the server');
        }

        $prefix  = $chunk[0];
        $payload = substr($chunk, 1, -2);

        switch ($prefix) {
            case '+':    // inline
                switch ($payload) {
                    case 'OK':
                        return true;

                    case 'QUEUED':
                        return new ResponseQueued();

                    default:
                        return $payload;
                }

            case '$':    // bulk
                $size = (int) $payload;
                if ($size === -1) {
                    return null;
                }

                $bulkData = '';
                $bytesLeft = ($size += 2);

                do {
                    $chunk = fread($socket, min($bytesLeft, 4096));
                    if ($chunk === false || $chunk === '') {
                        $this->onConnectionError(
                            'Error while reading bytes from the server'
                        );
                    }
                    $bulkData .= $chunk;
                    $bytesLeft = $size - strlen($bulkData);
                } while ($bytesLeft > 0);

                return substr($bulkData, 0, -2);

            case '*':    // multi bulk
                $count = (int) $payload;
                if ($count === -1) {
                    return null;
                }

                if ($this->mbiterable === true) {
                    return new MultiBulkResponseSimple($this, $count);
                }

                $multibulk = array();
                for ($i = 0; $i < $count; $i++) {
                    $multibulk[$i] = $this->read();
                }

                return $multibulk;

            case ':':    // integer
                return (int) $payload;

            case '-':    // error
                if ($this->throwErrors) {
                    throw new ServerException($payload);
                }
                return new ResponseError($payload);

            default:
                $this->onProtocolError("Unknown prefix: '$prefix'");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function writeCommand(ICommand $command)
    {
        $commandId = $command->getId();
        $arguments = $command->getArguments();

        $cmdlen = strlen($commandId);
        $reqlen = count($arguments) + 1;

        $buffer = "*{$reqlen}\r\n\${$cmdlen}\r\n{$commandId}\r\n";

        for ($i = 0; $i < $reqlen - 1; $i++) {
            $argument = $arguments[$i];
            $arglen = strlen($argument);
            $buffer .= "\${$arglen}\r\n{$argument}\r\n";
        }

        $this->writeBytes($buffer);
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array_merge(parent::__sleep(), array('mbiterable', 'throwErrors'));
    }
}
