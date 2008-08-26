<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Universal contact fetching functionality
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Tomasz Klim <tomek@wikia.com>, MoLi <moli@wikia.com>
 * @copyright Copyright (C) 2007 Tomasz Klim (private, proprietary code)
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'WikiContacts',
	'description' => 'universal contact fetching functionality',
	'author' => 'Tomasz Klim'
);

include_once( "$IP/extensions/wikia/WikiCurl/WikiCurl.php" );
include_once( "live_lib/windowslivelogin.php" ); //php lib for micrsoft live api

class WikiContacts
{
    static $live_services = array(
    		"hotmail","hotmail.co.uk","hotmail.de", "hotmail.es", "hotmail.fr","hotmail.it","hotmail.co.jp",
		"live","live.fr","live.de","live.jp","live.cl","live.ca",
		"MSN"
    );
    						
    final public static function isLiveService( $provider ) {
	    return in_array( $provider, self::$live_services );
		 
    }
    
    final public static function fetch( $provider, $username, $password ) 
    {
	    if( strpos( $provider, "yahoo.") !== false  ){
		    return self::fetchYahooAPI  ( $username  );
	    }
	
	    switch ( $provider ) 
		{
			case 'gmail':    return self::fetchGmail  ( $username, $password );
			case 'yahoo':    return self::fetchYahoo  ( $username, $password );
			case 'myspace':  return self::fetchMySpace( $username, $password );
			default:         return self::fetchGmail  ( $username, $password );
		}
    }
  
    final public static function fetchYahooAPI( $cookie ) 
    {
	    global $wgYahooAPIAppid;
	   
	    if( ! $_COOKIE["yahoo_wssid"] ) return false;
	    
	    $url = "http://address.yahooapis.com/v1/searchContacts";
	    $url .= "?format=json";
	    $url .= "&appid=" . $wgYahooAPIAppid;
	    $url .= "&WSSID=" . $_COOKIE["yahoo_wssid"];

	    //make the GET Request to Yahoo API in CURL
	    $headers = array("Cookie: " . $_COOKIE["yahoo_cookie"]);
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
	    $json = curl_exec($curl);
	    $curlinfo = curl_getinfo($curl);
	    curl_close($curl);
	    
	    if( $curlinfo["http_code"] != 200 ) return false;

	    $yahoo_contacts = json_decode( $json );

	    $contacts = array();
	
	    foreach ($yahoo_contacts->contacts as $contact){
		    $email = "";
		    $name = "";
		
		    foreach( $contact->fields as $field ){
			    if( $field->type == "email" ){
				    $email = $field->data;
			    }
			    if( $field->type == "name"){
				    $name = $field->first . " " . $field->last;
			    }
		    }
		    if( $email ){
			    if( !$name ) $name = $email;
			    $contacts[] = array( 
						"email" => "{$email}",
						"name" => "{$name}"
						);
		    }
	    }
	    return $contacts;
	    
    }
    
    final public static function fetchMS( $cookie ) 
    {
	global $wgLiveAPIApplicationKey;
	
	if ($cookie) {
		$wll = WindowsLiveLogin::initFromXml($wgLiveAPIApplicationKey);
		$token = $wll->processConsentToken($cookie);
	}
	if ($token && !$token->isValid()) {
		return false;
	}
	
	$delegation_token = $token->getDelegationToken();
	$cid = $token->getLocationID();
	
	// convert the cid to a signed 64-bit integer
	$lid = self::hexaTo64SignedDecimal($cid, 16, 10);
	$uri = "https://livecontacts.services.live.com/users/@C@" . $lid . "/rest/livecontacts";
	
	$host = "livecontacts.services.live.com";
	$urisplit = split("://", $uri);
	$page = substr($urisplit[1], strlen($host));
	
	// Add the token to the header
	$headers = array("Authorization: DelegatedToken dt=\"$delegation_token\"");
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $uri);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
	$xml = curl_exec($curl);

	// Get the info and close the connection
	$curlinfo = curl_getinfo($curl);
	curl_close($curl);
	
	if ($xml !== false)
	{
	    $oSimpleXML = new SimpleXMLElement($xml);
	    $contacts = array();
	    $i = 0;
	    $contactsroot = $oSimpleXML->Contacts[0];
	
	    foreach ($contactsroot->Contact as $contact)
	    {
		$firstname = $middlename = $lastname = $fullname = "";
	
		if (isset($contact->Profiles->Personal->FirstName))
		    $firstname = $contact->Profiles->Personal->FirstName;
		if (isset($contact->Profiles->Personal->MiddleName))
		    $middlename = $contact->Profiles->Personal->MiddleName;
		if (isset($contact->Profiles->Personal->LastName))
		    $lastname = $contact->Profiles->Personal->LastName;
	
		// Concatenate the 3 variables
		$fullname = $firstname . " " . $middlename . " " . $lastname;
		$fullname = str_replace("  ", " ", $fullname);
		$fullname = trim($fullname);
	
		// If there is no full name available, use the displayname
		if ($fullname == "")
		    $fullname = $contact->Profiles->Personal->DisplayName;
	
		// If there is no displayname, use the unique name
		if ($fullname == "")
		    $fullname = $contact->Profiles->Personal->UniqueName;
	
		foreach ($contact->Emails->Email as $email){
		    $contacts[] = array( 
		    			"name" => "{$fullname}",
					"email" => "{$email->Address}"
					);
	    
		}
	    }
	
	
	}
	
	//$contacts = array_unique($contacts);
	return $contacts;
    }
    
    private static function utf162utf8($utf16)
    {
        // oh please oh please oh please oh please oh please
        if(function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($utf16, 'UTF-8', 'UTF-16');
        }

        $bytes = (ord($utf16{0}) << 8) | ord($utf16{1});

        switch(true) {
            case ((0x7F & $bytes) == $bytes):
                // this case should never be reached, because we are in ASCII range
                // see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                return chr(0x7F & $bytes);

            case (0x07FF & $bytes) == $bytes:
                // return a 2-byte UTF-8 character
                // see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                return chr(0xC0 | (($bytes >> 6) & 0x1F))
                     . chr(0x80 | ($bytes & 0x3F));

            case (0xFFFF & $bytes) == $bytes:
                // return a 3-byte UTF-8 character
                // see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
                return chr(0xE0 | (($bytes >> 12) & 0x0F))
                     . chr(0x80 | (($bytes >> 6) & 0x3F))
                     . chr(0x80 | ($bytes & 0x3F));
        }

        // ignoring UTF-32 for now, sorry
        return '';
    }

    private static function fetchGmail( $username, $password ) 
    {
		$handler = new WikiCurl();

		// we allow cookies, but don't store them, because of major security hole in Gmail,
		// related to 'GX' cookie, which allows one to take over any Gmail account.
		// worked on 2007-02-01 12:59 local time (+1)
		$handler->setCookies( '/dev/null' );


		$postal_data = array(
			'ltmpl' 		=> 'yj_blanco',
			'ltmplcache' 	=> 2,
			'continue' 		=> 'http://mail.google.com/mail/',
			'service' 		=> 'mail',
			'rm' 			=> 'false',
			'ltmpl' 		=> 'yj_blanco',
			'Email' 		=> $username,
			'Passwd' 		=> $password,
			'rmShown' 		=> 1,
			'null' 			=> 'Sign+in'
		);
		$ret = $handler->get('https://www.google.com/accounts/LoginAuth', $postal_data);
		
		if ( strpos( $ret, 'Redirecting' ) || strpos( $ret, 'Personal information' ) ) 
		{  // we are logged in, let's analyze the Contacts page

			// this method works perfectly for me (Tomasz Klim), but doesn't work for John Q. Smith
			// anyway, we need to load this page, to set some cookies needed by the below page
			$ret = $handler->get('https://mail.google.com/mail/', array('v'=>'cl', 'pnl'=>'a', 'ui'=>'html', 'zy'=>'n'));

			
//			$ret = $handler->get('https://mail.google.com/mail/',array('ik' => '', 'view' => 'sec', 'zx' => ''));
			$result = $handler->get('http://mail.google.com/mail/contacts/data/export', 
				array('exportType' => 'ALL', 'groupToExport' => '', 'out' => 'HTML', 'exportEmail' => 'true')
			);
			
			$result = str_replace("\n", "", $result);
			$result = str_replace("\r", "", $result);

			if (!empty($result))
			{
				$csv = array();
				preg_match_all('|<tr><td>(.*?)</td><td>(.*?)</td></tr>|', $result, $csv);
				//preg_match_all('|(.*?),(.*?),|', $result, $csv);
				$users = $csv[1];
				$emails = $csv[2];
				$contacts = array();
				foreach ( $users as $id => $user ) {
					$user = (empty($user) || ($user == '-')) ? $emails[$id] : $user;
					$contacts[] = array( 'email' => $emails[$id], 'name' => $user );
				}
				return $contacts;
			} 
			else
			{
				return array();
			}
		}
		else 
		{
			return false;
		}
    }

    private static function fetchYahoo( $username, $password, $login_domain="http://login.yahoo.com/config/login" ) 
    {
		$handler = new WikiCurl();
		$handler->setCookies( '/dev/null' );

		$ret = $handler->post($login_domain, array( 
											'login'      => $username,
											'passwd'     => $password,
											'.src'       => '',
											'.tries'     => '5',  // 1
											'.bypass'    => '',
											'.partner'   => '',
											'.md5'       => '',
											'.hash'      => '',
											'.js'		 => '',
											'promo'		 => '',
											'.intl'      => 'us',
											'.challenge' => 'nz276e0rDBNEtOMcEXReHRDGC8Qt',
											'.u'         => 'd6cqat13p144e',
											'.yplus'     => '',
											'.emailCode' => '',
											'pkg'        => '',
											'stepid'     => '',
											'.ev'        => '',
											'hasMsgr'    => '0',
											'.v'         => '0',
											'.chkP'      => 'N',
											'.done'      => 'http://address.mail.yahoo.com/',
											'.last'      => '',
											'.pd'		 =>	'_var=0&c=' ));
		
		if ( !preg_match( "/Sign in to Yahoo/i", $ret )   )  // we are logged in, let's analyze the Contacts page
		{  
			// get random value of URL -> added by MoLi
			$res = $handler->get('http://address.mail.yahoo.com',array());
			preg_match_all("/rand=(.*?)\"/", $res, $array_names);	
			$rand_value = str_replace('"', '', $array_names[0][0]);

			// get crumb value 
			$res = $handler->get('http://address.mail.yahoo.com/?1&VPC=import_export&A=B&.rand='.$rand_value,array());
			preg_match_all("/id=\"crumb1\" value=\"(.*?)\"/", $res, $array_names);	
			$crumb = $array_names[1][0];
			
			$ret = $handler->post( 'http://address.mail.yahoo.com/', 
							array( 
									'.crumb' => $crumb, 
									'VPC' => 'import_export',
									'submit[action_export_outlook]' => 'Export Now',
									'A' => 'B' 
								 )
							);
			echo $ret;
			exit();
			$ret = substr( $ret, strpos( $ret, "\r\n\r\n" ) + 4 );
			//$wgOut->addWikiText( '<pre>' . $ret . '</pre>' );

			$fileContentArr = explode( "\n", $ret );

			$abColumnHeadLine = trim( $fileContentArr[0] );
			$abColumnHeadLine = str_replace( '"', '', $abColumnHeadLine );

			$abColumnHeadArr = explode( ",", $abColumnHeadLine );
			unset( $fileContentArr[0] );

			foreach ( $fileContentArr as $key => $value ) 
			{
				$listColumnLine = trim( $value );
				$listColumnLine = str_replace( '"', '', $listColumnLine );

				$listColumnArr = explode( ",", $listColumnLine );

				unset( $list_ );
				foreach ( $listColumnArr as $listColumnKey => $listColumnValue ) 
				{
					$listKey = $abColumnHeadArr[$listColumnKey];
					$list_[$listKey] = $listColumnValue;
				}

				if ( is_array( $list_ ) ) {
					$list[] = $list_;
				}
	    	}

			if ( is_array( $list ) ) 
			{
				$cnt = 0;
				$contacts = array();

				foreach ( $list as $entry => $container ) 
				{
					if (!empty($container["E-mail Address"]))
					{
						$cnt++;
						$contacts[] = array( 'email' => $container["E-mail Address"], 'name' => $container["First Name"] . ' ' . $container["Last Name"] );
					}
				}
				return $contacts;
	    	} 
	    	else 
	    	{
				return array();
			}
		} 
		else 
		{
	    	return false;
		}
    }
    
    private static function fetchMyspace( $username, $password ) 
    {  // 151235739
		$handler = new WikiCurl();
		$handler->setCookies( '/dev/null' );

		$ret = $handler->get('http://www.myspace.com');

		preg_match( "/MyToken=([^\"]+)\"/", $ret, $token );
		$token = $token[1];

		$ret = $handler->post( "http://login.myspace.com/index.cfm?fuseaction=login.process&MyToken=$token",
					 array( 'ctl00%24Main%24SplashDisplay%24login%24loginbutton.x' => '38',
							'ctl00%24Main%24SplashDisplay%24login%24loginbutton.y' => '15',
							'email' => $username,
							'password' => $password ) );

		//global $wgOut;
		//$wgOut->addWikiText( '<pre>' . $ret . '</pre>' );

		preg_match( "/fuseaction=user&Mytoken=(.*)\"/", $ret, $token );
		$token = $token[1];

		// note that this is *not* the same page, as in post, since token has changed
		$handler->setReferer( "http://login.myspace.com/index.cfm?fuseaction=login.process&MyToken=$token" );

		$ret = $handler->get('http://home.myspace.com/index.cfm', array('fuseaction' => 'user', 'MyToken' => $token));
		//$wgOut->addWikiText( '<pre>' . $ret . '</pre>' );

		if ( !strpos( $ret, "You Must Be Logged-In to do That!" ) ) 
		{  // we are logged in, let's analyze the Contacts page
			
			preg_match( "/AddressBookHyperLink\" href=\"([^\"]+)\"/", $ret, $redirpage );
			$ret = $handler->get( $redirpage[1] );

			echo "<pre>".print_r($ret, true)."</pre>";
			exit;

			$regexp = "<a href=\"#\" onclick=\"[^\"]*\" title=\"View this Contact\">(.*?)<\/a>";
			preg_match_all( "/$regexp/s", $ret, $username );

			$regexp = "<td class=\"email\">(.*?)<\/td>";
			preg_match_all( "/$regexp/s", $ret, $emails );

			$regexp = "href=\"([^\"]*)\"><font[^>]*>SignOut";
			preg_match_all( "/$regexp/s", $ret, $logout );

			$ret = $handler->get( $logout[1][0] );

			if ( is_array( $emails[1] ) ) 
			{
				$cnt = 0;
				$total = sizeof( $emails[1] );
				$contacts = array();

				for ( $i = 0; $i < $total; $i++ ) 
				{
					$cnt++;
					$emails[1][$i] = str_replace( "<br>", "", $emails[1][$i] );
					$contacts[] = array( 'email' => $emails[1][$i], 'name' => $username[1][$i] );
				}
				return $contacts;
			} 
			else 
			{
				return array();
			}
		} 
		else 
		{
	    	return false;
		}
    }
    public function hexaTo64SignedDecimal($hexa)
	{
	    $bin = self::fixed_base_convert($hexa, 16, 2);
	    if (64 === strlen($bin) and 1 == $bin[0])
	    {
		$inv_bin = strtr($bin, '01', '10');
		$i = 63;
		while (0 !== $i)
		{
		    if (0 == $inv_bin[$i])
		    {
			$inv_bin[$i] = 1;
			$i = 0;
		    }
		    else
		    {
			$inv_bin[$i] = 0;
			$i--;
		    }
		}
		return '-' . self::fixed_base_convert($inv_bin, 2, 10);
	    }
	    else
	    {
		return self::fixed_base_convert($hexa, 16, 10);
	    }
	}
	
	/* fixed_base_convert is used to correctly convert the CID's to INT64 LID's
	Follows the syntax of base_convert (http://www.php.net/base_convert)
	Created by Michael Renner @ http://www.php.net/base_convert
	17-May-2006 03:24
	*/
	public function fixed_base_convert($numstring, $frombase, $tobase)
	{
	    $chars = "0123456789abcdefghijklmnopqrstuvwxyz";
	    $tostring = substr($chars, 0, $tobase);
	
	    $length = strlen($numstring);
	    $result = '';
	    for ($i = 0; $i < $length; $i++)
	    {
		$number[$i] = strpos($chars, $numstring{$i});
	    }
	    do
	    {
		$divide = 0;
		$newlen = 0;
		for ($i = 0; $i < $length; $i++)
		{
		    $divide = $divide * $frombase + $number[$i];
		    if ($divide >= $tobase)
		    {
			$number[$newlen++] = (int)($divide / $tobase);
			$divide = $divide % $tobase;
		    } elseif ($newlen > 0)
		    {
			$number[$newlen++] = 0;
		    }
		}
		$length = $newlen;
		$result = $tostring{$divide} . $result;
	    } while ($newlen != 0);
	    return $result;
	}   

}

function sign_yahoo_url( $url ) {
	global $YahooAPISecret;
	$parts = parse_url( $url );
	
	$ts = time();
	$relative_uri = "";
	if ( isset( $parts["path"] ) ){
		$relative_uri .= $parts["path"];
	}
	if ( isset ( $parts["query" ] ) ) {
		$relative_uri .= "?" . $parts["query"] . "&ts=$ts";
	}
	
	$sig = md5( $relative_uri . $YahooAPISecret );
	
	$signed_url = $parts["scheme"] . "://" .  $parts["host"] . $relative_uri . "&sig=$sig";
	
	return $signed_url;
}
?>
