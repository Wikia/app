<?php
/**
 * TwitterLogin.twitteroauth.php
 * Written by David Raison, based on the guideline published by Dave Challis 
 * at http://blogs.ecs.soton.ac.uk/webteam/2010/04/13/254/
 * @license: LGPL (GNU Lesser General Public License) http://www.gnu.org/licenses/lgpl.html
 *
 * @file TwitterLogin.twitteroauth.php
 * @ingroup TwitterLogin
 *
 * @author David Raison
 *
 * Extends the original TwitterOAuth class and overloads the http method
 *
 */


/**
 * Twitter OAuth class
 *
 */
class MwTwitterOAuth extends TwitterOAuth {

	private $_httpRequest;

	/**
	 * Make an HTTP request
	 * Overloads original twitteroauth http method
	 *
	 * @return API results
	 */
	public function http( $url, $method, $postfields = NULL ) {
		$this->http_info = array();
		
		// the parent class sets the 'Expect:' http header but does not set a value.. we thus omit it here.
		$options = array( 
			'postData' => $postfields, 
			'sslVerifyHost' => $this->ssl_verifypeer, 
			'timeout' => $this->timeout
		);

		//$response = Http::request( $method, $url ,$options );	// works, but doesn't allow us to query the response code
		$this->_httpRequest = MwHttpRequest::factory( $url, $options );
		$this->_httpRequest->setUserAgent($this->useragent);

		$status = $this->_httpRequest->execute();

		if ( $status->isGood() ) {
			$response = $this->_httpRequest->getContent();
			$this->http_code = $this->_httpRequest->getStatus();
			$this->http_header = $this->_httpRequest->getResponseHeaders();

			$this->url = $this->_httpRequest->getFinalUrl();
			return $response;
		}
	}
}
