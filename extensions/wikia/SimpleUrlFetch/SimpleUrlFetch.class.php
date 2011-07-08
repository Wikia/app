<?php
/**
 * @brief exceptions thrown by SimpleUrlFetch extension
 * 
 * @author Michał Roszka <michal@wikia-inc.com>
 */
class SimpleUrlFetchException extends Exception {}
/**
 * @brief A very simple curl-based URL fetch service.
 * 
 * @author Michał Roszka <michal@wikia-inc.com>
 */
class SimpleUrlFetch {
    /**
     * @example SimpleUrlFetch.example.php
     */
    /**
     * @var int a number of retries before giving up fetching the URL
     */
    const MAX_RETRIES = 3;
    /**
     * @var int retries interval in seconds
     */
    const RETRIES_INTERVAL = 10;
    /**
     * @var resource curl handle
     * @access private
     */
    private $curl;
    /**
     * @var string fetched content
     * @access private
     */
    private $contents;
    /**
     * @var array HTTP/1.1 status codes
     */
    protected $httpCodes = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    );
    /**
     * Constructor
     * 
     * Checks for the curl PHP extension, starts a new curl sessions and sets its options.
     * 
     * @return null
     * @throws SimpleUrlFetchException
     * @access public
     */
    public function __construct() {
        // check if the curl PHP extension is available
        if ( !extension_loaded( 'curl' ) ) {
            throw new SimpleUrlFetchException( 'simpleurlfetch-curl-not-available' );
        }
        // start a new curl session
        $this->curl = curl_init();
        // throw an exception if the above failed
        if ( !$this->curl || !is_resource( $this->curl ) ) {
            throw new SimpleUrlFetchException( 'simpleurlfetch-construct-curl-init-failed' );
        }
        
        // set curl options; proceed on success, throw an exception on failure.

        // set curl_exec to return fetched data instead of printing out.
        if ( !curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, true ) ) {
            throw new SimpleUrlFetchException( 'construct-curl-setopt-failed' );
        }
        
        return null;
    }
    /**
     * Destructor
     * 
     * Closes the curl session if exists.
     * 
     * @return null
     * @throws SimpleUrlFetchException
     * @access public
     */
    public function __destruct() {
        if ( is_resource( $this->curl ) ) {
            curl_close( $this->curl );
        }
        
        return null;
    }
    /**
     * setUrl
     * 
     * Sets the URL to fetch.
     * 
     * @param string $url the URL to fetch
     * @return bool true on success
     * @throws SimpleUrlFetchException
     * @access public
     */
    public function setUrl( $url ) {
        if ( !curl_setopt( $this->curl, CURLOPT_URL, $url ) ) {
            throw new SimpleUrlFetchException( 'simpleurlfetch-seturl-curl-setopt-failed' );
        }
        return true;
    }
    /**
     * process
     * 
     * Executes the curl session and fetches the URL.
     * 
     * @return null
     * @throws SimpleUrlFetchException
     * @access public
     */
    public function process() {
        for ( $i = 0; $i < self::MAX_RETRIES; $i++ ) {
            $response = curl_exec( $this->curl );
            // write the fetched data and quit
            if ( $response ) {
                $this->data = $response;
                return null;
            }
            // wait before the next try
            sleep( self::RETRIES_INTERVAL );
        }
        // give up
        throw new SimpleUrlFetchException( 'simpleurlfetch-process-max-retries-exceeded' );
    }
    /**
     * echoData
     * 
     * Echoes the fetched data along with corresponding HTTP headers.
     * 
     * @return null
     * @throws SimpleUrlFetchException
     * @access public
     */
    public function echoData() {
        // get some information on the curl session
        $data = curl_getinfo( $this->curl );
        // throw an exception on wrong HTTP status
        if ( !$data['http_code'] || !isset( $this->httpCodes[$data['http_code']] ) ) {
            throw new SimpleUrlFetchException( 'simpleurlfetch-echodata-unknown-http-code' );
        }
        // pass the HTTP status to the client
        header( "HTTP/1.1 {$data['http_code']} {$this->httpCodes[$data['http_code']]}" );
        // assume Unicode plain text on unknown content-type ...
        if ( !$data['content_type'] ) {
            header( 'Content-Type: text/plain; charset=utf-8' );
        }
        // or pass the content-type header to the client
        else {
            header( "Content-Type: {$data['content_type']}" );
        }
        // echo the fetched data
        echo $this->data;
        return null;
    }
}