<?php
/* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Chuck Hagenbuch <chuck@horde.org>                           |
// |          Jon Parise <jon@php.net>                                    |
// |          Damian Alejandro Fernandez Sosa <damlists@cnba.uba.ar>      |
// +----------------------------------------------------------------------+

require_once 'PEAR/Exception.php';
require_once 'Net/Socket2.php';

/**
 * Provides an implementation of the SMTP protocol using PEAR's
 * Net_Socket2:: class.
 *
 * @package Net_SMTP2
 * @author  Chuck Hagenbuch <chuck@horde.org>
 * @author  Jon Parise <jon@php.net>
 * @author  Damian Alejandro Fernandez Sosa <damlists@cnba.uba.ar>
 *
 * @example basic.php   A basic implementation of the Net_SMTP2 package.
 */
class Net_SMTP2
{
    /**
     * The server to connect to.
     *
     * @var string
     */
    public $host = 'localhost';

    /**
     * The port to connect to.
     *
     * @var int
     */
    public $port = 25;

    /**
     * The value to give when sending EHLO or HELO.
     *
     * @var string
     */
    public $localhost = 'localhost';

    /**
     * List of supported authentication methods, in preferential order.
     *
     * @var array
     */
    public $auth_methods = array();

    /**
     * Use SMTP command pipelining (specified in RFC 2920) if the SMTP
     * server supports it.
     *
     * When pipeling is enabled, rcptTo(), mailFrom(), sendFrom(),
     * somlFrom() and samlFrom() do not wait for a response from the
     * SMTP server but return immediately.
     *
     * @var bool
     */
    public $pipelining = false;

    /**
     * Number of pipelined commands.
     *
     * @var int
     */
    protected $_pipelined_commands = 0;

    /**
     * Should debugging output be enabled?
     *
     * @var boolean
     */
    protected $_debug = false;

    /**
     * Debug output handler.
     *
     * @var callback
     */
    protected $_debug_handler = null;

    /**
     * The socket resource being used to connect to the SMTP server.
     *
     * @var resource
     */
    protected $_socket = null;

    /**
     * Array of socket options that will be passed to Net_Socket2::connect().
     *
     * @see stream_context_create()
     *
     * @var array
     */
    protected $_socket_options = null;

    /**
     * The socket I/O timeout value in seconds.
     *
     * @var int
     */
    protected $_timeout = 0;

    /**
     * The most recent server response code.
     *
     * @var int
     */
    protected $_code = -1;

    /**
     * The most recent server response arguments.
     *
     * @var array
     */
    protected $_arguments = array();

    /**
     * Stores the SMTP server's greeting string.
     *
     * @var string
     */
    protected $_greeting = null;

    /**
     * Stores detected features of the SMTP server.
     *
     * @var array
     */
    protected $_esmtp = array();

    /**
     * Instantiates a new Net_SMTP2 object, overriding any defaults
     * with parameters that are passed in.
     *
     * If you have SSL support in PHP, you can connect to a server
     * over SSL using an 'ssl://' prefix:
     *
     *   // 465 is a common smtps port.
     *   $smtp = new Net_SMTP2('ssl://mail.host.com', 465);
     *   $smtp->connect();
     *
     * @param string  $host       The server to connect to.
     * @param integer $port       The port to connect to.
     * @param string  $localhost  The value to give when sending EHLO or HELO.
     * @param boolean $pipeling   Use SMTP command pipelining
     * @param integer $timeout    Socket I/O timeout in seconds.
     * @param array   $socket_options Socket stream_context_create() options.
     */
    public function __construct($host = null, $port = null, $localhost = null,
                                $pipelining = false, $timeout = 0,
                                $socket_options = null)
    {
        if (isset($host)) {
            $this->host = $host;
        }
        if (isset($port)) {
            $this->port = $port;
        }
        if (isset($localhost)) {
            $this->localhost = $localhost;
        }
        $this->pipelining = $pipelining;

        $this->_socket = new Net_Socket2();
        $this->_socket_options = $socket_options;
        $this->_timeout = $timeout;

        /* Include the Auth_SASL2 package.  If the package is available, we
         * enable the authentication methods that depend upon it. */
        if (@include_once 'Auth/SASL2.php') {
            $this->setAuthMethod('CRAM-MD5', array($this, '_authCram_MD5'));
            $this->setAuthMethod('DIGEST-MD5', array($this, '_authDigest_MD5'));
        }

        /* These standard authentication methods are always available. */
        $this->setAuthMethod('LOGIN', array($this, '_authLogin'), false);
        $this->setAuthMethod('PLAIN', array($this, '_authPlain'), false);
    }

    /**
     * Set the socket I/O timeout value in seconds plus microseconds.
     *
     * @param integer $seconds       Timeout value in seconds.
     * @param integer $microseconds  Additional value in microseconds.
     */
    public function setTimeout($seconds, $microseconds = 0)
    {
        return $this->_socket->setTimeout($seconds, $microseconds);
    }

    /**
     * Set the value of the debugging flag.
     *
     * @param boolean $debug  New value for the debugging flag.
     */
    public function setDebug($debug, $handler = null)
    {
        $this->_debug = $debug;
        $this->_debug_handler = $handler;
    }

    /**
     * Write the given debug text to the current debug output handler.
     *
     * @param string $message  Debug message text.
     */
    protected function _debug($message)
    {
        if ($this->_debug) {
            if ($this->_debug_handler) {
                call_user_func_array($this->_debug_handler,
                                     array(&$this, $message));
            } else {
                echo "DEBUG: $message\n";
            }
        }
    }

    /**
     * Send the given string of data to the server.
     *
     * @param string $data  The string of data to send.
     *
     * @return integer  The number of bytes that were actually written.
     * @throws PEAR_Exception
     */
    protected function _send($data)
    {
        $this->_debug("Send: $data");

        $result = $this->_socket->write($data);
        if (!$result) {
            throw new PEAR_Exception('Failed to write to socket: unknown error');
        }

        return $result;
    }

    /**
     * Send a command to the server with an optional string of
     * arguments.  A carriage return / linefeed (CRLF) sequence will
     * be appended to each command string before it is sent to the
     * SMTP server - an error will be thrown if the command string
     * already contains any newline characters. Use _send() for
     * commands that must contain newlines.
     *
     * @param string $command  The SMTP command to send to the server.
     * @param string $args     A string of optional arguments to append
     *                         to the command.
     *
     * @return integer  The number of bytes that were actually written.
     * @throws PEAR_Exception
     */
    protected function _put($command, $args = '')
    {
        if (!empty($args)) {
            $command .= ' ' . $args;
        }

        if (strcspn($command, "\r\n") !== strlen($command)) {
            throw new PEAR_Exception('Commands cannot contain newlines');
        }

        return $this->_send($command . "\r\n");
    }

    /**
     * Read a reply from the SMTP server.  The reply consists of a response
     * code and a response message.
     *
     * @see getResponse
     *
     * @param mixed $valid  The set of valid response codes.  These
     *                      may be specified as an array of integer
     *                      values or as a single integer value.
     * @param bool $later   Do not parse the response now, but wait
     *                      until the last command in the pipelined
     *                      command group
     *
     * @throws PEAR_Exception
     */
    protected function _parseResponse($valid, $later = false)
    {
        $this->_code = -1;
        $this->_arguments = array();

        if ($later) {
            ++$this->_pipelined_commands;
            return;
        }

        for ($i = 0; $i <= $this->_pipelined_commands; ++$i) {
            while ($line = $this->_socket->readLine()) {
                $this->_debug("Recv: $line");

                /* If we receive an empty line, the connection was closed. */
                if (empty($line)) {
                    $this->disconnect();
                    throw new PEAR_Exception('Connection was closed');
                }

                /* Read the code and store the rest in the arguments array. */
                $code = substr($line, 0, 3);
                $this->_arguments[] = trim(substr($line, 4));

                /* Check the syntax of the response code. */
                if (is_numeric($code)) {
                    $this->_code = (int)$code;
                } else {
                    $this->_code = -1;
                    break;
                }

                /* If this is not a multiline response, we're done. */
                if (substr($line, 3, 1) != '-') {
                    break;
                }
            }
        }

        $this->_pipelined_commands = 0;

        /* Compare the server's response code with the valid code/codes. */
        if ((is_int($valid) && ($this->_code === $valid)) ||
            (is_array($valid) && in_array($this->_code, $valid, true))) {
            return;
        }

        throw new PEAR_Exception('Invalid response code received from server',
                                 $this->_code);
    }

    /**
     * Issue an SMTP command and verify its response.
     *
     * @param string $command  The SMTP command string or data.
     * @param mixed $valid     The set of valid response codes.  These
     *                         may be specified as an array of integer
     *                         values or as a single integer value.
     *
     * @throws PEAR_Exception
     */
    public function command($command, $valid)
    {
        $this->_put($command);
        $this->_parseResponse($valid);
    }

    /**
     * Return a 2-tuple containing the last response from the SMTP server.
     *
     * @return array  A two-element array: the first element contains the
     *                response code as an integer and the second element
     *                contains the response's arguments as a string.
     */
    public function getResponse()
    {
        return array($this->_code, join("\n", $this->_arguments));
    }

    /**
     * Return the SMTP server's greeting string.
     *
     * @return  string  A string containing the greeting string, or null if a
     *                  greeting has not been received.
     */
    public function getGreeting()
    {
        return $this->_greeting;
    }

    /**
     * Attempt to connect to the SMTP server.
     *
     * @param int $timeout      The timeout value (in seconds) for the
     *                          socket connection attempt.
     * @param bool $persistent  Should a persistent socket connection
     *                          be used?
     *
     * @throws PEAR_Exception
     */
    public function connect($timeout = null, $persistent = false)
    {
        $this->_greeting = null;
        $result = $this->_socket->connect($this->host, $this->port,
                                          $persistent, $timeout,
                                          $this->_socket_options);

        /*
         * Now that we're connected, reset the socket's timeout value for 
         * future I/O operations.  This allows us to have different socket 
         * timeout values for the initial connection (our $timeout parameter) 
         * and all other socket operations.
         */
        if ($this->_timeout > 0) {
            $this->setTimeout($this->_timeout);
        }

        $this->_parseResponse(220);
        
        /* Extract and store a copy of the server's greeting string. */
        list(, $this->_greeting) = $this->getResponse();

        $this->_negotiate();

        return true;
    }

    /**
     * Attempt to disconnect from the SMTP server.
     *
     * @throws PEAR_Exception
     */
    public function disconnect()
    {
        try {
            $this->_put('QUIT');
        
            $this->_parseResponse(221);
            $this->_socket->disconnect();
        } catch (Net_Socket2_Exception $e) {
            // Already disconnected? Silence!
        }

        return true;
    }

    /**
     * Attempt to send the EHLO command and obtain a list of ESMTP
     * extensions available, and failing that just send HELO.
     *
     * @throws PEAR_Exception
     */
    protected function _negotiate()
    {
        $this->_put('EHLO', $this->localhost);

        try {
            $this->_parseResponse(250);
        } catch (PEAR_Exception $e) {
            /* If the EHLO failed, try the simpler HELO command. */
            $this->_put('HELO', $this->localhost);
            $this->_parseResponse(250);

            return true;
        }

        foreach ($this->_arguments as $argument) {
            $verb = strtok($argument, ' ');
            $arguments = substr($argument, strlen($verb) + 1,
                                strlen($argument) - strlen($verb) - 1);
            $this->_esmtp[$verb] = $arguments;
        }

        if (!isset($this->_esmtp['PIPELINING'])) {
            $this->pipelining = false;
        }
    }

    /**
     * Returns the name of the best authentication method that the server
     * has advertised.
     *
     * @return mixed    Returns a string containing the name of the best
     *                  supported authentication method.
     * @throws PEAR_Exception
     */
    protected function _getBestAuthMethod()
    {
        $available_methods = explode(' ', $this->_esmtp['AUTH']);

        foreach ($this->auth_methods as $method => $callback) {
            if (in_array($method, $available_methods)) {
                return $method;
            }
        }

        throw new PEAR_Exception('No supported authentication methods');
    }

    /**
     * Attempt to do SMTP authentication.
     *
     * @param string $uid     The userid to authenticate as.
     * @param string $pwd     The password to authenticate with.
     * @param string $method  The requested authentication method.  If none is
     *                        specified, the best supported method will be
     *                        used.
     * @param bool $tls       Flag indicating whether or not TLS should be
     *                        attempted.
     * @param string $authz   An optional authorization identifier.  If
     *                        specified, this identifier will be used as the
     *                        authorization proxy.
     *
     * @throws PEAR_Exception
     */
    public function auth($uid, $pwd, $method = '', $tls = true, $authz = '')
    {
        /* We can only attempt a TLS connection if one has been requested,
         * we're running PHP 5.1.0 or later, have access to the OpenSSL
         * extension, are connected to an SMTP server which supports the
         * STARTTLS extension, and aren't already connected over a secure
         * (SSL) socket connection. */
        if ($tls && version_compare(PHP_VERSION, '5.1.0', '>=') &&
            extension_loaded('openssl') && isset($this->_esmtp['STARTTLS']) &&
            strncasecmp($this->host, 'ssl://', 6) !== 0) {
            /* Start the TLS connection attempt. */
            $this->_put('STARTTLS');
            $this->_parseResponse(220);

            $result = $this->_socket->enableCrypto(true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            if ($result !== true) {
                throw new PEAR_Exception('STARTTLS failed');
            }

            /* Send EHLO again to recieve the AUTH string from the
             * SMTP server. */
            $this->_negotiate();
        }

        if (empty($this->_esmtp['AUTH'])) {
            throw new PEAR_Exception('SMTP server does not support authentication');
        }

        /* If no method has been specified, get the name of the best
         * supported method advertised by the SMTP server. */
        $method = empty($method)
            ? $this->_getBestAuthMethod()
            : strtoupper($method);
        if (!array_key_exists($method, $this->auth_methods)) {
            throw new PEAR_Exception($method . ' is not a supported authentication method');
        }

        if (!is_callable($this->auth_methods[$method], false)) {
            throw new PEAR_Exception($method . ' authentication method cannot be called');
        }

        if (is_array($this->auth_methods[$method])) {
            list($object, $method) = $this->auth_methods[$method];
            $object->{$method}($uid, $pwd, $authz, $this);
        } else {
            $func = $this->auth_methods[$method];
            $func($uid, $pwd, $authz, $this);
         }
    }

    /**
     * Add a new authentication method.
     *
     * @param string $name     The authentication method name (e.g. 'PLAIN')
     * @param mixed $callback  The authentication callback (given as the name
     *                         of a function or as an (object, method name)
     *                         array).
     * @param bool $prepend    Should the new method be prepended to the list
     *                         of available methods?  This is the default
     *                         behavior, giving the new method the highest
     *                         priority.
     *
     * @throws PEAR_Exception
     */
    public function setAuthMethod($name, $callback, $prepend = true)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Method name is not a string');
        }

        if (!is_string($callback) && !is_array($callback)) {
            throw new InvalidArgumentException('Method callback must be string or array');
        }

        if (is_array($callback) &&
            (!is_object($callback[0]) || !is_string($callback[1]))) {
            throw new InvalidArgumentException('Bad method callback array');
        }

        if ($prepend) {
            $this->auth_methods = array_merge(array($name => $callback),
                                              $this->auth_methods);
        } else {
            $this->auth_methods[$name] = $callback;
        }
    }

    /**
     * Authenticates the user using the DIGEST-MD5 method.
     *
     * @param string $uid    The userid to authenticate as.
     * @param string $pwd    The password to authenticate with.
     * @param string $authz  The optional authorization proxy identifier.
     *
     * @throws PEAR_Exception
     */
    protected function _authDigest_MD5($uid, $pwd, $authz = '')
    {
        $this->_put('AUTH', 'DIGEST-MD5');

        /* 334: Continue authentication request */
        try {
            $this->_parseResponse(334);
        } catch (PEAR_Exception $e) {
            /* 503: Error: already authenticated */
            if ($e->getCode() === 503) {
                return;
            }
            throw $e;
        }

        $auth_sasl = new Auth_SASL2();
        $challenge = base64_decode($this->_arguments[0]);
        $digest = $auth_sasl->factory('digest-md5');
        $auth_str = base64_encode($digest->getResponse($uid, $pwd, $challenge,
                                                       $this->host, "smtp",
                                                       $authz));

        $this->_put($auth_str);

        /* 334: Continue authentication request */
        $this->_parseResponse(334);

        /* We don't use the protocol's third step because SMTP doesn't
         * allow subsequent authentication, so we just silently ignore
         * it. */
        $this->_put('');

        /* 235: Authentication successful */
        $this->_parseResponse(235);
    }

    /**
     * Authenticates the user using the CRAM-MD5 method.
     *
     * @param string $uid    The userid to authenticate as.
     * @param string $pwd    The password to authenticate with.
     * @param string $authz  The optional authorization proxy identifier.
     *
     * @throws PEAR_Exception
     */
    protected function _authCRAM_MD5($uid, $pwd, $authz = '')
    {
        $this->_put('AUTH', 'CRAM-MD5');

        /* 334: Continue authentication request */
        try {
            $this->_parseResponse(334);
        } catch (PEAR_Exception $e) {
            /* 503: Error: already authenticated */
            if ($e->getCode() === 503) {
                return;
            }
            throw $e;
        }
        $auth_sasl = new Auth_SASL2();
        $challenge = base64_decode($this->_arguments[0]);
        $cram = $auth_sasl->factory('cram-md5');
        $auth_str = base64_encode($cram->getResponse($uid, $pwd, $challenge));

        $this->_put($auth_str);

        /* 235: Authentication successful */
        $this->_parseResponse(235);
    }

    /**
     * Authenticates the user using the LOGIN method.
     *
     * @param string $uid    The userid to authenticate as.
     * @param string $pwd    The password to authenticate with.
     * @param string $authz  The optional authorization proxy identifier.
     *
     * @throws PEAR_Exception
     */
    protected function _authLogin($uid, $pwd, $authz = '')
    {
        $this->_put('AUTH', 'LOGIN');

        /* 334: Continue authentication request */
        try {
            $this->_parseResponse(334);
        } catch (PEAR_Exception $e) {
            /* 503: Error: already authenticated */
            if ($e->getCode() === 503) {
                return;
            }
            throw $e;
        }

        $this->_put(base64_encode($uid));

        /* 334: Continue authentication request */
        $this->_parseResponse(334);

        $this->_put(base64_encode($pwd));

        /* 235: Authentication successful */
        $this->_parseResponse(235);
    }

    /**
     * Authenticates the user using the PLAIN method.
     *
     * @param string $uid    The userid to authenticate as.
     * @param string $pwd    The password to authenticate with.
     * @param string $authz  The optional authorization proxy identifier.
     *
     * @throws PEAR_Exception
     */
    protected function _authPlain($uid, $pwd, $authz = '')
    {
        $this->_put('AUTH', 'PLAIN');

        /* 334: Continue authentication request */
        try {
            $this->_parseResponse(334);
        } catch (PEAR_Exception $e) {
            /* 503: Error: already authenticated */
            if ($e->getCode() === 503) {
                return;
            }
            throw $e;
        }

        $auth_str = base64_encode($authz . chr(0) . $uid . chr(0) . $pwd);

        $this->_put($auth_str);

        /* 235: Authentication successful */
        $this->_parseResponse(235);
    }

    /**
     * Send the HELO command.
     *
     * @param string The domain name to say we are.
     *
     * @throws PEAR_Exception
     */
    public function helo($domain)
    {
        $this->_put('HELO', $domain);
        $this->_parseResponse(250);
    }

    /**
     * Return the list of SMTP service extensions advertised by the server.
     *
     * @return array The list of SMTP service extensions.
     */
    public function getServiceExtensions()
    {
        return $this->_esmtp;
    }

    /**
     * Send the MAIL FROM: command.
     *
     * @param string $sender  The sender (reverse path) to set.
     * @param string $params  String containing additional MAIL parameters,
     *                        such as the NOTIFY flags defined by RFC 1891
     *                        or the VERP protocol.
     *
     * @throws PEAR_Exception
     */
    public function mailFrom($sender, $params = null)
    {
        $args = "FROM:<$sender>";
        if (is_string($params) && strlen($params)) {
            $args .= ' ' . $params;
        }

        $this->_put('MAIL', $args);
        $this->_parseResponse(250, $this->pipelining);
    }

    /**
     * Send the RCPT TO: command.
     *
     * @param string $recipient  The recipient (forward path) to add.
     * @param string $params     String containing additional RCPT parameters,
     *                           such as the NOTIFY flags defined by RFC 1891.
     *
     * @throws PEAR_Exception
     */
    public function rcptTo($recipient, $params = null)
    {
        $args = "TO:<$recipient>";
        if (is_string($params) && strlen($params)) {
            $args .= ' ' . $params;
        }

        $this->_put('RCPT', $args);
        $this->_parseResponse(array(250, 251), $this->pipelining);
    }

    /**
     * Quote the data so that it meets SMTP standards.
     *
     * This is provided as a separate public function to facilitate
     * easier overloading for the cases where it is desirable to
     * customize the quoting behavior.
     *
     * @param string &$data  The message text to quote. The string must be
     *                       passed by reference, and the text will be
     *                       modified in place.
     */
    public function quotedata(&$data)
    {
        /* Because a single leading period (.) signifies an end to the
         * data, legitimate leading periods need to be "doubled" ('..').
         * Also: change Unix (\n) and Mac (\r) linefeeds into CRLF's
         * (\r\n). */
        $data = preg_replace(
            array('/^\./m', '/(?:\r\n|\n|\r(?!\n))/'),
            array('..', "\r\n"),
            $data
        );
    }

    /**
     * Send the DATA command.
     *
     * @param mixed $data      The message data, either as a string or an open
     *                         file resource.
     * @param string $headers  The message headers. If $headers is provided,
     *                         $data is assumed to contain only body data.
     *
     * @throws PEAR_Exception
     */
    public function data($data, $headers = null)
    {
        /* Verify that $data is a supported type. */
        if (!is_string($data) && !is_resource($data)) {
            throw new InvalidArgumentException('Expected a string or file resource');
        }

        /* Start by considering the size of the optional headers string.  We
         * also account for the addition 4 character "\r\n\r\n" separator
         * sequence. */
        $size = is_null($headers) ? 0 : strlen($headers) + 4;

        if (is_resource($data)) {
            $stat = fstat($data);
            if ($stat === false) {
                throw new PEAR_Exception('Failed to get file size');
            }
            $size += $stat['size'];
        } else {
            $size += strlen($data);
        }

        /* RFC 1870, section 3, subsection 3 states "a value of zero indicates
         * that no fixed maximum message size is in force".  Furthermore, it
         * says that if "the parameter is omitted no information is conveyed
         * about the server's fixed maximum message size". */
        $limit = isset($this->_esmtp['SIZE']) ? $this->_esmtp['SIZE'] : 0;
        if ($limit > 0 && $size >= $limit) {
            $this->disconnect();
            throw new PEAR_Exception('Message size exceeds server limit');
        }

        /* Initiate the DATA command. */
        $this->_put('DATA');
        $this->_parseResponse(354);

        /* If we have a separate headers string, send it first. */
        if (!is_null($headers)) {
            $this->quotedata($headers);
            $this->_send($headers . "\r\n\r\n");
        }

        /* Now we can send the message body data. */
        if (is_resource($data)) {
            /* Stream the contents of the file resource out over our socket
             * connection, line by line.  Each line must be run through the
             * quoting routine. */
            while (strlen($line = fread($data, 8192)) > 0) {
                /* If the last character is an newline, we need to grab the
                 * next character to check to see if it is a period. */
                while (!feof($data)) {
                    $char = fread($data, 1);
                    $line .= $char;
                    if ($char != "\n") {
                        break;
                    }
                }
                $this->quotedata($line);
                $this->_send($line);
            }
        } else {
            /* Break up the data by sending one chunk (up to 512k) at a time.
             * This approach reduces our peak memory usage. */
            for ($offset = 0; $offset < $size;) {
                $end = $offset + 512000;

                /* Ensure we don't read beyond our data size or span multiple
                 * lines.  quotedata() can't properly handle character data
                 * that's split across two line break boundaries. */
                if ($end >= $size) {
                    $end = $size;
                } else {
                    for (; $end < $size; $end++) {
                        if ($data[$end] != "\n") {
                            break;
                        }
                    }
                }

                /* Extract our chunk and run it through the quoting routine. */
                $chunk = substr($data, $offset, $end - $offset);
                $this->quotedata($chunk);

                /* If we run into a problem along the way, abort. */
                $this->_send($chunk);

                /* Advance the offset to the end of this chunk. */
                $offset = $end;
            }
        }

        /* Finally, send the DATA terminator sequence. */
        $this->_send("\r\n.\r\n");

        /* Verify that the data was successfully received by the server. */
        $this->_parseResponse(250, $this->pipelining);
    }

    /**
     * Send the SEND FROM: command.
     *
     * @param string $path  The reverse path to send.
     *
     * @throws PEAR_Exception
     */
    public function sendFrom($path)
    {
        $this->_put('SEND', "FROM:<$path>");
        $this->_parseResponse(250, $this->pipelining);
    }

    /**
     * Send the SOML FROM: command.
     *
     * @param string $path  The reverse path to send.
     *
     * @throws PEAR_Exception
     */
    public function somlFrom($path)
    {
        $this->_put('SOML', "FROM:<$path>");
        $this->_parseResponse(250, $this->pipelining);
    }

    /**
     * Send the SAML FROM: command.
     *
     * @param string $path  The reverse path to send.
     *
     * @throws PEAR_Exception
     */
    public function samlFrom($path)
    {
        $this->_put('SAML', "FROM:<$path>");
        $this->_parseResponse(250, $this->pipelining);
    }

    /**
     * Send the RSET command.
     *
     * @throws PEAR_Exception
     */
    public function rset()
    {
        $this->_put('RSET');
        $this->_parseResponse(250, $this->pipelining);
    }

    /**
     * Send the VRFY command.
     *
     * @param string $string  The string to verify
     *
     * @throws PEAR_Exception
     */
    public function vrfy($string)
    {
        /* Note: 251 is also a valid response code */
        $this->_put('VRFY', $string);
        $this->_parseResponse(array(250, 252));
    }

    /**
     * Send the NOOP command.
     *
     * @throws PEAR_Exception
     */
    public function noop()
    {
        $this->_put('NOOP');
        $this->_parseResponse(250);
    }

}
