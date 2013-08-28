<?php

/**
 * simple hook for displaying additional informations in Special:Statistics
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "DumpsOnDemand::customSpecialStatistics";
$wgExtensionMessagesFiles[ "DumpsOnDemand" ] =  dirname( __FILE__ ) . '/DumpsOnDemand.i18n.php';

$wgAvailableRights[] = 'dumpsondemand';
$wgGroupPermissions['*']['dumpsondemand'] = false;
$wgGroupPermissions['staff']['dumpsondemand'] = true;
$wgGroupPermissions['sysop']['dumpsondemand'] = true;
$wgGroupPermissions['bureaucrat']['dumpsondemand'] = true;
$wgGroupPermissions['autoconfirmed']['dumpsondemand'] = true;

class DumpsOnDemand {

	const BASEURL = "http://dumps.wikia.net";

	/**
	 * @access public
	 * @static
	 */
	static public function customSpecialStatistics( &$specialpage, &$text ) {
		global $wgOut, $wgDBname, $wgLang, $wgRequest, $wgTitle, $wgUser, $wgCityId, $wgHTTPProxy;

		/**
		 * read json file with dumps information
		 */
		$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$index = array();
		$proxy = array();
		if( isset( $wgHTTPProxy) && $wgHTTPProxy ) {
			$proxy[ "proxy" ] = $wgHTTPProxy;
		}
		else {
			$proxy[ "noProxy" ] = true;
		}

		$url = self::getUrl( $wgDBname, "index.json" );
		$json = Http::get( $url, 5, $proxy );
		if( $json ) {
			wfDebug( __METHOD__ . ": getting informations about last dump from $url succeded\n" );
			$index = (array )json_decode( $json );
		}
		else {
			wfDebug( __METHOD__ . ": getting informations about last dump from $url failed\n" );
		}

		/**
		 * get last dump request timestamp
		 */
		$wiki = WikiFactory::getWikiByID( $wgCityId );
		if( strtotime(wfTimestampNow()) - strtotime($wiki->city_lastdump_timestamp)  > 7*24*60*60 ) {
			$tmpl->set( "available", true );
		}
		else {
			$tmpl->set( "available", false );
		}

		$tmpl->set( "title", $wgTitle );
		$tmpl->set( "isAnon", $wgUser->isAnon() );

		$tmpl->set( "curr", array(
			"url" => self::getUrl( $wgDBname, "pages_current.xml.gz" ),
			"timestamp" => !empty( $index["pages_current.xml.gz"]->mwtimestamp )
				? $wgLang->timeanddate( $index[ "pages_current.xml.gz"]->mwtimestamp )
				: wfMessage( 'dump-database-last-unknown' )->escaped()
		));

		$tmpl->set( "full", array(
			"url" => self::getUrl( $wgDBname, "pages_full.xml.gz" ),
			"timestamp" => !empty( $index[ "pages_full.xml.gz" ]->mwtimestamp )
				? $wgLang->timeanddate( $index[ "pages_full.xml.gz" ]->mwtimestamp )
				: wfMessage( 'dump-database-last-unknown' )->escaped()
		));

		// The Community Central's value of the wgDumpRequestBlacklist variable contains an array of users who are not allowed to request dumps with this special page.
		$aDumpRequestBlacklist = (array) unserialize( WikiFactory::getVarByName( 'wgDumpRequestBlacklist', WikiFactory::COMMUNITY_CENTRAL )->cv_value );

		$bIsAllowed = $wgUser->isAllowed( 'dumpsondemand' ) && !in_array( $wgUser->getName(), $aDumpRequestBlacklist );
		$tmpl->set( 'bIsAllowed', $bIsAllowed );

		$tmpl->set( "index", $index );
		$text .= $tmpl->render( "dod" );

		if( $wgRequest->wasPosted() && $bIsAllowed ) {
			self::sendMail();
			wfDebug( __METHOD__, ": request for database dump was posted\n" );
			$text = Wikia::successbox( wfMsg( "dump-database-request-requested" ) ) . $text;
		}

		return true;
	}

	/**
	 * return url to place where dumps are stored
	 *
	 * @static
	 * @access public
	 *
	 * @return String
	 */
	static public function getUrl( $database, $file, $baseurl = false ) {
		$database = strtolower( $database );

		return sprintf(
			"%s/%s/%s/%s/%s",
			( $baseurl === false ) ? self::BASEURL : $baseurl,
			substr( $database, 0, 1),
			substr( $database, 0, 2),
			$database,
			$file
		);
	}

	/**
	 * @static
	 * @access public
	 */
	static public function sendMail( $sDbName = null, $iCityId = null, $bHidden = false, $bClose = false ) {
            
            if ( is_null( $sDbName ) ) {
                global $wgDBname;
                $sDbName = $wgDBname;
            }
            
            if ( is_null( $iCityId ) ) {
                global $wgCityId;
                $iCityId = $wgCityId;
            }
            
            global $wgServer, $wgUser;
            
            $title = SpecialPage::getTitleFor( "Statistics" );
            
            $body = sprintf(
                    "Database dump request for %s, city id %d, hidden %d, closeWiki %d\nurl %s\nRequested by %s\n",
                    $sDbName, $iCityId, (int) $bHidden, (int) $bClose, $title->getFullUrl(), $wgUser->getName()
            );
            
            UserMailer::send(
                new MailAddress( "dump-requests@wikia-inc.com" ),
                new MailAddress( "dump-requests@wikia-inc.com" ),
                "Database dump request for {$sDbName}",
                $body,
                null /*reply*/,
                null /*ctype*/,
                'DumpRequest'
            );
            
            /**
             * @todo universal WikiFactory metod for that
             */
            $dbw = WikiFactory::db( DB_MASTER );
            $dbw->update(
                    "city_list",
                    array( "city_lastdump_timestamp" => wfTimestampNow() ),
                    array( "city_id" => $iCityId ),
                    __METHOD__
            );
	}
}
