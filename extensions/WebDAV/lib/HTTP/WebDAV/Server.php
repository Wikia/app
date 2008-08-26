<?php

/*
   +----------------------------------------------------------------------+
   | Copyright (c) 2002-2007 Christian Stocker, Hartmut Holzgraefe        |
   | All rights reserved                                                  |
   |                                                                      |
   | Redistribution and use in source and binary forms, with or without   |
   | modification, are permitted provided that the following conditions   |
   | are met:                                                             |
   |                                                                      |
   | 1. Redistributions of source code must retain the above copyright    |
   |    notice, this list of conditions and the following disclaimer.     |
   | 2. Redistributions in binary form must reproduce the above copyright |
   |    notice, this list of conditions and the following disclaimer in   |
   |    the documentation and/or other materials provided with the        |
   |    distribution.                                                     |
   | 3. The names of the authors may not be used to endorse or promote    |
   |    products derived from this software without specific prior        |
   |    written permission.                                               |
   |                                                                      |
   | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  |
   | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    |
   | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    |
   | FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE       |
   | COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,  |
   | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, |
   | BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;     |
   | LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER     |
   | CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT   |
   | LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN    |
   | ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE      |
   | POSSIBILITY OF SUCH DAMAGE.                                          |
   +----------------------------------------------------------------------+
*/

define('HTTP_WEBDAV_SERVER_DATATYPE_NAMESPACE',
    'urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882');

/**
 * WebDAV server base class, needs to be extended to do useful work
 *
 * @package HTTP_WebDAV_Server
 * @author Hartmut Holzgraefe <hholzgra@php.net>
 * @version 0.99.1dev
 */
class HTTP_WebDAV_Server
{
    // {{{ Member Variables

    /**
     * Realm for authentification popups
     *
     * @var string
     */
    var $authRealm;

    /**
     * Value of X-Dav-Powered-By response header
     *
     * @var string
     */
    var $poweredBy;

    /**
     * Request path components
     *
     * @var array
     */
    var $pathComponents;

    /**
     * Base URL components
     *
     * See PHP parse_url structure
     *
     * @var array
     */
    var $baseUrlComponents;

    /**
     * If request header components
     *
     * @var array
     */
    var $ifHeaderComponents;

    /**
     * Array of response headers which have already been sent
     *
     * @var array
     */
    var $responseHeaders;

    /**
     * Encoding of property values passed in
     *
     * @var string
     */
    var $_prop_encoding = 'utf-8';

    // }}}

    // {{{ init

    /**
     * Initialize
     *
     * @param void
     * @return void
     */
    function init()
    {
        // realm for authentification popups
        $this->authRealm = 'PHP WebDAV';

        // value of X-Dav-Powered-By response header
        $this->poweredBy = 'PHP class: ' . get_class($this);

        // request path components
        $this->pathComponents = array();
        if (!empty($_SERVER['PATH_INFO'])) {
            $this->pathComponents = preg_split('/\//', $_SERVER['PATH_INFO'], -1, PREG_SPLIT_NO_EMPTY);
        }

        // base URL components
        $this->baseUrlComponents = array();
        if (!empty($_SERVER['SCRIPT_NAME'])) {
            $this->baseUrlComponents = $this->parseUrl($_SERVER['SCRIPT_NAME']);
        }

        if (!empty($_SERVER['REQUEST_URI'])) {
            $requestUrlComponents = $this->parseUrl($_SERVER['REQUEST_URI']);

            if (!empty($this->baseUrlComponents['pathComponents'])) {
                $this->pathComponents = array_slice($requestUrlComponents['pathComponents'], count($this->baseUrlComponents['pathComponents']));
            }

            if (!empty($this->pathComponents)) {
                $this->baseUrlComponents['pathComponents'] = array_slice($requestUrlComponents['pathComponents'], 0, -count($this->pathComponents));
            }
        }

        if (!empty($_SERVER['HTTP_HOST'])) {
            $this->baseUrlComponents['host'] = $_SERVER['HTTP_HOST'];
        }

        if (!empty($_SERVER['QUERY_STRING'])) {
            $this->baseUrlComponents['query'] = $_SERVER['QUERY_STRING'];
        }

        // If request header components
        $this->ifHeaderComponents = array();
        if (!empty($_SERVER['HTTP_IF'])) {
            $this->ifHeaderComponents = $this->_if_header_parser($_SERVER['HTTP_IF']);
        }
    }

    // }}}

    // {{{ handleRequest

    /**
     * Handle WebDAV request
     *
     * Dispatch WebDAV request to the apropriate method wrapper
     *
     * @param void
     * @return void
     */
    function handleRequest()
    {
        // initialize
        $this->init();

        // identify ourselves
        if (!empty($this->poweredBy)) {
            $this->setResponseHeader('X-Dav-Powered-By: ' . $this->poweredBy);
        }

        // check authentication
        if (!$this->check_auth_wrapper()) {

            // RFC2518 says we must use Digest instead of Basic but Microsoft
            // clients do not support Digest and we don't support NTLM or
            // Kerberos so we are stuck with Basic here
            $this->setResponseHeader('WWW-Authenticate: Basic realm="'
                . $this->authRealm . '"');

            // Windows seems to require this being the last response header
            // sent (changed according to PECL bug #3138)
            $this->setResponseStatus('401 Unauthorized');
            return;
        }

        // check if request header components
        if (!$this->check_if_helper($this->ifHeaderComponents)) {
            $this->setResponseStatus('412 Precondition Failed');
            return;
        }

        // detect requested method names
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $wrapper = $method . '_wrapper';

        // get allowed methods
        $allowedMethods = $this->getAllowedMethods();

        // method not implemented
        if (!in_array(strtoupper($method), $allowedMethods)) {
            if ($method == 'lock') {
                $this->setResponseStatus('412 Precondition Failed');
                return;
            }

            // tell client what's allowed
            $this->setResponseStatus('405 Method Not Allowed');
            $this->setResponseHeader('Allow: ' . implode(',', $allowedMethods));
            return;
        }

        return call_user_func(array($this, $wrapper));
    }

    // }}}

    // {{{ abstract WebDAV methods

    // {{{ PROPFIND

    /**
     * PROPFIND implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function propfind()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ PROPPATCH

    /**
     * PROPPATCH implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function proppatch()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ MKCOL

    /**
     * MKCOL implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function mkcol()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ GET

    /**
     * GET implementation
     *
     * Overload this method to retrieve resources from your server
     *
     * @abstract
     * @param array &$params array of input and output parameters
     * <br><b>input</b><ul>
     * <li> path -
     * </ul>
     * <br><b>output</b><ul>
     * <li> size -
     * </ul>
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function get()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ DELETE

    /**
     * DELETE implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function delete()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ PUT

    /**
     * PUT implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function put()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ COPY

    /**
     * COPY implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function copy()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ MOVE

    /**
     * MOVE implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function move()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ LOCK

    /**
     * LOCK implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function lock()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ UNLOCK

    /**
     * UNLOCK implementation
     *
     * @abstract
     * @param array &$params
     * @returns int HTTP-Statuscode
     */

    /* abstract
       function unlock()
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // }}}

    // {{{ other abstract methods

    // {{{ checkAuth

    /**
     * Check authentication
     *
     * Overload this method to retrieve and confirm authentication information
     *
     * @abstract
     * @param string type Authentication type, e.g. "basic" or "digest"
     * @param string username Transmitted username
     * @param string password Transmitted password
     * @returns bool Authentication status
     */

    /* abstract
       function checkAuth($type, $username, $password)
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // {{{ getLocks

    /**
     * Get lock entries for a resource
     *
     * Overload this method to return shared and exclusive locks active for
     * this resource
     *
     * @abstract
     * @param string resource path to check
     * @returns array of lock entries each consisting
     *                of 'type' ('shared'/'exclusive'), 'token' and 'timeout'
     */

    /* abstract
       function getLocks($path)
       {
           // dummy entry for PHPDoc
       }
    */

    // }}}

    // }}}

    // {{{ WebDAV HTTP method wrappers

    // {{{ options

    /**
     * OPTIONS method handler
     *
     * Responds with DAV and Allow response headers based on the methods
     * actually implemented by this server instance
     *
     * @param options
     * @return void
     */
    function options(array &$options)
    {
        // get allowed methods
        $allowedMethods = $this->getAllowedMethods();

        // DAV response header
        $davHeader = array(1); // assume we are always DAV class 1 compliant
        if (in_array('LOCK', $allowedMethods)
                && in_array('UNLOCK', $allowedMethods)) {
            $davHeader[] = 2; // DAV class 2 requires locking
        }

        // tell clients what we found
        $this->setResponseHeader('Allow: ' . implode(',', $allowedMethods));
        $this->setResponseHeader('DAV: ' . implode(',', $davHeader));

        // Microsoft clients default to Frontpage protocol unless we tell them
        // to use WebDAV
        $this->setResponseHeader('MS-Author-Via: DAV');

        return true;
    }

    // }}}

    // {{{ options_wrapper

    /**
     * OPTIONS method wrapper
     *
     * @param void
     * @return void
     */
    function options_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // load request body DOM document
        $options['doc'] = new DOMDocument;
        $this->loadRequestBody($options['doc']);

        // analyze request body
        $options['xpath'] = new DOMXPath($options['doc']);
        $options['xpath']->registerNamespace('D', 'DAV:');

        $status = $this->options($options);

        $this->setResponseStatus($status);
    }

    // }}}

    // {{{ propfind_request_helper

    /**
     * PROPFIND request helper - prepare data-structures from PROPFIND requests
     *
     * @param options
     * @return void
     */
    function propfind_request_helper(array &$options)
    {
        // RFC2518 8.1: A client may submit a Depth header with a value of "0",
        // "1", or "infinity" with a PROPFIND on a collection resource with
        // internal member URIs.  DAV compliant servers MUST support the "0",
        // "1" and "infinity" behaviors.  By default, the PROPFIND method
        // without a Depth header MUST act as if a "Depth: infinity" header was
        // included.
        $options['depth'] = 'infinity';
        if (isset($_SERVER['HTTP_DEPTH'])) {
            $options['depth'] = $_SERVER['HTTP_DEPTH'];
        }

        // RFC3253 8.3: For certain methods (e.g. GET, PROPFIND), if the
        // request-URL identifies a version-controlled resource, a label can be
        // specified in a Label request header to cause the method to be
        // applied to the version selected by that label from the version
        // history of that version-controlled resource.
        if (isset($_SERVER['HTTP_LABEL'])) {
            $options['label'] = $_SERVER['HTTP_LABEL'];
        }

        $options['namespaces'] = array();

        // Microsoft needs this special namespace for date and time values
        $options['namespaces'][HTTP_WEBDAV_SERVER_DATATYPE_NAMESPACE] = 'T';

        // RFC2518 8.1: A client may submit a propfind XML element in the body
        // of the request method describing what information is being
        // requested.  It is possible to request particular property values,
        // all property values, or a list of the names of the resource's
        // properties.  A client may choose not to submit a request body.  An
        // empty PROPFIND request body MUST be treated as a request for the
        // names and values of all properties.
        if (empty($_SERVER['CONTENT_LENGTH'])) {
            $options['props'] = 'allprops';
            return true;
        }

        // load request body DOM document
        $options['doc'] = new DOMDocument;
        if (!$this->loadRequestBody($options['doc'])) {
            $this->setResponseStatus('400 Bad Request');
            return;
        }

        // analyze request body
        $options['xpath'] = new DOMXPath($options['doc']);
        $options['xpath']->registerNamespace('D', 'DAV:');

        $options['props'] = array();
        foreach ($options['xpath']->query('/D:propfind/D:prop/*') as $node) {
            $options['props'][] = $this->mkprop(
                $node->namespaceURI, $node->localName, null);

            // namespace handling
            if (empty($node->namespaceURI) || empty($node->prefix)) {
                continue;
            }

            // http://bugs.php.net/bug.php?id=42082
            //$options['namespaces'][$node->namespaceURI] = $node->prefix;
        }

        if (empty($options['props'])) {
            $options['props'] = $options['xpath']->evaluate(
                'local-name(/D:propfind/*)');
        }

        return true;
    }

    // }}}

    // {{{ propfind_response_helper

    /**
     * PROPFIND response helper - format PROPFIND response
     *
     * @param options
     * @param status
     * @return void
     */
    function propfind_response_helper(array $options, $status)
    {
        // set response status
        if (empty($status) || !is_array($status)) {
            $this->setResponseStatus($status, false);
            return;
        }

        $responses = array();

        // now loop over all returned files
        foreach ($status as $file) {
            $response = array();

            // copy to response
            foreach (array('path', 'pathComponents', 'url', 'score') as $key) {
                if (!empty($file[$key])) {
                    $response[$key] = $file[$key];
                }
            }

            $response['propstat'] = array();

            // $options['props'] is guaranteed to be set.  handle empty array
            // here.
            if (is_array($options['props'])) {

                // loop over all requested properties
                foreach ($options['props'] as $reqprop) {
                    $status = '200 OK';
                    $prop = $this->getProp($reqprop, $file, $options);

                    if (!empty($prop['status'])) {
                        $status = $prop['status'];
                    }

                    $response['propstat'][$status][] = $prop;

                    // namespace handling
                    if (empty($prop['namespace'])
                            || !empty($options['namespaces'][$prop['namespace']])) {
                        continue;
                    }

                    // register namespace
                    $options['namespaces'][$prop['namespace']] =
                        'ns' . count($options['namespaces']);
                }
            } else if (!empty($file['props']) && is_array($file['props'])) {

                // loop over all returned properties
                foreach ($file['props'] as $prop) {
                    $status = '200 OK';

                    if (!empty($prop['status'])) {
                        $status = $prop['status'];
                    }

                    if ($options['props'] == 'propname') {

                        // only names of all existing properties were requested
                        // so remove values
                        unset($prop['value']);
                    }

                    $response['propstat'][$status][] = $prop;

                    // namespace handling
                    if (empty($prop['namespace'])
                            || !empty($options['namespaces'][$prop['namespace']])) {
                        continue;
                    }

                    // register namespace
                    $options['namespaces'][$prop['namespace']] =
                        'ns' . count($options['namespaces']);
                }
            }

            if (!empty($file['status'])) {
                $response['status'] = $file['status'];
            }

            $responses[] = $response;
        }

        // Assume label support is implemented.  RFC3253 8.3: A server MUST
        // return an HTTP-1.1 Vary header containing Label in a successful
        // response to a cacheable request (e.g., GET) that includes a Label
        // header.
        if (isset($options['label'])) {
            $this->setResponseHeader('Vary: Label');
        }

        $this->multistatusResponseHelper($options, $responses);
    }

    // }}}

    // {{{ propfind_wrapper

    /**
     * PROPFIND method wrapper
     *
     * @param void
     * @return void
     */
    function propfind_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // prepare data-structure from PROPFIND request
        if (!$this->propfind_request_helper($options)) {
            return;
        }

        // call user handler
        $status = $this->propfind($options);

        // format PROPFIND response
        $this->propfind_response_helper($options, $status);
    }

    // }}}

    // {{{ proppatch_request_helper

    /**
     * PROPPATCH request helper - prepare data-structures from PROPPATCH requests
     *
     * @param options
     * @return void
     */
    function proppatch_request_helper(array &$options)
    {
        $options['namespaces'] = array();

        // Microsoft needs this special namespace for date and time values
        $options['namespaces'][HTTP_WEBDAV_SERVER_DATATYPE_NAMESPACE] = 'T';

        // load request body DOM document
        $options['doc'] = new DOMDocument;
        if (!$this->loadRequestBody($options['doc'])) {
            $this->setResponseStatus('400 Bad Request');
            return;
        }

        // analyze request body
        $options['xpath'] = new DOMXPath($options['doc']);
        $options['xpath']->registerNamespace('D', 'DAV:');

        $options['props'] = array();
        foreach ($options['xpath']->query('/D:propertyupdate/*') as $context) {
            foreach ($options['xpath']->query('/D:prop/*', $node) as $node) {
                $prop = $this->mkprop(
                    $node->namespaceURI, $node->localName, null);
                $prop[$context->localName] = $node->nodeValue;

                $options['props'][] = $prop;

                // namespace handling
                if (empty($node->namespaceURI) || empty($node->prefix)) {
                    continue;
                }

                // http://bugs.php.net/bug.php?id=42082
                //$options['namespaces'][$node->namespaceURI] = $node->prefix;
            }
        }

        return true;
    }

    // }}}

    // {{{ proppatch_response_helper

    /**
     * PROPPATCH response helper - format PROPPATCH response
     *
     * @param options
     * @param responsedescr
     * @return void
     */
    function proppatch_response_helper(array $options, $status)
    {
        // set response status
        if (empty($status) || !is_array($status)) {
            $this->setResponseStatus($status, false);
            return;
        }

        $file = $status;
        $response = array();

        // copy to response
        foreach (array('path', 'pathComponents', 'url', 'responsedescription') as $key) {
            if (!empty($file[$key])) {
                $response[$key] = $file[$key];
            }
        }

        $response['propstat'] = array();

        // loop over all requested properties
        foreach ($options['props'] as $reqprop) {
            $status = '200 OK';
            $prop = $this->getProp($reqprop, $file, $options);

            if (!empty($prop['status'])) {
                $status = $prop['status'];
            }

            $response['propstat'][$status][] = $prop;

            // namespace handling
            if (empty($prop['namespace'])
                    || !empty($options['namespaces'][$prop['namespace']])) {
                continue;
            }

            // register namespace
            $options['namespaces'][$prop['namespace']] =
                'ns' . count($options['namespaces']);
        }

        if (!empty($file['status'])) {
            $response['status'] = $file['status'];
        }

        $this->multistatusResponseHelper($options, array($response));
    }

    // }}}

    // {{{ proppatch_wrapper

    /**
     * PROPPATCH method wrapper
     *
     * @param void
     * @return void
     */
    function proppatch_wrapper()
    {
        // check resource is not locked
        if (!$this->check_locks_wrapper($this->pathComponents)) {
            $this->setResponseStatus('423 Locked');
            return;
        }

        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // perpare data-structure from PROPATCH request
        if (!$this->proppatch_request_helper($options)) {
            return;
        }

        // call user handler
        $status = $this->proppatch($options);

        // format PROPPATCH response
        $this->proppatch_response_helper($options, $status);
    }

    // }}}

    // {{{ mkcol_wrapper

    /**
     * MKCOL method wrapper
     *
     * @param void
     * @return void
     */
    function mkcol_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        $status = $this->mkcol($options);

        $this->setResponseStatus($status);
    }

    // }}}

    // {{{ get_request_helper

    /**
     * GET request helper - prepare data-structures from GET requests
     *
     * @param options
     * @return void
     */
    function get_request_helper(array &$options)
    {
        // RFC4918 8.4: Some of these new methods do not define bodies.
        // Servers MUST examine all requests for a body, even when a body was
        // not expected.  In cases where a request body is present but would be
        // ignored by a server, the server MUST reject the request with 415
        // (Unsupported Media Type).  This informs the client (which may have
        // been attempting to use an extension) that the body could not be
        // processed as the client intended.
        if (!empty($_SERVER['CONTENT_LENGTH'])) {
            $this->setResponseStatus('415 Unsupported Media Type');
            return;
        }

        // RFC3253 8.3: For certain methods (e.g. GET, PROPFIND), if the
        // request-URL identifies a version-controlled resource, a label can be
        // specified in a Label request header to cause the method to be
        // applied to the version selected by that label from the version
        // history of that version-controlled resource.
        if (isset($_SERVER['HTTP_LABEL'])) {
            $options['label'] = $_SERVER['HTTP_LABEL'];
        }

        $this->_get_ranges($options);

        return true;
    }

    /**
     * Parse Range request header
     *
     * @param  array options array to store result in
     * @return void
     */
    function _get_ranges(array &$options)
    {
        if (empty($_SERVER['HTTP_RANGE'])) {
            return;
        }

        // we support only standard bytes range specification
        if (!preg_match('/bytes\s*=\s*(.+)', $_SERVER['HTTP_RANGE'], $matches)) {
            return;
        }

        $options['ranges'] = array();

        // ranges are comma separated
        foreach (explode(',', $matches[1]) as $range) {
            // ranges are either from-to pairs or just end positions
            list ($start, $end) = explode('-', $range);
            $options['ranges'][] = ($start === '') ? array('last' => $end) : array('start' => $start, 'end' => $end);
        }
    }

    // }}}

    // {{{ get_response_helper

    /**
     * GET response helper - format GET response
     *
     * @param options
     * @param status
     * @return void
     */
    function get_response_helper(array $options, $status)
    {
        // set response headers before we start printing
        $this->setResponseStatus($status, false);

        if ($status !== true) {
            return;
        }

        if (empty($options['mimetype'])) {
            $options['mimetype'] = 'application/octet-stream';
        }
        $this->setResponseHeader('Content-Type: ' . $options['mimetype'], false);

        if (!empty($options['mtime'])) {
            $this->setResponseHeader('Last-Modified: '
                . gmdate('D, d M Y H:i:s', $options['mtime']) . 'GMT', false);
        }

        // Assume label support is implemented.  RFC3253 8.3: A server MUST
        // return an HTTP-1.1 Vary header containing Label in a successful
        // response to a cacheable request (e.g., GET) that includes a Label
        // header.
        if (isset($options['label'])) {
            $this->setResponseHeader('Vary: Label');
        }

        if (!empty($options['stream'])) {
            // GET handler returned a stream

            if (!empty($options['ranges'])
                    && (fseek($options['stream'], 0, SEEK_SET) === 0)) {
                // partial request and stream is seekable

                if (count($options['ranges']) == 1) {
                    $range = $options['ranges'][0];

                    if (!empty($range['start'])) {
                        fseek($options['stream'], $range['start'], SEEK_SET);
                        if (feof($options['stream'])) {
                            $this->setResponseStatus(
                                '416 Requested Range Not Satisfiable', false);
                            return;
                        }

                        if (!empty($range['end'])) {
                            $size = $range['end'] - $range['start'] + 1;
                            $this->setResponseStatus('206 Partial', false);
                            $this->setResponseHeader(
                                "Content-Length: $size", false);
                            $this->setResponseHeader(
                                "Content-Range: $range[start]-$range[end]/"
                                . (!empty($options['size']) ? $options['size'] : '*'), false);
                            while ($size && !feof($options['stream'])) {
                                $buffer = fread($options['stream'], 4096);
                                $size -= strlen($buffer);
                                echo $buffer;
                            }
                        } else {
                            $this->setResponseStatus('206 Partial', false);
                            if (!empty($options['size'])) {
                                $this->setResponseHeader("Content-Length: "
                                    . ($options['size'] - $range['start']), false);
                                $this->setResponseHeader(
                                    "Content-Range: $range[start]-$range[end]/"
                                    . (!empty($options['size']) ? $options['size'] : '*'), false);
                            }
                            fpassthru($options['stream']);
                        }
                    } else {
                        $this->setResponseHeader("Content-Length: $range[last]", false);
                        fseek($options['stream'], -$range['last'], SEEK_END);
                        fpassthru($options['stream']);
                    }
                } else {
                    $this->_multipart_byterange_header(); // init multipart
                    foreach ($options['ranges'] as $range) {

                        // TODO: What if size unknown?  500?
                        if (!empty($range['start'])) {
                            $from = $range['start'];
                            $to = !empty($range['end']) ? $range['end'] : $options['size'] - 1;
                        } else {
                            $from = $options['size'] - $range['last'] - 1;
                            $to = $options['size'] - 1;
                        }
                        $total = !empty($options['size']) ? $options['size'] : '*';
                        $size = $to - $from + 1;
                        $this->_multipart_byterange_header(
                            $options['mimetype'], $from, $to, $total);

                        fseek($options['stream'], $start, SEEK_SET);
                        while ($size && !feof($options['stream'])) {
                            $buffer = fread($options['stream'], 4096);
                            $size -= strlen($buffer);
                            echo $buffer;
                        }
                    }

                    // end multipart
                    $this->_multipart_byterange_header();
                }
            } else {
                // normal request or stream isn't seekable, return full content
                if (!empty($options['size'])) {
                    $this->setResponseHeader(
                        'Content-Length: ' . $options['size'], false);
                }

                fpassthru($options['stream']);
            }
        } else if (!empty($options['data']))  {
            if (is_array($options['data'])) {
                // reply to partial request
            } else {
                $this->setResponseHeader(
                    'Content-Length: ' . strlen($options['data']), false);
                echo $options['data'];
            }
        }
    }

    /**
     * Generate separator headers for multipart response
     *
     * First and last call happen without parameters to generate the initial
     * header and closing sequence, all calls inbetween require content
     * mimetype, start and end byte position and optionaly the total byte
     * length of the requested resource
     *
     * @param string mimetype
     * @param int start byte position
     * @param int end byte position
     * @param int total resource byte size
     */
    function _multipart_byterange_header($mimetype = false, $from = false, $to = false, $total = false)
    {
        if ($mimetype === false) {
            if (empty($this->multipart_separator)) {
                // init
                // a little naive, this sequence *might* be part of the content
                // but it's really not likely and rather expensive to check
                $this->multipart_separator = 'SEPARATOR_' . md5(microtime());

                $this->setResponseHeader(
                    'Content-Type: multipart/byteranges; boundary='
                    . $this->multipart_separator, false);
                return;
            }

            // end
            // generate closing multipart sequence
            echo "\n--{$this->multipart_separator}--";
            return;
        }

        // generate separator and header for next part
        echo "\n--{$this->multipart_separator}\n";
        echo "Content-Type: $mimetype\n";
        echo "Content-Range: $from-$to/"
            . ($total === false ? "*" : $total) . "\n\n";
    }

    // }}}

    // {{{ get_wrapper

    /**
     * GET method wrapper
     *
     * @param void
     * @return void
     */
    function get_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // perpare data-structure from GET request
        if (!$this->get_request_helper($options)) {
            return;
        }

        // call user handler
        $status = $this->get($options);

        // format GET response
        $this->get_response_helper($options, $status);
    }

    // }}}

    // {{{ head_wrapper

    /**
     * HEAD method wrapper
     *
     * @param void
     * @return void
     */
    function head_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // TODO: get_response_helper needn't do any output in case of HEAD
        // responses.  Is the advantage to optimizing it worthwhile?
        ob_start();

        // call user handler
        if (method_exists($this, 'head')) {
            $status = $this->head($options);
        } else {

            // emulate HEAD using GET
            $status = $this->get($options);
        }

        // format HEAD response
        $this->get_response_helper($options, $status);
        ob_end_clean();
    }

    // }}}

    // {{{ put_request_helper

    /**
     * PUT request helper - prepare data-structures from PUT requests
     *
     * @param options
     * @return void
     */
    function put_request_helper(array &$options)
    {
        // Content-Length may be zero
        if (!isset($_SERVER['CONTENT_LENGTH'])) {
            return;
        }
        $options['content_length'] = $_SERVER['CONTENT_LENGTH'];

        // default content type if none given
        $options['content_type'] = 'application/unknown';

        // get the content-type
        if (!empty($_SERVER['CONTENT_TYPE'])) {

            // for now we do not support any sort of multipart requests
            if (!strncmp($_SERVER['CONTENT_TYPE'], 'multipart/', 10)) {
                $this->setResponseStatus('501 Not Implemented');
                echo 'The service does not support mulipart PUT requests';
                return;
            }

            $options['content_type'] = $_SERVER['CONTENT_TYPE'];
        }

        // RFC2616 2.6: The recipient of the entity MUST NOT ignore any
        // Content-* (e.g. Content-Range) headers that it does not understand
        // or implement and MUST return a 501 (Not Implemented) response in
        // such cases.
        foreach ($_SERVER as $key => $value) {
            if (strncmp($key, 'HTTP_CONTENT', 11)) {
                continue;
            }

            switch ($key) {
            case 'HTTP_CONTENT_ENCODING': // RFC2616 14.11

                // TODO: Support this if ext/zlib filters are available
                $this->setResponseStatus('501 Not Implemented');
                echo "The service does not support '$value' content encoding";
                return;

            case 'HTTP_CONTENT_LANGUAGE': // RFC2616 14.12

                // we assume it is not critical if this one is ignored in the
                // actual PUT implementation
                $options['content_language'] = $value;
                break;

            case 'HTTP_CONTENT_LENGTH':

                // defined on IIS and has the same value as CONTENT_LENGTH
                break;

            case 'HTTP_CONTENT_LOCATION': // RFC2616 14.14

                // meaning of the Content-Location request header in PUT or
                // POST requests is undefined; servers are free to ignore it in
                // those cases
                break;

            case 'HTTP_CONTENT_RANGE': // RFC2616 14.16

                // single byte range requests are supported
                // the header format is also specified in RFC2616 14.16
                // TODO: Ensure that implementations support this or send 501
                // instead
                if (!preg_match('@bytes\s+(\d+)-(\d+)/((\d+)|\*)@', $value, $matches)) {
                    $this->setResponseStatus('400 Bad Request');
                    echo 'The service does only support single byte ranges';
                    return;
                }

                $range = array('start' => $matches[1], 'end' => $matches[2]);
                if (is_numeric($matches[3])) {
                    $range['total_length'] = $matches[3];
                }
                $option['ranges'][] = $range;

                // TODO: Make sure the implementation supports partial PUT
                // this has to be done in advance to avoid data being
                // overwritten on implementations that do not support this...
                break;

            case 'HTTP_CONTENT_MD5': // RFC2616 14.15

                // TODO: Maybe we can just pretend here?
                $this->setResponseStatus('501 Not Implemented');
                echo 'The service does not support content MD5 checksum verification';
                return;

            case 'HTTP_CONTENT_TYPE':

                // defined on IIS and has the same value as CONTENT_TYPE
                break;

            default:

                // any other unknown Content-* request headers
                $this->setResponseStatus('501 Not Implemented');
                echo 'The service does not support ' . $key;
                return;
            }
        }

        $options['stream'] = $this->openRequestBody();

        return true;
    }

    // }}}

    // {{{ put_response_helper

    /**
     * PUT response helper - format PUT response
     *
     * @param options
     * @param status
     * @return void
     */
    function put_response_helper(array $options, $status)
    {
        if (empty($status)) {
            $status = '403 Forbidden';
        } else if (is_resource($status)
                && get_resource_type($status) == 'stream') {
            $stream = $status;
            $status = '201 Created';
            if (isset($options['new']) && $options['new'] === false) {
                $status = '204 No Content';
            }

            if (!empty($options['ranges'])) {

                // TODO: Multipart support is missing (see also above)
                if (0 == fseek($stream, $range[0]['start'], SEEK_SET)) {
                    $length = $range[0]['end'] - $range[0]['start'] + 1;
                    if (!fwrite($stream, fread($options['stream'], $length))) {
                        $status = '403 Forbidden';
                    }
                } else {
                    $status = '403 Forbidden';
                }
            } else {
                while (!feof($options['stream'])) {
                    $buf = fread($options['stream'], 4096);
                    if (fwrite($stream, $buf) != 4096) {
                        break;
                    }
                }
            }

            fclose($stream);
        }

        $this->setResponseStatus($status);
    }

    // }}}

    // {{{ put_wrapper

    /**
     * PUT method wrapper
     *
     * @param void
     * @return void
     */
    function put_wrapper()
    {
        // check resource is not locked
        if (!$this->check_locks_wrapper($this->pathComponents)) {
            $this->setResponseStatus('423 Locked');
            return;
        }

        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // perpare data-structure from PUT request
        if (!$this->put_request_helper($options)) {
            return;
        }

        // call user handler
        $status = $this->put($options);

        // format PUT response
        $this->put_response_helper($options, $status);
    }

    // }}}

    // {{{ delete_wrapper

    /**
     * DELETE method wrapper
     *
     * @param void
     * @return void
     */
    function delete_wrapper()
    {
        // RFC2518 9.2: Please note, however, that it is always an error to
        // submit a value for the Depth header that is not allowed by the
        // method's definition.  Thus submitting a "Depth: 1" on a COPY, even
        // if the resource does not have internal members, will result in a 400
        // (Bad Request).  The method should fail not because the resource
        // doesn't have internal members, but because of the illegal value in
        // the header.
        if (isset($_SERVER['HTTP_DEPTH'])
                && $_SERVER['HTTP_DEPTH'] != 'infinity') {
            $this->setResponseStatus('400 Bad Request');
            return;
        }

        // check resource is not locked
        if (!$this->check_locks_wrapper($this->pathComponents)) {
            $this->setResponseStatus('423 Locked');
            return;
        }

        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // call user handler
        $status = $this->delete($options);
        if ($status === true) {
            $status = '204 No Content';
        }

        $this->setResponseStatus($status);
    }

    // }}}

    // {{{ copymove_request_helper

    /**
     * COPY/MOVE request helper - prepare data-structures from COPY/MOVE
     * requests
     *
     * @param options
     * @return void
     */
    function copymove_request_helper(array &$options)
    {
        // RFC4918 8.4: Some of these new methods do not define bodies.
        // Servers MUST examine all requests for a body, even when a body was
        // not expected.  In cases where a request body is present but would be
        // ignored by a server, the server MUST reject the request with 415
        // (Unsupported Media Type).  This informs the client (which may have
        // been attempting to use an extension) that the body could not be
        // processed as the client intended.
        if (!empty($_SERVER['CONTENT_LENGTH'])) {
            $this->setResponseStatus('415 Unsupported Media Type');
            return;
        }

        // RFC2518 8.8.3: The COPY method on a collection without a Depth
        // header MUST act as if a Depth header with value "infinity" was
        // included.  A client may submit a Depth header on a COPY on a
        // collection with a value of "0" or "infinity".  DAV compliant servers
        // MUST support the "0" and "infinity" Depth header behaviors.
        $options['depth'] = 'infinity';
        if (isset($_SERVER['HTTP_DEPTH'])) {
            $options['depth'] = $_SERVER['HTTP_DEPTH'];
        }

        // RFC2518 9.6, 8.8.4 and 8.9.3
        $options['overwrite'] = true;
        if (!empty($_SERVER['HTTP_OVERWRITE'])) {
            $options['overwrite'] = $_SERVER['HTTP_OVERWRITE'] == 'T';
        }

        $options['destinationUrlComponents'] = $this->parseUrl($_SERVER['HTTP_DESTINATION']);

        return true;
    }

    // }}}

    // {{{ copy_wrapper

    /**
     * COPY method wrapper
     *
     * @param void
     * @return void
     */
    function copy_wrapper()
    {
        // no need to check source is not locked

        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // perpare data-structure from COPY request
        if (!$this->copymove_request_helper($options)) {
            return;
        }

        // does the destination resource belong on this server?
        if ($this->isDescendentUrl($options['destinationUrlComponents'])) {
            $options['destinationPathComponents'] = array_slice(
                $options['destinationUrlComponents']['pathComponents'],
                count($this->baseUrlComponents['pathComponents']));

            // RFC4918 9.8.5: 403 (Forbidden) - The operation is forbidden.  A
            // special case for COPY could be that the source and destination
            // resources are the same resource.
            if ($options['destinationPathComponents'] == $this->pathComponents) {
                $this->setResponseStatus('403 Forbidden');
                return;
            }

            // check destination is not locked
            if (!$this->check_locks_wrapper($options['destinationPathComponents'])) {
                $this->setResponseStatus('423 Locked');
                return;
            }
        }

        // call user handler
        $status = $this->copy($options);
        if ($status === true) {
            $status = $options['new'] === false ? '204 No Content' :
                '201 Created';
        }

        $this->setResponseStatus($status);
    }

    // }}}

    // {{{ move_wrapper

    /**
     * MOVE method wrapper
     *
     * @param void
     * @return void
     */
    function move_wrapper()
    {
        // check resource is not locked
        if (!$this->check_locks_wrapper($this->pathComponents)) {
            $this->setResponseStatus('423 Locked');
            return;
        }

        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // perpare data-structure from MOVE request
        if (!$this->copymove_request_helper($options)) {
            return;
        }

        // does the destination resource belong on this server?
        if ($this->isDescendentUrl($options['destinationUrlComponents'])) {
            $options['destinationPathComponents'] = array_slice(
                $options['destinationUrlComponents']['pathComponents'],
                count($this->baseUrlComponents['pathComponents']));

            // RFC2518 8.8.5: Check source and destination are not the same -
            // data could be lost if overwrite is true
            if ($options['destinationPathComponents'] == $this->pathComponents) {
                $this->setResponseStatus('403 Forbidden');
                return;
            }

            // check destination is not locked
            if (!$this->check_locks_wrapper($options['destinationPathComponents'])) {
                $this->setResponseStatus('423 Locked');
                return;
            }
        }

        // call user handler
        $status = $this->move($options);
        if ($status === true) {
            $status = $options['new'] === false ? '204 No Content' :
                '201 Created';
        }

        $this->setResponseStatus($status);
    }

    // }}}

    // {{{ lock_request_helper

    /**
     * LOCK request helper - prepare data-structures from LOCK requests
     *
     * @param options
     * @return void
     */
    function lock_request_helper(array &$options)
    {
        // a LOCK request with an If request header but without a body is used
        // to refresh a lock.  Content-Lenght may be unset or zero.
        if (empty($_SERVER['CONTENT_LENGTH']) && !empty($_SERVER['HTTP_IF'])) {

            // FIXME: Refresh multiple locks?
            $options['update'] = substr($_SERVER['HTTP_IF'], 2, -2);

            return true;
        }

        // RFC2518 8.10.4: If no Depth header is submitted on a LOCK request
        // then the request MUST act as if a "Depth: infinity" had been
        // submitted.
        $options['depth'] = 'infinity';
        if (isset($_SERVER['HTTP_DEPTH'])) {

            // RFC2518 8.10.4: The Depth header may be used with the LOCK
            // method.  Values other than 0 or infinity MUST NOT be used with
            // the Depth header on a LOCK method.  All resources that support
            // the LOCK method MUST support the Depth header.
            if ($_SERVER['HTTP_DEPTH'] != 0
                    && $_SERVER['HTTP_DEPTH'] != 'infinity') {
                $this->setResponseStatus('400 Bad Request');
                return;
            }

            $options['depth'] = $_SERVER['HTTP_DEPTH'];
        }

        if (!empty($_SERVER['HTTP_TIMEOUT'])) {
            $options['timeout'] = explode(',', $_SERVER['HTTP_TIMEOUT']);
        }

        $options['namespaces'] = array();

        // load request body DOM document
        $options['doc'] = new DOMDocument;
        if (!$this->loadRequestBody($options['doc'])) {
            $this->setResponseStatus('400 Bad Request');
            return;
        }

        // analyze request body
        $options['xpath'] = new DOMXPath($options['doc']);
        $options['xpath']->registerNamespace('D', 'DAV:');

        $options['scope'] = $options['xpath']->evaluate(
            'local-name(/D:lockinfo/D:lockscope/*)');
        $options['scope'] = $options['xpath']->evaluate(
            'local-name(/D:lockinfo/D:locktype/*)');
        $options['owner'] = $options['xpath']->evaluate(
            'string(/D:lockinfo/D:owner/*)');

        $options['token'] = $this->getLockToken();

        return true;
    }

    // }}}

    // {{{ lock_response_helper

    /**
     * LOCK response helper - format LOCK response
     *
     * @param options
     * @param status
     * @return void
     */
    function lock_response_helper(array $options, $status)
    {
        if (!empty($options['locks']) && is_array($options['locks'])) {
            $this->setResponseStatus('409 Conflict');

            $responses = array();
            foreach ($options['locks'] as $lock) {
                $response = array();

                // copy to response
                foreach (array('path', 'pathComponents', 'url') as $key) {
                    if (!empty($lock[$key])) {
                        $response[$key] = $lock[$key];
                    }
                }

                $response['status'] = '423 Locked';

                $responses[] = $response;
            }

            $this->multistatusResponseHelper($options, $responses);

            return;
        }

        if (empty($status)) {
            $status = '423 Locked';
        }

        // set response headers before we start printing
        $this->setResponseStatus($status);

        if ($status === true || $status{0} == 2) { // 2xx status is OK
            $this->setResponseHeader('Content-Type: application/xml; charset="utf-8"');

            // RFC2518 8.10.1: In order to indicate the lock token associated
            // with a newly created lock, a Lock-Token response header MUST be
            // included in the response for every successful LOCK request for a
            // new lock.  Note that the Lock-Token header would not be returned
            // in the response for a successful refresh LOCK request because a
            // new lock was not created.
            if (empty($options['update']) || !empty($options['token'])) {
                $this->setResponseHeader('Lock-Token: <' . $options['token'] . '>');
            }

            $lock = array();
            foreach (array('scope', 'type', 'depth', 'owner') as $key) {
                $lock[$key] = $options[$key];
            }

            if (!empty($options['expires'])) {
                $lock['expires'] = $options['expires'];
            } else {
                $lock['timeout'] = $options['timeout'];
            }

            if (!empty($options['update'])) {
                $lock['token'] = $options['update'];
            } else {
                $lock['token'] = $options['token'];
            }

            echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
            echo "<D:prop xmlns:D=\"DAV:\">\n";
            echo "  <D:lockdiscovery>\n";
            echo '    ' . $this->activelocksResponseHelper(array($lock))
                . "\n";
            echo "  </D:lockdiscovery>\n";
            echo "</D:prop>\n";
        }
    }

    // }}}

    // {{{ lock_wrapper

    /**
     * LOCK method wrapper
     *
     * @param void
     * @return void
     */
    function lock_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // perpare data-structure from LOCK request
        if (!$this->lock_request_helper($options)) {
            return;
        }

        // check resource is not locked
        if (!empty($options['update'])
                && !$this->check_locks_wrapper(
                    $this->pathComponents, $options['scope'] == 'shared')) {
            $this->setResponseStatus('423 Locked');
            return;
        }

        $options['locks'] = $this->getDescendentsLocks($this->pathComponents);
        if (empty($options['locks'])) {

            // call user handler
            $status = $this->lock($options);
        }

        // format LOCK response
        $this->lock_response_helper($options, $status);
    }

    // }}}

    // {{{ unlock_request_helper

    /**
     * UNLOCK request helper - prepare data-structures from UNLOCK requests
     *
     * @param options
     * @return void
     */
    function unlock_request_helper(array &$options)
    {
        // RFC4918 8.4: Some of these new methods do not define bodies.
        // Servers MUST examine all requests for a body, even when a body was
        // not expected.  In cases where a request body is present but would be
        // ignored by a server, the server MUST reject the request with 415
        // (Unsupported Media Type).  This informs the client (which may have
        // been attempting to use an extension) that the body could not be
        // processed as the client intended.
        if (!empty($_SERVER['CONTENT_LENGTH'])) {
            $this->setResponseStatus('415 Unsupported Media Type');
            return;
        }

        // RFC4918 9.11.1: 400 (Bad Request) - No lock token was provided.
        if (empty($_SERVER['HTTP_LOCK_TOKEN'])) {
            $this->setResponseStatus('400 Bad Request');
            return;
        }

        // strip surrounding <>
        $options['token'] = substr(trim($_SERVER['HTTP_LOCK_TOKEN']), 1, -1);

        return true;
    }

    // }}}

    // {{{ unlock_wrapper

    /**
     * UNLOCK method wrapper
     *
     * @param void
     * @return void
     */
    function unlock_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // perpare data-structure from UNLOCK request
        if (!$this->unlock_request_helper($options)) {
            return;
        }

        // call user handler
        $status = $this->unlock($options);

        // RFC2518 8.11.1
        if ($status === true) {
            $status = '204 No Content';
        }

        $this->setResponseStatus($status);
    }

    // }}}

    // {{{ report_request_helper

    /**
     * REPORT request helper - prepare data-structures from REPORT requests
     *
     * @param options
     * @return void
     */
    function report_request_helper(array &$options)
    {
        // RFC3253 3.6: The request MAY include a Depth header.  If no Depth
        // header is included, Depth:0 is assumed.
        $options['depth'] = 'infinity';
        if (!empty($_SERVER['HTTP_DEPTH'])) {
            $options['depth'] = $_SERVER['HTTP_DEPTH'];
        }

        $options['namespaces'] = array();

        // Microsoft needs this special namespace for date and time values
        $options['namespaces'][HTTP_WEBDAV_SERVER_DATATYPE_NAMESPACE] = 'T';

        // load request body DOM document
        $options['doc'] = new DOMDocument;
        if (!$this->loadRequestBody($options['doc'])) {
            $this->setResponseStatus('400 Bad Request');
            return;
        }

        // analyze request body
        $options['xpath'] = new DOMXPath($options['doc']);
        $options['xpath']->registerNamespace('D', 'DAV:');

        $options['report'] = $options['xpath']->evaluate(
            'local-name()');

        return true;
    }

    // }}}

    // {{{ report

    /**
     * REPORT method handler
     *
     * @param options
     * @return void
     */
    function report(array &$options)
    {
        // detect requested method names
        $methodComponents = preg_split('/-/', strtolower($options['report']), -1, PREG_SPLIT_NO_EMPTY);

        $method = array_shift($methodComponents);
        foreach ($methodComponents as $methodComponent) {
            if ($methodComponent == 'report') {
                continue;
            }

            $method .= ucfirst($methodComponent);
        }
        $method .= 'Report';

        if (method_exists($this, $method)) {
            return call_user_func(array($this, $method), $options);
        }

        $options['props'] = array();
        foreach ($options['xpath']->query('/D:' . $options['report'] . '/D:prop/*') as $node) {
            $options['props'][] = $this->mkprop(
                $node->namespaceURI, $node->localName, null);

            // namespace handling
            if (empty($node->namespaceURI) || empty($node->prefix)) {
                continue;
            }

            // http://bugs.php.net/bug.php?id=42082
            //$options['namespaces'][$node->namespaceURI] = $node->prefix;
        }

        if (empty($options['props'])) {
            $options['props'] = $options['xpath']->evaluate(
                'local-name(/D:' . $options['report'] . '/*)');
        }

        // emulate REPORT using PROPFIND
        return $this->propfind($options);
    }

    // }}}

    // {{{ report_wrapper

    /**
     * REPORT method wrapper
     *
     * @param void
     * @return void
     */
    function report_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // prepare data-structure from REPORT request
        if (!$this->report_request_helper($options)) {
            return;
        }

        // call user handler
        $status = $this->report($options);

        // format REPORT response
        $this->propfind_response_helper($options, $status);
    }

    // }}}

    // {{{ search_request_helper

    /**
     * SEARCH request helper - prepare data-structures from SEARCH requests
     *
     * @param options
     * @return void
     */
    function search_request_helper(array &$options)
    {
        // RFC3253 3.6: The request MAY include a Depth header.  If no Depth
        // header is included, Depth:0 is assumed.
        $options['depth'] = 'infinity';
        if (!empty($_SERVER['HTTP_DEPTH'])) {
            $options['depth'] = $_SERVER['HTTP_DEPTH'];
        }

        $options['namespaces'] = array();

        // Microsoft needs this special namespace for date and time values
        $options['namespaces'][HTTP_WEBDAV_SERVER_DATATYPE_NAMESPACE] = 'T';

        // load request body DOM document
        $options['doc'] = new DOMDocument;
        if (!$this->loadRequestBody($options['doc'])) {
            $this->setResponseStatus('400 Bad Request');
            return;
        }

        // analyze request body
        $options['xpath'] = new DOMXPath($options['doc']);
        $options['xpath']->registerNamespace('D', 'DAV:');

        $options['props'] = array();
        foreach ($options['xpath']->query(
                '/D:searchrequest/D:basicsearch/D:select/D:prop/*') as $node) {
            $options['props'][] = $this->mkprop(
                $node->namespaceURI, $node->localName, null);

            // namespace handling
            if (empty($node->namespaceURI) || empty($node->prefix)) {
                continue;
            }

            // http://bugs.php.net/bug.php?id=42082
            //$options['namespaces'][$node->namespaceURI] = $node->prefix;
        }

        if (empty($options['props'])) {
            $options['props'] = $options['xpath']->evaluate(
                'local-name(/D:searchrequest/D:basicsearch/D:select/*)');
        }

        return true;
    }

    // {{{ search_wrapper

    /**
     * SEARCH method wrapper
     *
     * @param void
     * @return void
     */
    function search_wrapper()
    {
        $options = array();
        $options['pathComponents'] = $this->pathComponents;

        // prepare data-structure from SEARCH request
        if (!$this->search_request_helper($options)) {
            return;
        }

        // call user handler
        $status = $this->search($options);

        // format SEARCH response
        $this->propfind_response_helper($options, $status);
    }

    // }}}

    function multistatusResponseHelper(array $options, array $responses)
    {
        // now we generate the response header...
        $this->setResponseStatus('207 Multi-Status', false);
        $this->setResponseHeader('Content-Type: application/xml; charset="utf-8"');

        // ...and body
        $options['namespaces']['DAV:'] = 'D';
        asort($options['namespaces']);

        $namespaces = '';
        foreach ($options['namespaces'] as $namespace => $prefix) {
            $namespaces .= ' xmlns:' . $prefix . '="' . $namespace . '"';
        }

        echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
        echo "<D:multistatus$namespaces>\n";

        foreach ($responses as $response) {
            echo "  <D:response>\n";

            // print href
            if (empty($response['url'])) {
                $response['url'] = $this->getUrl($response);
            }
            echo "    <D:href>$response[url]</D:href>\n";

            // report all found properties and their values (if any)
            // nothing to do if no properties were returend for a file
            if (!empty($response['propstat'])
                    && is_array($response['propstat'])) {

                foreach ($response['propstat'] as $status => $props) {
                    echo "    <D:propstat>\n";
                    echo "      <D:prop>\n";

                    foreach ($props as $prop) {
                        if (!is_array($prop) || empty($prop['name'])) {
                            continue;
                        }

                        // empty properties (cannot use empty for check as '0'
                        // is a legal value here)
                        if (empty($prop['value']) && (!isset($prop['value'])
                                || $prop['value'] !== 0)) {
                            if ($prop['namespace'] == 'DAV:') {
                                echo "        <D:$prop[name]/>\n";
                                continue;
                            }

                            if (!empty($prop['namespace'])) {
                                echo '        <' . $options['namespaces'][$prop['namespace']] . ":$prop[name]/>\n";
                                continue;
                            }

                            echo "        <$prop[name] xmlns=\"\"/>\n";
                            continue;
                        }

                        // some WebDAV properties need special treatment
                        if ($prop['namespace'] == 'DAV:') {

                            switch ($prop['name']) {
                            case 'creationdate':
                                echo '        <D:creationdate ' . $options['namespaces'][HTTP_WEBDAV_SERVER_DATATYPE_NAMESPACE] . ':dt="dateTime.tz">' . gmdate('Y-m-d\TH:i:s\Z', $prop['value']) . "</D:creationdate>\n";
                                break;

                            case 'getlastmodified':
                                echo '        <D:getlastmodified ' . $options['namespaces'][HTTP_WEBDAV_SERVER_DATATYPE_NAMESPACE] . ':dt="dateTime.rfc1123">' . gmdate('D, d M Y H:i:s', $prop['value']) . " UTC</D:getlastmodified>\n";
                                break;

                            case 'resourcetype':
                                echo "        <D:resourcetype><D:$prop[value]/></D:resourcetype>\n";
                                break;

                            case 'supportedlock':

                                if (!empty($prop['value']) && is_array($prop['value'])) {
                                    $prop['value'] =
                                        $this->lockentriesResponseHelper(
                                            $prop['value']);
                                }
                                echo "        <D:supportedlock>\n";
                                echo "          $prop[value]\n";
                                echo "        </D:supportedlock>\n";
                                break;

                            case 'lockdiscovery':

                                if (!empty($prop['value']) && is_array($prop['value'])) {
                                    $prop['value'] =
                                        $this->activelocksResponseHelper(
                                            $prop['value']);
                                }
                                echo "        <D:lockdiscovery>\n";
                                echo "          $prop[value]\n";
                                echo "        </D:lockdiscovery>\n";
                                break;

case 'baseline-collection':
echo "        <D:baseline-collection><D:href>$prop[value]</D:href></D:baseline-collection>\n";
break;

case 'checked-in':
echo "        <D:checked-in><D:href>$prop[value]</D:href></D:checked-in>\n";
break;

case 'version-controlled-configuration':
echo "        <D:version-controlled-configuration><D:href>$prop[value]</D:href></D:version-controlled-configuration>\n";
break;

                            default:
                                echo "        <D:$prop[name]>" . $this->_prop_encode(htmlspecialchars($prop['value'])) . "</D:$prop[name]>\n";
                            }

                            continue;
                        }

                        if (!empty($prop['namespace'])) {
                            echo '        <' . $options['namespaces'][$prop['namespace']] . ":$prop[name]>" . $this->_prop_encode(htmlspecialchars($prop['value'])) . '</' . $options['namespaces'][$prop['namespace']] . ":$prop[name]>\n";

                            continue;
                        }

                        echo "        <$prop[name] xmlns=\"\">" . $this->_prop_encode(htmlspecialchars($prop['value'])) . "</$prop[name]>\n";
                    }

                    echo "      </D:prop>\n";
                    echo "      <D:status>HTTP/1.1 $status</D:status>\n";
                    echo "    </D:propstat>\n";
                }
            }

            if (!empty($response['responsedescription'])) {
                echo '    <D:responsedescription>' . $this->_prop_encode(htmlspecialchars($response['responsedescription'])) . "</D:responsedescription>\n";
            }

            if (!empty($response['status'])) {
                echo "    <D:status>HTTP/1.1 $response[status]</D:status>\n";
            }

if (!empty($response['score'])) {
    echo "    <D:score>$response[score]</D:score>\n";
}

            echo "  </D:response>\n";
        }

        echo "</D:multistatus>\n";
    }

    function activelocksResponseHelper(array $locks)
    {
        if (empty($locks) || !is_array($locks)) {
            return '';
        }

        foreach ($locks as $key => $lock) {
            if (empty($lock) || !is_array($lock)) {
                continue;
            }

            // check for 'timeout' or 'expires'
            $timeout = 'Infinite';
            if (!empty($lock['expires'])) {
                $timeout = 'Second-' . ($lock['expires'] - time());
            } else if (!empty($lock['timeout'])) {

                // more than a million is considered an absolute timestamp
                // less is more likely a relative value
                $timeout = "Second-$lock[timeout]";
                if ($lock['timeout'] > 1000000) {
                    $timeout = 'Second-' . ($lock['timeout'] - time());
                }
            }

            // genreate response block
            $locks[$key] = "<D:activelock>
            <D:lockscope><D:$lock[scope]/></D:lockscope>
            <D:locktype><D:$lock[type]/></D:locktype>
            <D:depth>" . ($lock['depth'] == 'infinity' ? 'Infinity' : $lock['depth']) . "</D:depth>
            <D:owner>$lock[owner]</D:owner>
            <D:timeout>$timeout</D:timeout>
            <D:locktoken><D:href>$lock[token]</D:href></D:locktoken>
          </D:activelock>";
        }

        return implode('', $locks);
    }

    function lockentriesResponseHelper(array $locks)
    {
        if (empty($locks) || !is_array($locks)) {
            return '';
        }

        foreach ($locks as $key => $lock) {
            if (empty($lock) || !is_array($lock)) {
                continue;
            }

            $locks[$key] = "<D:lockentry>
            <D:lockscope><D:$lock[scope]/></D:lockscope>
            <D:locktype><D:$lock[type]/></D:locktype>
          </D:lockentry>";
        }

        return implode('', $locks);
    }

    function getUrl($urlComponents=null, $baseUrlComponents=null, array $options=array())
    {
        $urlComponents = $this->getUrlComponents($urlComponents, $baseUrlComponents, $options);

        $url = '';
        if (!empty($options['absoluteUrl'])
                && !empty($urlComponents['scheme'])
                && !empty($urlComponents['host'])) {
            $url = $urlComponents['scheme'] . '://' . $urlComponents['host'];

            // hide default port
            if (!empty($urlComponents['port'])
                    && $urlComponents['port'] != getservbyname($urlComponents['scheme'], 'tcp')) {
                $url .= ':' . $urlComponents['port'];
            }
        }

        $url .= '/' . implode('/', $urlComponents['pathComponents']);

        return $url;
    }

    function getUrlComponents($urlComponents=null, $baseUrlComponents=null, array $options=array())
    {
        if (!isset($baseUrlComponents)) {
            $baseUrlComponents = $this->baseUrlComponents;
        }

        foreach (array('scheme', 'host', 'port') as $component) {
            if (empty($urlComponents[$component]) && !empty($baseUrlComponents[$component])) {
                $urlComponents[$component] = $baseUrlComponents[$component];
            }
        }

        if (empty($urlComponents['pathComponents'])) {
            $urlComponents['pathComponents'] = array();
        }

        if (!empty($urlComponents['path'])) {
            $urlComponents['pathComponents'] = preg_split('/\//', $urlComponents['path'], -1, PREG_SPLIT_NO_EMPTY);
        }

        if (!empty($baseUrlComponents['pathComponents'])) {
            $urlComponents['pathComponents'] = array_merge($baseUrlComponents['pathComponents'], $urlComponents['pathComponents']);
        }

        return $urlComponents;
    }

    function isDescendentUrl($urlComponents, $baseUrlComponents=null)
    {
        if (!isset($baseUrlComponents)) {
            $baseUrlComponents = $this->baseUrlComponents;
        }

        // set default port for descendent
        if (!empty($urlComponents['scheme']) && empty($urlComponents['port'])) {
            $urlComponents['port'] = getservbyname($urlComponents['scheme'], 'tcp');
        }

        // set default port for ancestor
        if (!empty($baseUrlComponents['scheme']) && empty($baseUrlComponents['port'])) {
            $baseUrlComponents['port'] = getservbyname($baseUrlComponents['scheme'], 'tcp');
        }

        // if descendent has scheme, host or port, check it matches ancestor
        foreach (array('scheme', 'host', 'port') as $component) {
            if (!empty($urlComponents[$component])
                    && (empty($baseUrlComponents[$component])
                        || $urlComponents[$component] != $baseUrlComponents[$component])) {
                return false;
            }
        }

        // if ancestor has path components and descendent has path components,
        // check that descendent path components start with ancestor path
        // components
        if (!empty($baseUrlComponents['pathComponents'])
                && (empty($urlComponents['pathComponents'])
                    || array_slice($urlComponents['pathComponents'], 0, count($baseUrlComponents['pathComponents'])) != $baseUrlComponents['pathComponents'])) {
            return false;
        }

        // if ancestor has query string and descendent has query string, check
        // that descendent has all ancestor query components
        if (!empty($baseUrlComponents['query'])) {
            if (empty($urlComponents['query'])) {
                return false;
            }

            $queryComponents = preg_split('/&/', $urlComponents['query'], -1, PREG_SPLIT_NO_EMPTY);
            $baseQueryComponents = preg_split('/&/', $baseUrlComponents['query'], -1, PREG_SPLIT_NO_EMPTY);
            foreach ($baseQueryComponents as $queryComponent) {
                if (!in_array($queryComponent, $queryComponents)) {
                    return false;
                }
            }
        }

        return true;
    }

    function parseUrl($url)
    {
        $urlComponents = parse_url($url);

        if (!empty($urlComponents['scheme']) && empty($urlComponents['port'])) {
            $urlComponents['port'] = getservbyname($urlComponents['scheme'], 'tcp');
        }

        $urlComponents['pathComponents'] = array();
        if (!empty($urlComponents['path'])) {
            $urlComponents['pathComponents'] = preg_split('/\//', $urlComponents['path'], -1, PREG_SPLIT_NO_EMPTY);
        }

        return $urlComponents;
    }

    function getProp($reqprop, $file, $options)
    {
        // check if property exists in response
        if (!empty($file['props'])) {
            foreach ($file['props'] as $prop) {
                if ($reqprop['name'] == $prop['name']
                        && $reqprop['namespace'] == $prop['namespace']) {
                    return $prop;
                }
            }
        }

        if ($reqprop['name'] == 'lockdiscovery'
                && $reqprop['namespace'] == 'DAV:'
                && method_exists($this, 'getLocks')) {
            return $this->mkprop('DAV:', 'lockdiscovery',
                $this->getLocks($file['pathComponents']));
        }

        // in case the requested property had a value, like calendar-data
        unset($reqprop['value']);
        $reqprop['status'] = '404 Not Found';

        return $reqprop;
    }

    function getDescendentsLocks(array $pathComponents)
    {
        $options = array();
        $options['pathComponents'] = $pathComponents;
        $options['depth'] = 'infinity';
        $options['props'] = array();
        $options['props'][] = $this->mkprop('DAV:', 'lockdiscovery', null);

        // call user handler
        return $this->propfind($options);
    }

    // {{{ getAllowedMethods()

    /**
     * Get allowed methods
     *
     * @param void
     * @return array of allowed methods
     */
    function getAllowedMethods()
    {
        $allowedMethods = array();

        // all other methods need both a method_wrapper() and a method()
        // implementation
        // the base class defines only wrappers
        foreach (get_class_methods($this) as $method) {

            // strncmp breaks with negative len -
            // http://bugs.php.net/bug.php?id=36944
            //if (!strncmp('_wrapper', $method, -8)) {
            if (strcmp(substr($method, -8), '_wrapper')) {
                continue;
            }

            $method = strtolower(substr($method, 0, -8));
            if (!method_exists($this, $method)) {
                continue;
            }

            if (($method == 'lock' || $method == 'unlock')
                    && !method_exists($this, 'getLocks')) {
                continue;
            }

            $allowedMethods[] = strtoupper($method);

            // emulate HEAD using GET
            if ($method == 'get') {
                $allowedMethods[] = 'HEAD';
            }
        }

        return $allowedMethods;
    }

    // }}}

    // {{{ mkprop

    /**
     * Helper for property element creation
     *
     * @param string XML namespace (optional)
     * @param string property name
     * @param string property value
     * @return array property array
     */
    function mkprop()
    {
        $args = func_get_args();

        $prop = array();
        $prop['namespace'] = 'DAV:';
        if (count($args) > 2) {
            $prop['namespace'] = array_shift($args);
        }

        $prop['name'] = array_shift($args);
        $prop['value'] = array_shift($args);
        $prop['status'] = array_shift($args);

        return $prop;
    }

    // }}}

    // {{{ check_auth_wrapper

    /**
     * Check authentication if implemented
     *
     * @param void
     * @return boolean true if authentication succeded or not necessary
     */
    function check_auth_wrapper()
    {
        if (method_exists($this, 'checkAuth')) {

            // PEAR style method name
            return $this->checkAuth(@$_SERVER['AUTH_TYPE'],
                @$_SERVER['PHP_AUTH_USER'],
                @$_SERVER['PHP_AUTH_PW']);
        }

        if (method_exists($this, 'check_auth')) {

            // old (pre 1.0) method name
            return $this->check_auth(@$_SERVER['AUTH_TYPE'],
                @$_SERVER['PHP_AUTH_USER'],
                @$_SERVER['PHP_AUTH_PW']);
        }

        // no method found -> no authentication required
        return true;
    }

    // }}}

    // {{{ UUID stuff

    /**
     * Get new Universally Unique Identifier
     *
     * @param void
     * @return string new Universally Unique Identifier
     */
    function uuid_create()
    {
        // use uuid extension from PECL if available
        if (function_exists('uuid_create')) {
            return uuid_create();
        }

        // fallback
        $uuid = md5(microtime() . getmypid()); // this should be random enough for now

        // set variant and version fields for true random uuid
        $uuid{12} = '4';
        $n = 8 + (ord($uuid{16}) & 3);
        $hex = '0123456789abcdef';
        $uuid{16} = $hex{$n};

        // return formated uuid
        return substr($uuid,  0, 8)
            . '-' . substr($uuid,  8, 4)
            . '-' . substr($uuid, 12, 4)
            . '-' . substr($uuid, 16, 4)
            . '-' . substr($uuid, 20);
    }

    /**
     * Get unique lock token
     *
     * @param void
     * @return string unique lock token
     */
    function getLockToken()
    {
        // RFC4918 6.5: This specification encourages servers to create
        // Universally Unique Identifiers (UUIDs) for lock tokens, and to use
        // the URI form defined by "A Universally Unique Identifier (UUID) URN
        // Namespace" ([RFC4122]).
        return 'urn:uuid:' . $this->uuid_create();
    }

    // }}}

    // {{{ If request header

    /**
     *
     *
     * @param string to parse
     * @param int current parsing position
     * @return array next token (type and value)
     */
    function _if_header_lexer($str, &$pos)
    {
        $len = strlen($str);

        // skip whitespace
        do {
            if ($pos >= $len) {
                return;
            }
        } while (ctype_space($chr = substr($str, $pos++, 1)));

        // check character
        switch ($chr) {

            // State tokens enclosed in <...>
            case '<':
                $stateToken = substr($str, $pos, strpos($str, '>', $pos) - $pos);
                $pos += strlen($stateToken) + 1;
                return array('URI', $stateToken);

            // Entity tags enclosed in [...]
            case '[':
                $type = 'ETAG_STRONG';
                if (substr($str, $pos, 1) == 'W') {
                    $type = 'ETAG_WEAK';
                    $pos += 2;
                }

                $entityTag = substr($str, $pos, strpos($str, ']', $pos) - $pos);
                $pos += strlen($entityTag) + 1;
                return array($type, $entityTag);

            // 'N' indicates negation
            case 'N':
                $pos += 2;
                return array('NOT', 'Not');
        }

        // anything else is returned verbatim
        return array('CHAR', $chr);
    }

    /**
     * Parse If request header
     *
     * @param string to parse
     * @return array If header components
     */
    function _if_header_parser($str)
    {
        $ifHeaderComponents = array();

        // parsed URLs are path absolute
        $baseUrlComponents = $this->getUrlComponents();
        $baseUrlComponents['pathComponents'] = null;

        $pos = 0;
        $len = strlen($str);

        while ($pos < $len) {

            // get next token
            $token = $this->_if_header_lexer($str, $pos);

            $urlComponents = array();
            if ($token[0] == 'URI') {
                // normalize URL
                $urlComponents = $this->parseUrl($token[1]);

                // get next token
                $token = $this->_if_header_lexer($str, $pos);
            }
            $url = $this->getUrl($urlComponents, $baseUrlComponents, array('absoluteUrl' => true));

            // sanity check
            if ($token[0] != 'CHAR' || $token[1] != '(') {
                return;
            }

            $list = array();
            while ($pos < $len) {

                // get next token
                $token = $this->_if_header_lexer($str, $pos);

                if ($token[0] == 'CHAR' && $token[1] == ')') {
                    break;
                }

                $not = '';
                if ($token[0] == 'NOT') {
                    $not = '!';

                    // get next token
                    $token = $this->_if_header_lexer($str, $pos);
                }

                switch ($token[0]) {
                    case 'URI':
                        $list[] = $not . '<' . $token[1] . '>';
                        break;

                    case 'ETAG_WEAK':
                        $list[] = $not . '[W/"' . $token[1] . '"]';
                        break;

                    case 'ETAG_STRONG':
                        $list[] = $not . '["' . $token[1] . '"]';
                        break;
                }
            }

            // RFC4918 10.4.3: A Condition that consists of a single entity-tag
            // or state-token evaluates to true if the resource matches the
            // described state (where the individual matching functions are
            // defined below in Section 10.4.4).  Prefixing it with "Not"
            // reverses the result of the evaluation (thus, the "Not" applies
            // only to the subsequent entity-tag or state-token).
            //
            // Each List production describes a series of conditions.  The
            // whole list evaluates to true if and only if each condition
            // evaluates to true (that is, the list represents a logical
            // conjunction of Conditions).
            //
            // Each No-tag-list and Tagged-list production may contain one or
            // more Lists.  They evaluate to true if and only if any of the
            // contained lists evaluates to true (that is, if there's more than
            // one List, that List sequence represents a logical disjunction of
            // the Lists).
            //
            // Finally, the whole If header evaluates to true if and only if at
            // least one of the No-tag-list or Tagged-list productions
            // evaluates to true.  If the header evaluates to false, the server
            // MUST reject the request with a 412 (Precondition Failed) status.
            // Otherwise, execution of the request can proceed as if the header
            // wasn't present.
            $ifHeaderComponents[$url][] = $list;
        }

        return $ifHeaderComponents;
    }

    /**
     * Check If request header
     *
     * @param array If request header components
     * @return boolean
     */
    function check_if_helper(array $ifHeaderComponents)
    {
        // RFC4918 10.4.1: The first purpose is to make a request conditional
        // by supplying a series of state lists with conditions that match
        // tokens and ETags to a specific resource.  If this header is
        // evaluated and all state lists fail, then the request MUST fail with
        // a 412 (Precondition Failed) status.  On the other hand, the request
        // can succeed only if one of the described state lists succeeds.  The
        // success criteria for state lists and matching functions are defined
        // in Sections 10.4.3 and 10.4.4.
        if (empty($ifHeaderComponents)) {
            return true;
        }

        // any match is ok
        foreach ($ifHeaderComponents as $url => $lists) {

            // all must match
            foreach ($list as $condition) {

                // lock tokens may be free form (RFC2518 6.3)
                // but if opaquelocktokens are used (RFC2518 6.4)
                // we have to check the format (litmus tests this)
                if (!strncmp($condition, '<opaquelocktoken:', strlen('<opaquelocktoken'))) {
                    if (!preg_match('/^<opaquelocktoken:[[:xdigit:]]{8}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{12}>$/', $condition)) {
                        return;
                    }
                }

                if (!$this->_check_uri_condition($url, $condition)) {
                    continue 2;
                }
            }

            return true;
        }
    }

    /**
     * Check a single URL condition from If request header
     *
     * @abstract
     * @param string URL to check
     * @param string condition to check for this URL
     * @return boolean
     */
    function _check_uri_condition($url, $condition)
    {
        // not really implemented here, implementations must override
        return true;
    }

    /**
     * For each lock, check that the lock token was submitted in the If request
     * header.  If requesting a shared lock, check only exclusive locks.
     *
     * @param array of locks
     * @param array if request header components
     * @param boolean check only exclusive locks
     * @return boolean true if the request is allowed
     */
    function check_locks_helper(array $locks, array $ifHeaderComponents, $shared=false)
    {
        foreach ($locks as $lock) {
            if ($shared && ($lock['scope'] == 'shared')) {
                continue;
            }

            // RFC4918 10.4.4: A lock state token is considered to match if the
            // resource is anywhere in the scope of the lock.
            if ($lock['depth'] === 0) {
                $lists = $ifHeaderComponents[$this->getUrl($lock, null, array('absoluteUrl' => true))];
                foreach ($lists as $list) {
                    if (in_array('<' . $lock['token'] . '>', $list)) {
                        continue 2;
                    }
                }

                return false;
            }

            foreach ($ifHeaderComponents as $url => $lists) {
                if (!$this->isDescendentUrl($this->parseUrl($url), $this->getUrlComponents($lock))) {
                    continue;
                }

                foreach ($lists as $list) {
                    if (in_array('<' . $lock['token'] . '>', $list)) {
                        continue 3;
                    }
                }
            }

            return false;
        }

        return true;
    }

    /**
     * @param array path components to check
     * @param boolean check only exclusive locks
     */
    function check_locks_wrapper(array $pathComponents, $shared=false)
    {
        if (!method_exists($this, 'getLocks')) {
            return true;
        }

        return $this->check_locks_helper($this->getLocks($pathComponents),
            $this->ifHeaderComponents, $shared);
    }

    // }}}

    /**
     * Open request body input stream
     *
     * Because it's not possible to write to php://input (unlike the potential
     * to set request variables) and not possible until PHP 5.1 to register
     * alternative stream wrappers with php:// URLs, this function enables
     * sub-classes to override the request body.  Gallery uses this for unit
     * testing.  This function also collects all instances of opening the
     * request body in one place.
     *
     * @return resource request body input stream
     */
    function openRequestBody()
    {
        return fopen('php://input', 'rb');
    }

    /**
     * Load request body DOM document
     *
     * @return object DOMDocument request body DOM document
     */
    function loadRequestBody(DOMDocument $doc)
    {
        // libxml2 correctly reports a notice on DAV: namespace:
        // http://bugzilla.gnome.org/show_bug.cgi?id=457559
        $errorReporting = ini_get('error_reporting');
        ini_set('error_reporting', $errorReporting & ~E_NOTICE);

        if (!$doc->load('php://input')) {
            ini_set('error_reporting', $errorReporting);
            return;
        }

        ini_set('error_reporting', $errorReporting);
        return $doc;
    }

    /**
     * Set HTTP response header
     *
     * This function enables sub-classes to override header-setting.  Gallery
     * uses this to avoid replacing headers elsewhere in the application, and
     * for testability.
     *
     * @param string status code and message
     * @return void
     */
    function setResponseHeader($header, $replace=true)
    {
        $key = 'status';
        if (strncasecmp($header, 'HTTP/', 5) !== 0) {
            $key = strtolower(substr($header, 0, strpos($header, ':')));
        }

        if ($replace || empty($this->responseHeaders[$key])) {
            header($header);
            $this->responseHeaders[$key] = $header;
        }
    }

    /**
     * Set HTTP response status and mirror it in a private header
     *
     * @param string status code and message
     * @return void
     */
    function setResponseStatus($status, $replace=true)
    {
        // failure
        if (empty($status)) {
            $status = '404 Not Found';
        }

        // success
        if ($status === true) {
            $status = '200 OK';
        }

        // generate HTTP status response
        $this->setResponseHeader('HTTP/1.1 ' . $status, $replace);
        $this->setResponseHeader('X-WebDAV-Status: ' . $status, $replace);
    }

    /**
     * Private minimalistic version of PHP urlencode
     *
     * Only blanks and XML special chars must be encoded here.  Full urlencode
     * encoding confuses some clients.
     *
     * @param string URL to encode
     * @return string encoded URL
     */
    function _urlencode($url)
    {
        return strtr($url, array(' ' => '%20',
                '&' => '%26',
                '<' => '%3C',
                '>' => '%3E'));
    }

    /**
     * Private version of PHP urldecode
     *
     * Not really needed but added for completenes.
     *
     * @param string URL to decode
     * @return string decoded URL
     */
    function _urldecode($path)
    {
        return urldecode($path);
    }

    /**
     * UTF-8 encode property values if not already done so
     *
     * @param string text to encode
     * @return string UTF-8 encoded text
     */
    function _prop_encode($text)
    {
        switch (strtolower($this->_prop_encoding)) {
        case 'utf-8':
            return $text;
        case 'iso-8859-1':
        case 'iso-8859-15':
        case 'latin-1':
        default:
            return utf8_encode($text);
        }
    }
}

// Local variables:
// tab-width: 4
// c-basic-offset: 4
// End:
