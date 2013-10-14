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

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

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

		$sTimestamp = self::getLatestDumpTimestamp( $wgCityId );
		$tmpl->set( 'nolink', false);
		if ( empty( $sTimestamp ) ) {
			$sTimestamp = wfMessage( 'dump-database-last-unknown' )->escaped();
			$tmpl->set( 'nolink', true );
		}

		$tmpl->set( "curr", array(
			"url" => 'http://s3.amazonaws.com/wikia_xml_dumps/' . self::getPath( "{$wgDBname}_pages_current.xml.gz" ),
			"timestamp" => $sTimestamp
		));

		$tmpl->set( "full", array(
			"url" => 'http://s3.amazonaws.com/wikia_xml_dumps/' . self::getPath( "{$wgDBname}_pages_full.xml.gz" ),
			"timestamp" => $sTimestamp
		));

		// The Community Central's value of the wgDumpRequestBlacklist variable contains an array of users who are not allowed to request dumps with this special page.
		$aDumpRequestBlacklist = (array) unserialize( WikiFactory::getVarByName( 'wgDumpRequestBlacklist', WikiFactory::COMMUNITY_CENTRAL )->cv_value );

		$bIsAllowed = $wgUser->isAllowed( 'dumpsondemand' ) && !in_array( $wgUser->getName(), $aDumpRequestBlacklist );
		$tmpl->set( 'bIsAllowed', $bIsAllowed );

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

	/**
	 * Puts the specified file to Amazon S3 storage
	 *
	 * if $bPublic, the file will be available for all users
	 */
	static public function putToAmazonS3( $sPath, $bPublic = true ) {
		$time = wfTime();
		$sDestination = wfEscapeShellArg(
			's3://wikia_xml_dumps/'
			. DumpsOnDemand::getPath( basename( $sPath ) )
		);
		$sPath = wfEscapeShellArg( $sPath );
		$sCmd = 'sudo /usr/bin/s3cmd -c /root/.s3cfg --add-header=Content-Disposition:attachment';
		$sCmd .= ($bPublic)? ' --acl-public' : '';
		$sCmd .= " put {$sPath} {$sDestination}";
		wfShellExec( $sCmd, $iStatus );
		$time = Wikia::timeDuration( wfTime() - $time );
		Wikia::log( __METHOD__, "info", "Put {$sPath} to Amazon S3 storage: status: {$iStatus}, time: {$time}", true, true);
		return $iStatus;
	}

	/**
	 * Gets the timestamp of the latest dump.
	 */
	static public function getLatestDumpTimestamp( $iWikiaId ) {
		global $wgMemc;
		$sKey = wfSharedMemcKey( $iWikiaId, 'latest_dump_timestamp' );
		$sTimestamp = $wgMemc->get( $sKey );
		if ( !$sTimestamp ) {
			$oDB = wfGetDB( DB_SLAVE, array(), 'wikicities' );
			$sTimestamp = (string) $oDB->selectField(
				'dumps',
				'dump_completed',
				array(
					'dump_completed IS NOT NULL',
					'dump_wiki_id' => $iWikiaId
				),
				__METHOD__,
				array(
					'ORDER BY' => 'dump_completed DESC',
					'LIMIT' => 1
				)
			);
			if ( $sTimestamp ) {
				$wgMemc->set( $sKey, $sTimestamp, 7*24*60*60 ); // a week
			}
		}
		return $sTimestamp;
	}
}
