<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 15.04.13
 * Time: 16:15
 * To change this template use File | Settings | File Templates.
 */

require_once(__DIR__."/LocalCache.php");
require_once(__DIR__."/GoogleAuthenticationException.php");

class GoogleWebmasterToolsClient {
	const FEED_URI = 'https://www.google.com/webmasters/tools/feeds';

	private $mAuth, $mEmail, $mPass, $mType, $mSource, $mService, $mWiki, $mSiteURI;
	private static $cache;

	/**
	 * constructor
	 * If email and password are empty, will use the default preferred account from '
	 *
	 * @access public
	 */
	public function __construct( $email, $pass, $wiki = null) {
		if ( GoogleWebmasterToolsClient::$cache == null )
			GoogleWebmasterToolsClient::$cache = new GooleWebmasterTools\LocalCache();

		global $wgGoogleWebToolsAccts;

		// If email and password weren't specified, use the preferred account.
		if(empty($email) && empty($pass)){
			if(is_array($wgGoogleWebToolsAccts)){
				foreach($wgGoogleWebToolsAccts as $acctEmail => $acctData){
					if(isset($acctData['preferred']) && ($acctData['preferred'] == 1)){
						$email = $acctEmail;
						$pass = $acctData['pass'];
						break;
					}
				}

				// If no preferred email/pass was found, just grab the first one
				if(empty($email) && empty($pass) && (count($wgGoogleWebToolsAccts) > 0)){
					$keys = array_keys($wgGoogleWebToolsAccts);
					$email = $keys[0];
					$pass = (isset($wgGoogleWebToolsAccts[$email]['pass']) ? $wgGoogleWebToolsAccts[$email]['pass'] : "");
				}
			}
		}

		$this->mEmail   = $email;
		$this->mPass    = $pass;
		$this->mType    = 'GOOGLE';
		$this->mSource  = 'WIKIA';
		$this->mService = 'sitemaps';

		if ( $wiki != null ) {
			if (!is_object($wiki)) {
				if( is_string($wiki) ) {
					$wiki = WikiFactory::DBtoID($wiki);
				}
				$wiki = WikiFactory::getWikiByID( $wiki );
				if (!$wiki) {
					throw new Exception("Could not find wiki by ID");
				}
			}
			$this->mWiki    = $wiki;
			$this->mSiteURI = $this->make_site_uri();
		}
		$this->mAuth    = $this->getAuthToken();
	}

	private function getAuthToken () {
		$cacheKey = $this->mEmail;
		$cached = GoogleWebmasterToolsClient::$cache->get( $cacheKey );
		if( $cached ) return $cached;

		$content = Http::post('https://www.google.com/accounts/ClientLogin',
			//null,
			array('postData' => array(
				"Email"       => $this->mEmail,
				"Passwd"      => $this->mPass,
				"accountType" => $this->mType,
				"source"      => $this->mSource,
				"service"     => $this->mService,
			)
			)
		);

		if (preg_match('/Auth=(\S+)/', $content, $matches)) {
			GoogleWebmasterToolsClient::$cache->set( $cacheKey, $matches[1] );
			return $matches[1];
		} else {
			throw new GooleWebmasterTools\GoogleAuthenticationException();
		}
	}

	private function normalize_site ($site) {
		if (!preg_match('!^http://!', $site)) $site = 'http://'.$site;
		if (!preg_match('!/$!', $site))       $site = $site.'/';

		return $site;
	}

	private function make_site_uri () {
		$site = $this->normalize_site($this->mWiki->city_url);
		$uri = self::FEED_URI . '/sites/' . urlencode($site);
		return $uri;
	}

	private function make_site_id () {
		return $this->normalize_site($this->mWiki->city_url).'sitemap-index.xml';
	}

	public function site_info () {
		$request = MWHttpRequest::factory( $this->mSiteURI );
		$request->setHeader('Authorization', 'GoogleLogin auth='. $this->mAuth);
		$status = $request->execute();

		if ( $status->isOK() ) {
			$content = $request->getContent();
		} else {
			return;
		}
		$doc = new DOMDocument();
		$doc->loadXML($content);

		$e = $doc->documentElement;
		$info = array();

		foreach ($e->childNodes as $node) {
			switch ($node->nodeName) {
				case 'updated':
					$info['updated'] = $node->nodeValue;
					break;
				case 'wt:verified':
					$info['verified'] = $node->nodeValue == 'true' ? true : false;
					break;
				case 'wt:verification-method':
					if (preg_match('/google([a-f0-9]+)\.html/', $node->nodeValue, $matches)) {
						$info['verification_code'] = $matches[1];
					}
					break;
				case 'title':
					$info['site'] = $node->nodeValue;
					break;
				default:
					//error_log("#### NODE: ".$node->nodeName.'='.$node->nodeValue);
			}
		}

		$info['account_name'] = $this->mEmail;

		return $info;
	}

	public function get_sites() {
		$uri = self::FEED_URI . '/sites/';
		$request = MWHttpRequest::factory( $uri );
		$request->setHeader('Content-type', 'application/atom+xml');
		$request->setHeader('Authorization', 'GoogleLogin auth='.$this->mAuth);

		$status = $request->execute();

		if ( $status->isOK() ) {
			$content = $request->getContent();
		} else {
			Wikia::log("Bad response from google.\n" . $request->getContent());
			return;
		}
		//return $content;
		$doc = new DOMDocument();
		$doc->loadXML($content);
		$xpath = new DOMXPath($doc);
		$nodeList = $xpath->query("//*[local-name()='content']/@src");
		$sites = array();
		for($i =0; $i<$nodeList->length; $i++) {
			$sites[] = $nodeList->item( $i )->nodeValue;
		}
		return $sites;
	}

	public function add_site () {
		$uri = self::FEED_URI . '/sites/';
		echo "auth:   " . $this->mAuth . "\n";
		// create request template
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array( "site" => $this->normalize_site($this->mWiki->city_url)));
		$xml = $oTmpl->render("wt-add-request");

		$request = MWHttpRequest::factory( $uri, array( "postData" => $xml, "method" => "POST" ) );
		$request->setHeader('Content-type', 'application/atom+xml');
		$request->setHeader('Authorization', 'GoogleLogin auth='.$this->mAuth);
		$status = $request->execute();

		if ( $status->isOK() ) {
			$content = $request->getContent();
		} else {
			Wikia::log("Bad response from google.\n" . $request->getContent());
			return;
		}

/*
		$content = Http::post($uri = self::FEED_URI . '/sites/',
			array('postData' => $xml,
				CURLOPT_HTTPHEADER => array(': ',
					': ')
			)
		);
*/
		echo "==\n".$content . "==\n";
		if ($content) {
//			WikiFactory::setVarByName('wgGoogleWebToolsAccount', $this->mWiki->city_id, $this->mEmail);

			return true;
		} else {
			return false;
		}
	}

	public function remove_site () {
		global $wgHTTPTimeout, $wgHTTPProxy, $wgTitle, $wgVersion;

		// Update the wgGoogleSiteVerification variable with this code
		//WikiFactory::setVarByName('wgGoogleSiteVerification', $this->mWiki->city_id, '');
		//WikiFactory::setVarByName('wgGoogleWebToolsAccount', $this->mWiki->city_id, '');

		$c = curl_init( $this->mSiteURI );
		curl_setopt($c, CURLOPT_PROXY, $wgHTTPProxy);
		curl_setopt($c, CURLOPT_TIMEOUT, $wgHTTPTimeout);
		curl_setopt($c, CURLOPT_USERAGENT, "MediaWiki/$wgVersion");
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'DELETE' );
		curl_setopt($c, CURLOPT_HTTPHEADER, array('Authorization: GoogleLogin auth='.$this->mAuth));

		curl_exec( $c );

		# Don't return the text of error messages, return false on error
		$retcode = curl_getinfo( $c, CURLINFO_HTTP_CODE );

		if ( $retcode != 200 ) {
			error_log("Failed to delete site ".$this->mWiki->site_url." from Webmaster Tools.  Code=".$retcode);
			return false;
		} else {
			return true;
		}
	}

	public function verify_site ($code = null) {

		if (!$code) {
			$info = $this->site_info();
			$code = $info['verification_code'];
		}

		// Update the wgGoogleSiteVerification variable with this code
		WikiFactory::setVarByName('wgGoogleSiteVerification', $this->mWiki->city_id, $code);

		// Send the verification request to google
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array( "site_id" => $this->make_site_id()) );
		$xml = $oTmpl->render("wt-verify-request");

		if ($this->put_verify($xml)) {
			return true;
		} else {
			return false;
		}
	}

	private function put_verify ( $xml ) {
		global $wgHTTPTimeout, $wgHTTPProxy, $wgTitle, $wgVersion;

		$c = curl_init( $this->mSiteURI );
		curl_setopt($c, CURLOPT_PROXY, $wgHTTPProxy);
		curl_setopt($c, CURLOPT_TIMEOUT, $wgHTTPTimeout);
		curl_setopt($c, CURLOPT_USERAGENT, "MediaWiki/$wgVersion");
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'PUT' );

		curl_setopt($c, CURLOPT_HTTPHEADER, array('Authorization: GoogleLogin auth='.$this->mAuth,
			'Content-type: application/atom+xml'));

		curl_setopt($c, CURLOPT_POSTFIELDS, $xml);

		ob_start();
		curl_exec( $c );
		$text = ob_get_contents();
		ob_end_clean();

		# Don't return the text of error messages, return false on error
		$retcode = curl_getinfo( $c, CURLINFO_HTTP_CODE );

		if ( $retcode != 200 ) {
			wfDebug( __METHOD__ . ": HTTP return code $retcode\n" );
			$text = false;
		}
		# Don't return truncated output
		$errno = curl_errno( $c );
		if ( $errno != CURLE_OK ) {
			$errstr = curl_error( $c );
			wfDebug( __METHOD__ . ": CURL error code $errno: $errstr\n" );
			$text = false;
		}
		curl_close( $c );

		return $text;
	}
}
