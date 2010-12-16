<?php

class HoneypotIntegration {
	static $IPs = array();
	static $Data = array();
	public static function onAbuseFilterFilterAction( &$vars, $title ) {
		$vars->setVar( 'honeypot_list_count', self::listingCount() ? 1 : 0 );
		return true;
	}

	public static function onAbuseFilterBuilder( &$builder ) {
		wfLoadExtensionMessages( 'HoneypotIntegration' );
		$builder['vars']['honeypot_list_count'] = 'honeypot-list-count';
		return true;
	}

	public static function onShowEditForm( &$editPage, &$out ) {

		// Spammers are more likely to fall for real text than for a random token.
		// Extract a decent-sized string from the text
		$editText = $editPage->textbox1;
		$randomText = '';

		if ( strlen( $editText ) > 10 ) {
			// Start somewhere in the first quarter of the text,
			//  run for somewhere between a quarter and a half of the text, or 100-1000 bytes,
			//  whichever is shorter.
			$start = rand( 0, strlen( $editText ) / 4 );
			$length = rand( min( strlen( $editText ) / 4, 100 ), min( strlen( $editText ) / 2, 1000 ) );
			$randomText = substr( $editText, $start, $length );
		}

		$out->addHTML( self::generateHoneypotLink( $randomText ) );
		return 1;
	}
	
	public static function getHoneypotURLs() {
		$key = wfMemcKey( 'honeypot-integration-urls' );
		
		global $wgMemc;
		$urls = $wgMemc->get( $key );
		
		if ( is_array($urls) ) {
			return $urls;
		}
		
		global $wgHoneypotAutoLoad;
		if (!$wgHoneypotAutoLoad)
			return array( 'http://www.google.com' ); // Dummy URL
			
		return self::loadHoneypotURLs();
	}
	
	public static function loadHoneypotURLs() {
		global $wgMemc, $wgHoneypotURLSource;
		$key = wfMemcKey( 'honeypot-integration-urls' );

		// Curl opt is a hack because the honeypot folks don't seem to have a valid
		//  certificate.
		$data = Http::get( $wgHoneypotURLSource, 'default',
						array( CURLOPT_SSL_VERIFYHOST => 1 ) );
		
		$urls = explode( "\n", $data );
		
		$wgMemc->set( $key, $urls, 86400 );
		
		return $urls;		
	}

	public static function generateHoneypotLink( $randomText = null ) {
		global $wgHoneypotTemplates;
		
		$urls = self::getHoneypotURLs();

		$index = rand( 0, count( $urls ) - 1 );
		$url = $urls[$index];
		$index = rand( 0, count( $wgHoneypotTemplates ) - 1 );
		$template = $wgHoneypotTemplates[$index];

		if ( !$randomText )
			$randomText = wfGenerateToken( );

		// Variable replacement
		$output = strtr( $template,
			array(
				'honeypoturl' => $url,
				'randomtext' => htmlspecialchars( $randomText )
			)
		);

		return "$output\n";
	}
	
	public static function isIPListed( $ip ) {
		$subnet = substr( IP::toHex( $ip ), 0, -6 );
		$subnet_ips = self::getHoneypotIPs( $subnet );

		return !empty($subnet_ips[$ip]);
	}
	
	// Gets data from memcached
	// for a given class A subnet
	public static function getHoneypotData( $subnet ) {
		if ( isset(self::$Data[$subnet]) ) {
			return self::$Data[$subnet];
		}
		// Check cache
		global $wgMemc;
		
		$data = $wgMemc->get( wfMemcKey( 'honeypot-data', $subnet ) );
		if ($data) {
			wfDebug( "Honeypot Integration: Got data for subnet $subnet from memcached\n" );
			self::$mData[$subnet] = $data;
			return $data;
		}
		
		global $wgHoneypotAutoLoad;
		
		if ($wgHoneypotAutoLoad) {
			list($data,$ips) = self::loadHoneypotData( $subnet );
			return $data;
		}
		
		wfDebug( "Honeypot Integration: Couldn't find honeypot data for subnet $subnet ".
					"in cache, and AutoLoad disabled\n" );
	}
	
	// Gets IPs from memcached for a given Class A subnet
	public static function getHoneypotIPs( $subnet ) {
		if ( isset(self::$IPs[$subnet]) ) {
			return self::$IPs[$subnet];
		}
	
		// Check cache
		global $wgMemc;
		
		$ips = $wgMemc->get( wfMemcKey( 'honeypot-ips', $subnet ) );
		if ($ips) {
			wfDebug( "Honeypot Integration: Got IPs for subnet $subnet from memcached\n" );
			self::$IPs[$subnet] = $ips;
			return $ips;
		}
		
		global $wgHoneypotAutoLoad;
		
		if ($wgHoneypotAutoLoad) {
			list($data,$ips) = self::loadHoneypotData( $subnet );
			return $ips;
		}
		
		wfDebug( "Honeypot Integration: Couldn't find honeypot data for subnet $subnet" .
					" in cache, and AutoLoad disabled\n" );
	}
	
	// Loads data and saves it to memcached
	public static function loadHoneypotData() {
		list($data,$ips) = self::loadHoneypotDataFromFile();
		
		global $wgMemc;
		foreach ( $ips as $subnet => $ipData ) {
			wfDebugLog( 'HoneypotDebug', "Inserting data for subnet $subnet" );
			$wgMemc->set( wfMemcKey( 'honeypot-data', $subnet ), $data[$subnet], 86400 );
			$wgMemc->set( wfMemcKey( 'honeypot-ips', $subnet ), $ips[$subnet], 86400 );
		}
		
		return array($data,$ips);
	}
	
	// Loads data
	public static function loadHoneypotDataFromFile() {
		global $wgHoneypotDataFile;
		$fh = fopen( $wgHoneypotDataFile, 'r' );
		
		$save_data = array();
		$ips = array();
		
		$count = 0;
		
		while ( !feof($fh) ) {
			$line = trim( fgets( $fh ) );
			$data = preg_split( '/\s/', $line, 3 );
			
			if ( IP::isIPAddress( $data[0] ) ) {
				$subnet = substr( IP::toHex( $data[0] ), 0, -6 );
				
				if ( !isset($ips[$subnet]) )
					$ips[$subnet] = array();
				if ( !isset( $save_data[$subnet] ) )
					$save_data[$subnet] = array();
				
				$save_data[$subnet][$data[0]] = $data;
				$ips[$subnet][$data[0]] = true;
				
				$count++;
				
				if ( $count % 100 == 0) {
					wfDebugLog( 'HoneypotDebug', "Done $count IPs -- $data[0]" );
				}
			}
		}
		
		fclose( $fh );
		
		self::$IPs = $ips;
		self::$Data = $save_data;
		
		return array( $save_data, $ips );
	}
	
	public static function onGetUserPermissionsErrorsExpensive() {
		$ip = wfGetIP();
		
		if ( self::isIPListed( $ip ) ) {
			wfDebugLog( 'HoneypotIntegrationMatches', "Attempted edit from $ip matched honeypot" );
		}
		return true;
	}
	
	public static function onRecentChangeSave( $rc ) {
		$ip = wfGetIP();
		if ( self::isIPListed( $ip ) ) {
			$user = $rc->getAttribute( 'rc_user_text' );
			$revid = $rc->getAttribute( 'rc_this_oldid' );
			$logid = $rc->getAttribute( 'rc_logid' );
			$rcid = $rc->getAttribute( 'rc_id' );
			
			wfDebugLog( 'HoneypotIntegrationMatches', "$ip is listed in honeypot data. ".
						"$user made RCID $rcid REVID $revid LOGID $logid." );
		}
		
		return true;
	}
}
