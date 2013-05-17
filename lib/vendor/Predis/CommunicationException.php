<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis;

use Predis\Network\IConnectionSingle;

/**
 * Base exception class for network-related errors.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
abstract class CommunicationException extends PredisException
{
    private $connection;

    /**
     * @param IConnectionSingle $connection Connection that generated the exception.
     * @param string $message Error message.
     * @param int $code Error code.
     * @param \Exception $innerException Inner exception for wrapping the original error.
     */
    public function __construct(IConnectionSingle $connection,
        $message = null, $code = null, \Exception $innerException = null)
    {
        parent::__construct($message, $code, $innerException);

        $this->connection = $connection;
    }

    /**
     * Gets the connection that generated the exception.
     *
     * @return IConnectionSingle
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Indicates if the receiver should reset the underlying connection.
     *
     * @return Boolean
     */
    public function shouldResetConnection()
    {
        return true;
    }
}
