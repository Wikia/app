# Changelog

## 0.7.4 (2017-08-16)

*   Improvement: Target evenement 3.0 a long side 2.0 and 1.0
    (#212 by @WyriHaximus)

## 0.7.3 (2017-08-14)

*   Feature: Support `Throwable` when setting previous exception from server callback
    (#155 by @jsor)

*   Fix: Fixed URI parsing for origin-form requests that contain scheme separator
    such as `/path?param=http://example.com`.
    (#209 by @aaronbonneau)

*   Improve test suite by locking Travis distro so new defaults will not break the build
    (#211 by @clue)

## 0.7.2 (2017-07-04)

*   Fix: Stricter check for invalid request-line in HTTP requests
    (#206 by @clue)

*   Refactor to use HTTP response reason phrases from response object
    (#205 by @clue)

## 0.7.1 (2017-06-17)

*   Fix: Fix parsing CONNECT request without `Host` header
    (#201 by @clue)

*   Internal preparation for future PSR-7 `UploadedFileInterface`
    (#199 by @WyriHaximus)

## 0.7.0 (2017-05-29)

*   Feature / BC break: Use PSR-7 (http-message) standard and
    `Request-In-Response-Out`-style request handler callback.
    Pass standard PSR-7 `ServerRequestInterface` and expect any standard
    PSR-7 `ResponseInterface` in return for the request handler callback.
    (#146 and #152 and #170 by @legionth)
    
    ```php
    // old
    $app = function (Request $request, Response $response) {
        $response->writeHead(200, array('Content-Type' => 'text/plain'));
        $response->end("Hello world!\n");
    };

    // new
    $app = function (ServerRequestInterface $request) {
        return new Response(
            200,
            array('Content-Type' => 'text/plain'),
            "Hello world!\n"
        );
    };
    ```

    A `Content-Length` header will automatically be included if the size can be
    determined from the response body.
    (#164 by @maciejmrozinski)

    The request handler callback will automatically make sure that responses to
    HEAD requests and certain status codes, such as `204` (No Content), never
    contain a response body.
    (#156 by @clue)

    The intermediary `100 Continue` response will automatically be sent if
    demanded by a HTTP/1.1 client.
    (#144 by @legionth)

    The request handler callback can now return a standard `Promise` if
    processing the request needs some time, such as when querying a database.
    Similarly, the request handler may return a streaming response if the
    response body comes from a `ReadableStreamInterface` or its size is
    unknown in advance.

    ```php
    // old
    $app = function (Request $request, Response $response) use ($db) {
        $db->query()->then(function ($result) use ($response) {
            $response->writeHead(200, array('Content-Type' => 'text/plain'));
            $response->end($result);
        });
    };

    // new
    $app = function (ServerRequestInterface $request) use ($db) {
        return $db->query()->then(function ($result) {
            return new Response(
                200,
                array('Content-Type' => 'text/plain'),
                $result
            );
        });
    };
    ```

    Pending promies and response streams will automatically be canceled once the
    client connection closes.
    (#187 and #188 by @clue)

    The `ServerRequestInterface` contains the full effective request URI,
    server-side parameters, query parameters and parsed cookies values as
    defined in PSR-7.
    (#167 by @clue and #174, #175 and #180 by @legionth)

    ```php
    $app = function (ServerRequestInterface $request) {
        return new Response(
            200,
            array('Content-Type' => 'text/plain'),
            $request->getUri()->getScheme()
        );
    };
    ```

    Advanced: Support duplex stream response for `Upgrade` requests such as
    `Upgrade: WebSocket` or custom protocols and `CONNECT` requests
    (#189 and #190 by @clue)

    >   Note that the request body will currently not be buffered and parsed by
        default, which depending on your particilar use-case, may limit
        interoperability with the PSR-7 (http-message) ecosystem.
        The provided streaming request body interfaces allow you to perform
        buffering and parsing as needed in the request handler callback.
        See also the README and examples for more details.

*   Feature / BC break: Replace `request` listener with callback function and
    use `listen()` method to support multiple listening sockets
    (#97 by @legionth and #193 by @clue)

    ```php
    // old
    $server = new Server($socket);
    $server->on('request', $app);

    // new
    $server = new Server($app);
    $server->listen($socket);
    ```

*   Feature: Support the more advanced HTTP requests, such as 
    `OPTIONS * HTTP/1.1` (`OPTIONS` method in asterisk-form),
    `GET http://example.com/path HTTP/1.1` (plain proxy requests in absolute-form),
    `CONNECT example.com:443 HTTP/1.1` (`CONNECT` proxy requests in authority-form)
    and sanitize `Host` header value across all requests.
    (#157, #158, #161, #165, #169 and #173 by @clue)

*   Feature: Forward compatibility with Socket v1.0, v0.8, v0.7 and v0.6 and
    forward compatibility with Stream v1.0 and v0.7
    (#154, #163, #183, #184 and #191 by @clue)

*   Feature: Simplify examples to ease getting started and
    add benchmarking example
    (#151 and #162 by @clue)

*   Improve test suite by adding tests for case insensitive chunked transfer
    encoding and ignoring HHVM test failures until Travis tests work again.
    (#150 by @legionth and #185 by @clue)

## 0.6.0 (2017-03-09)

*   Feature / BC break: The `Request` and `Response` objects now follow strict
    stream semantics and their respective methods and events.
    (#116, #129, #133, #135, #136, #137, #138, #140, #141 by @legionth
    and #122, #123, #130, #131, #132, #142 by @clue)

    This implies that the `Server` now supports proper detection of the request
    message body stream, such as supporting decoding chunked transfer encoding,
    delimiting requests with an explicit `Content-Length` header
    and those with an empty request message body.

    These streaming semantics are compatible with previous Stream v0.5, future
    compatible with v0.5 and upcoming v0.6 versions and can be used like this:

    ```php
    $http->on('request', function (Request $request, Response $response) {
        $contentLength = 0;
        $request->on('data', function ($data) use (&$contentLength) {
            $contentLength += strlen($data);
        });

        $request->on('end', function () use ($response, &$contentLength){
            $response->writeHead(200, array('Content-Type' => 'text/plain'));
            $response->end("The length of the submitted request body is: " . $contentLength);
        });

        // an error occured
        // e.g. on invalid chunked encoded data or an unexpected 'end' event 
        $request->on('error', function (\Exception $exception) use ($response, &$contentLength) {
            $response->writeHead(400, array('Content-Type' => 'text/plain'));
            $response->end("An error occured while reading at length: " . $contentLength);
        });
    });
    ```

    Similarly, the `Request` and `Response` now strictly follow the
    `close()` method and `close` event semantics.
    Closing the `Request` does not interrupt the underlying TCP/IP in
    order to allow still sending back a valid response message.
    Closing the `Response` does terminate the underlying TCP/IP
    connection in order to clean up resources.

    You should make sure to always attach a `request` event listener
    like above. The `Server` will not respond to an incoming HTTP
    request otherwise and keep the TCP/IP connection pending until the
    other side chooses to close the connection.

*   Feature: Support `HTTP/1.1` and `HTTP/1.0` for `Request` and `Response`.
    (#124, #125, #126, #127, #128 by @clue and #139 by @legionth)

    The outgoing `Response` will automatically use the same HTTP version as the
    incoming `Request` message and will only apply `HTTP/1.1` semantics if
    applicable. This includes that the `Response` will automatically attach a
    `Date` and `Connection: close` header if applicable.

    This implies that the `Server` now automatically responds with HTTP error
    messages for invalid requests (status 400) and those exceeding internal
    request header limits (status 431).

## 0.5.0 (2017-02-16)

* Feature / BC break: Change `Request` methods to be in line with PSR-7
  (#117 by @clue)
  * Rename `getQuery()` to `getQueryParams()`
  * Rename `getHttpVersion()` to `getProtocolVersion()`
  * Change `getHeaders()` to always return an array of string values
    for each header

* Feature / BC break: Update Socket component to v0.5 and
  add secure HTTPS server support
  (#90 and #119 by @clue)

  ```php
  // old plaintext HTTP server
  $socket = new React\Socket\Server($loop);
  $socket->listen(8080, '127.0.0.1');
  $http = new React\Http\Server($socket);

  // new plaintext HTTP server
  $socket = new React\Socket\Server('127.0.0.1:8080', $loop);
  $http = new React\Http\Server($socket);

  // new secure HTTPS server
  $socket = new React\Socket\Server('127.0.0.1:8080', $loop);
  $socket = new React\Socket\SecureServer($socket, $loop, array(
      'local_cert' => __DIR__ . '/localhost.pem'
  ));
  $http = new React\Http\Server($socket);
  ```

* BC break: Mark internal APIs as internal or private and
  remove unneeded `ServerInterface`
  (#118 by @clue, #95 by @legionth)

## 0.4.4 (2017-02-13)

* Feature: Add request header accessors (à la PSR-7)
  (#103 by @clue)

  ```php
  // get value of host header
  $host = $request->getHeaderLine('Host');

  // get list of all cookie headers
  $cookies = $request->getHeader('Cookie');
  ```

* Feature: Forward `pause()` and `resume()` from `Request` to underlying connection
  (#110 by @clue)

  ```php
  // support back-pressure when piping request into slower destination
  $request->pipe($dest);

  // manually pause/resume request
  $request->pause();
  $request->resume();
  ```

* Fix: Fix `100-continue` to be handled case-insensitive and ignore it for HTTP/1.0.
  Similarly, outgoing response headers are now handled case-insensitive, e.g
  we no longer apply chunked transfer encoding with mixed-case `Content-Length`.
  (#107 by @clue)
  
  ```php
  // now handled case-insensitive
  $request->expectsContinue();

  // now works just like properly-cased header
  $response->writeHead($status, array('content-length' => 0));
  ```

* Fix: Do not emit empty `data` events and ignore empty writes in order to
  not mess up chunked transfer encoding
  (#108 and #112 by @clue)

* Lock and test minimum required dependency versions and support PHPUnit v5
  (#113, #115 and #114 by @andig)

## 0.4.3 (2017-02-10)

* Fix: Do not take start of body into account when checking maximum header size
  (#88 by @nopolabs)

* Fix: Remove `data` listener if `HeaderParser` emits an error
  (#83 by @nick4fake)

* First class support for PHP 5.3 through PHP 7 and HHVM
  (#101 and #102 by @clue, #66 by @WyriHaximus)

* Improve test suite by adding PHPUnit to require-dev,
  improving forward compatibility with newer PHPUnit versions
  and replacing unneeded test stubs
  (#92 and #93 by @nopolabs, #100 by @legionth)

## 0.4.2 (2016-11-09)

* Remove all listeners after emitting error in RequestHeaderParser #68 @WyriHaximus
* Catch Guzzle parse request errors #65 @WyriHaximus
* Remove branch-alias definition as per reactphp/react#343 #58 @WyriHaximus
* Add functional example to ease getting started #64 by @clue
* Naming, immutable array manipulation #37 @cboden

## 0.4.1 (2015-05-21)

* Replaced guzzle/parser with guzzlehttp/psr7 by @cboden 
* FIX Continue Header by @iannsp
* Missing type hint by @marenzo

## 0.4.0 (2014-02-02)

* BC break: Bump minimum PHP version to PHP 5.4, remove 5.3 specific hacks
* BC break: Update to React/Promise 2.0
* BC break: Update to Evenement 2.0
* Dependency: Autoloading and filesystem structure now PSR-4 instead of PSR-0
* Bump React dependencies to v0.4

## 0.3.0 (2013-04-14)

* Bump React dependencies to v0.3

## 0.2.6 (2012-12-26)

* Bug fix: Emit end event when Response closes (@beaucollins)

## 0.2.3 (2012-11-14)

* Bug fix: Forward drain events from HTTP response (@cs278)
* Dependency: Updated guzzle deps to `3.0.*`

## 0.2.2 (2012-10-28)

* Version bump

## 0.2.1 (2012-10-14)

* Feature: Support HTTP 1.1 continue

## 0.2.0 (2012-09-10)

* Bump React dependencies to v0.2

## 0.1.1 (2012-07-12)

* Version bump

## 0.1.0 (2012-07-11)

* First tagged release
