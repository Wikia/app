<?php
/**
 * @brief API module for SimpleUrlFetch - a very simple curl-based URL fetch service.
 * 
 * @author Michał Roszka <michal@wikia-inc.com>
 */
class WikiaApiSimpleUrlFetch extends ApiBase {
    /**
     * Constructor
     * 
     * @access public
     * @see http://svn.wikimedia.org/doc/classApiBase.html
     */
    public function __construct($main, $action) {
        parent :: __construct($main, $action, 'suf');
    }
    /**
     * execute
     * 
     * Evaluates the parameters, performs the requested action and prints out the result.
     * 
     * @access public
     */
    public function execute() {
        $Key = $Url = '';
        extract( $this->extractRequestParams() );
        $Url = urldecode( $Url );
        // determine whether the client can use this module or not
        global $wgTheSchwartzSecretToken;
        if ( $wgTheSchwartzSecretToken != $Key ) {
            header( 'HTTP/1.1 403 Forbidden' );
            header( 'Content-Type: text/plain; charset=utf-8' );
            exit( F::app()->wf->msg( 'simpleurlfetch-client-auth-failed' ) );
        }
        // nothing to fetch
        if ( empty( $Url ) ) {
                header( 'HTTP/1.1 204 No Content' );
                exit( '' );
        }
        // try to process the client request
        try {
                $d = new SimpleUrlFetch();
                $d->setUrl( $Url );
                $d->process();
                $d->echoData();
        }
        // HTTP 500 on exception
        catch ( SimpleUrlFetchException $e ) {
                header( 'HTTP/1.1 500 Internal Server Error' );
                header( 'Content-Type: text/plain; charset=utf-8' );
                exit( F::app()->wf->msg( 'simpleurlfetch-error-while-processing-the-request' ) . "\n" . F::app()->wf->msg( $e->getMsg() ) );
        }
        // exit (explicitly with empty status!)
        exit( '' );
    }
    /**
     * getVersion
     * 
     * Returns a string that identifies the version of this class. 
     * 
     * @return string
     * @access public
     * @see http://svn.wikimedia.org/doc/classApiBase.html
     */
    public function getVersion() {
        return __CLASS__ . ': 1.0 2011-07-07';
    }
    /**
     * getAllowedParams
     * 
     * Returns an array of allowed parameters and their default values.
     * 
     * @return array
     * @access protected
     * @see http://svn.wikimedia.org/doc/classApiBase.html
     */
    protected function getAllowedParams() {
        return array(
            'Key' => null,
            'Url' => null
        );
    }
    /**
     * getParamDescription
     * 
     * Returns an array of parameter descriptions.
     * 
     * @return array
     * @access protected
     * @see http://svn.wikimedia.org/doc/classApiBase.html
     */
    protected function getParamDescription() {
        return array(
            'Key' => 'The client key.',
            'Url' => 'The URL to fetch.'
        );
    }
    /**
     * getDescription
     * 
     * Returns the description string for this module. 
     * 
     * @return string
     * @access protected
     * @see http://svn.wikimedia.org/doc/classApiBase.html
     */
    protected function getDescription() {
        return 'Fetches the requested URL using the SimpleUrlFetch extension.';
    }
    /**
     * getExamples
     * 
     * Returns an array of usage examples for this module. 
     * 
     * @return array
     * @access protected
     * @see http://svn.wikimedia.org/doc/classApiBase.html
     */
    protected function getExamples() {
        return array (
            'Fetch http://example.com/:',
            'api.php?action=fetchurl&sufKey=one2three4five&sufUrl=http%3A%2F%2Fexample.com%2F'
        );
    }
}