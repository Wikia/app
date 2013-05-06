<?php

/*
 * Internal implementation of Google WebmasterTools client.
 * Consider using GWTService or WebmasterToolsUtil as public interface.
 */
class GWTClient {
	const FEED_URI = 'https://www.google.com/webmasters/tools/feeds';

	private $mAuth, $mEmail, $mPass, $mType, $mSource, $mService, $mWiki, $mSiteURI;
	private static $cache; /* var $cache GWTLocalCache */

	/**
	 * constructor
	 * If email and password are empty, will use the default preferred account from '
	 *
	 * @access public
	 */
	public function __construct( $email, $pass, $wiki = null) {
		if ( GWTClient::$cache == null )
			GWTClient::$cache = new GWTLocalCache();

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
				$wikiId = WikiFactory::getWikiByID( $wiki );
				if ( !$wikiId ) {
					throw new Exception("Could not find wiki by ID (id=" . $wiki . ").");
				}
				$wiki = $wikiId;
			}
			$this->mWiki    = $wiki;
			$this->mSiteURI = $this->make_site_uri();
		}
		$this->mAuth    = $this->getAuthToken();
	}

	private function getAuthToken () {
		$cacheKey = $this->mEmail;
		$cached = self::$cache->get( $cacheKey );
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
			self::$cache->set( $cacheKey, $matches[1] );
			return $matches[1];
		} else {
			throw new GWTAuthenticationException();
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

	private function make_sitemaps_uri () {
		$site = $this->normalize_site($this->mWiki->city_url);
		$uri = self::FEED_URI . '/' . urlencode($site) . "/sitemaps/";
		return $uri;
	}

	private function make_site_id () {
		return $this->normalize_site($this->mWiki->city_url).'sitemap-index.xml';
	}
	/*
	* @return - GWTSiteSyncStatus.
	*/
	public function site_info () {
		$request = MWHttpRequest::factory( $this->mSiteURI );
		$request->setHeader('Authorization', 'GoogleLogin auth='. $this->mAuth);
		$status = $request->execute();

		if ( $status->isOK() ) {
			$content = $request->getContent();
		} else {
			return null;
		}
		$doc = new DOMDocument();
		$doc->loadXML($content);
		$e = $doc->documentElement;
		return GWTSiteSyncStatus::fromDomElement( $e );
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
			return null;
		}
		//return $content;
		$doc = new DOMDocument();
		$doc->loadXML($content);
		return GWTSiteSyncStatus::arrayFromDomDocument( $doc );
	}

	public function add_site () {
		$uri = self::FEED_URI . '/sites/';
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
			throw new GWTException("Bad response from google.\n" . $request->getContent() . ". Cannot add sitemap (" . $this->mWiki->city_url . ").");
		}

		if ($content) {
			$doc = new DOMDocument();
			$doc->loadXML( $content );
			$e = $doc->documentElement;
			return GWTSiteSyncStatus::fromDomElement( $e );
		} else {
			throw new GWTException("Cannot add sitemap (" . $this->mWiki->city_url . ").");
		}
	}

	public function verify_site ($code = null) {

		if (!$code) {
			$info = $this->site_info();
			$code = $info->getPageVerificationCode();
		}

		// Update the wgGoogleSiteVerification variable with this code
		WikiFactory::setVarByName('wgGoogleSiteVerification', $this->mWiki->city_id, $code);

		// Send the verification request to google
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array( "site_id" => $this->make_site_id()) );
		$xml = $oTmpl->render("wt-verify-request");

		return $this->put_verify( $xml );
	}

	private function put_verify ( $xml ) {
		global $wgHTTPTimeout, $wgHTTPProxy, $wgTitle, $wgVersion;
		$request = MWHttpRequest::factory( $this->mSiteURI , array( 'postData' => $xml, 'method' => 'PUT') );
		$request->setHeader('Content-type', 'application/atom+xml');
		$request->setHeader('Authorization', 'GoogleLogin auth='.$this->mAuth);
		$status = $request->execute();

		if ( $status->isOK() ) {
			$text = $request->getContent();
			GWTLogHelper::debug( $text );
		} else {
			throw new GWTException( "Non 200 response.\n"  . "\n" . "message:". $status->getMessage()."\n" . $request->getContent());
		}

		$doc = new DOMDocument();
		$doc->loadXML($text);
		$e = $doc->documentElement;
		return GWTSiteSyncStatus::fromDomElement( $e );
	}

	public function send_sitemap () {
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array( "site_id" => $this->make_site_id()) );
		$xml = $oTmpl->render("wt-add-sitemap");
		$this->put_sitemap( $xml );
	}

	private function put_sitemap ( $xml ) {
		$request = MWHttpRequest::factory( $this->make_sitemaps_uri(), array( 'postData' => $xml, 'method' => 'POST') );
		$request->setHeader('Content-type', 'application/atom+xml');
		$request->setHeader('Content-length', strval(strlen($xml)));
		$request->setHeader('Authorization', 'GoogleLogin auth='.$this->mAuth);
		$status = $request->execute();

		if ( $status->isOK() ) {
			$text = $request->getContent();
			GWTLogHelper::debug( $text );
		} else {
			throw new GWTException( "Non 200 response.\n"  . "\n" . "message:". $status->getMessage()."\n" . $request->getContent());
		}
	}
}
