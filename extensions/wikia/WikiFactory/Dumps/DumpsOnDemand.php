<?php
/**
 * simple hook for displaying additional informations in Special:Statistics
 * 
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "DumpsOnDemand::customSpecialStatistics";
$wgExtensionMessagesFiles[ "DumpsOnDemand" ] =  __DIR__ . '/DumpsOnDemand.i18n.php';

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
				: "unknown"
		));

		$tmpl->set( "full", array(
			"url" => self::getUrl( $wgDBname, "pages_full.xml.gz" ),
			"timestamp" => !empty( $index[ "pages_full.xml.gz" ]->mwtimestamp )
				? $wgLang->timeanddate( $index[ "pages_full.xml.gz" ]->mwtimestamp )
				: "unknown"
		));

		// The Community Central's value of the wgDumpRequestBlacklist variable contains an array of users who are not allowed to request dumps with this special page.
		$aDumpRequestBlacklist = (array) unserialize( WikiFactory::getVarByName( 'wgDumpRequestBlacklist', WikiFactory::COMMUNITY_CENTRAL )->cv_value );

		$bIsAllowed = $wgUser->isAllowed( 'dumpsondemand' ) && !in_array( $wgUser->getName(), $aDumpRequestBlacklist );
		$tmpl->set( 'bIsAllowed', $bIsAllowed );

		$tmpl->set( "index", $index );
		$text .= $tmpl->render( "dod" );

		if( $wgRequest->wasPosted() && $bIsAllowed ) {
			self::queueDump( $wgCityId );
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
         * @deprecated
         */
        static public function sendMail( $sDbName = null, $iCityId = null, $bHidden = false, $bClose = false ) {
            trigger_error( sprintf( 'Using of deprecated method %s.', __METHOD__ ) , E_USER_WARNING );
            self::queueDump( $iCityId, $bHidden, $bClose );
        }

	/**
	 * @static
	 * @access public
	 */
	static public function queueDump( $iCityId = null, $bHidden = false, $bClose = false ) {
            
            if ( is_null( $iCityId ) ) {
                global $wgCityId;
                $iCityId = $wgCityId;
            }
            
            $oWiki = WikiFactory::getWikiByID( $iCityId );
            
            if ( !is_object( $oWiki ) ) {
                trigger_error( sprintf( '%s terminated. No such wiki (city_id: %d.', __METHOD__, $iCityId ) , E_USER_WARNING );
                return null;
            }
            
            global $wgUser;
            
            $aData = array(
                'dump_wiki_id'      => $iCityId,
                'dump_wiki_dbname'  => $oWiki->city_dbname,
                'dump_wiki_url'     => $oWiki->city_url,
                'dump_user_name'    => $wgUser->getName(),
                'dump_requested'    => wfTimestampNow()
            );
            
            if ( $bHidden ) {
                $aData['dump_hidden'] = 'Y';
            }
            
            if ( $bClose ) {
                $aData['dump_closed'] = 'Y';
            }
            
            $oDB = wfGetDB( DB_MASTER, array(), 'wikicities' );
            $oDB->insert( 'dumps', $aData, __METHOD__ );
            $oDB->update(
                    'city_list',
                    array( 'city_lastdump_timestamp' => wfTimestampNow() ),
                    array( 'city_id' => $iCityId ),
                    __METHOD__
            );
	}

	static public function getPath( $sName ) {
		/*
		 * Get the actual name:
		 *    * 'muppet' for 'muppet.xml.gz'
		 *    * 'muppet' for 'muppet'
		 *    * 'htaccess' for '.htaccess'
		 * The name will be in $aMatches[1].
		 */
		$aMatches = array();
		preg_match( '/^\.?([^.]*)\.?.*/u', $sName, $aMatches );

		/* Create the path:
		 *    * 'm/mu/muppet' for 'muppet'
		 *    * 'm/mm/m' for 'm'
		 */
		$sPath = $aMatches[1][0] . DIRECTORY_SEPARATOR . $aMatches[1][0];
		$sPath .= ( empty( $aMatches[1][1] ) )? $aMatches[1][0] : $aMatches[1][1];
		$sPath .= DIRECTORY_SEPARATOR . $sName;
		return $sPath;
	}

}
