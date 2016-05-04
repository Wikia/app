<?php
/**
 * Simple hook for displaying additional information in Special:Statistics
 * 
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "DumpsOnDemand::customSpecialStatistics";
$wgExtensionMessagesFiles[ "DumpsOnDemand" ] =  __DIR__ . '/DumpsOnDemand.i18n.php';

class DumpsOnDemand {

	const BASEURL = "http://dumps.wikia.net";
	const DEFAULT_COMPRESSION_FORMAT = '7zip';

    /**
     * From this moment on we use Amazon S3 storage for the dumps.
     * All earlier dumps are gone and all data referring to them should be considered invalid.
     */
	const S3_MIGRATION = '20131002154415';

	const S3_COMMAND = '/usr/bin/s3cmd -c /etc/s3cmd/amazon_prod.cfg';

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

		$dumpInfo = self::getLatestDumpInfo( $wgCityId );
		$sTimestamp = $dumpInfo ? $dumpInfo['timestamp'] : false;
		$sDumpExtension = self::getExtensionFromCompression($dumpInfo ? $dumpInfo['compression'] : false);
		$tmpl->set( 'nolink', false);
		if ( empty( $sTimestamp ) ) {
			$sTimestamp = wfMessage( 'dump-database-last-unknown' )->escaped();
			$tmpl->set( 'nolink', true );
		}

		$tmpl->set( "curr", array(
			"url" => 'http://s3.amazonaws.com/wikia_xml_dumps/' . self::getPath( "{$wgDBname}_pages_current.xml{$sDumpExtension}" ),
			"timestamp" => $sTimestamp
		));

		$tmpl->set( "full", array(
			"url" => 'http://s3.amazonaws.com/wikia_xml_dumps/' . self::getPath( "{$wgDBname}_pages_full.xml{$sDumpExtension}" ),
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
		 *    * 'muppet' for 'muppet.xml.7z'
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
     * if $sMimeType is set then the specified mime tipe is set, otherwise
     *      let AmazonS3 decide on mime type.
	 */
	static public function putToAmazonS3( $sPath, $bPublic = true, $sMimeType = null ) {
		$time = wfTime();
		$sDestination = wfEscapeShellArg(
			's3://wikia_xml_dumps/'
			. DumpsOnDemand::getPath( basename( $sPath ) )
		);

		$size = filesize( $sPath );
		$sPath = wfEscapeShellArg( $sPath );

		$sCmd = self::S3_COMMAND . ' --add-header=Content-Disposition:attachment';
		if ( !is_null( $sMimeType ) ) {
			$sMimeType = wfEscapeShellArg( $sMimeType );
			$sCmd .= " --mime-type={$sMimeType}";
		}
		$sCmd .= ($bPublic)? ' --acl-public' : '';
		$sCmd .= " put {$sPath} {$sDestination}";

		Wikia::log( __METHOD__, "info", "Put {$sPath} to Amazon S3 storage: command: {$sCmd} size: {$size}", true, true);

		wfShellExec( $sCmd, $iStatus );

		$time = Wikia::timeDuration( wfTime() - $time );
		Wikia::log( __METHOD__, "info", "Put {$sPath} to Amazon S3 storage: status: {$iStatus}, time: {$time}", true, true);

		return $iStatus;
	}

	/**
	 * Get the timestamp and compression format of the latest completed dump for given wikia.
	 *
	 * Returns false or an associative array with "timestamp" and "compression" keys.
	 *
	 * @param $iWikiaId int Wikia ID
	 * @return array|bool Latest dump info or false
	 */
	static public function getLatestDumpInfo( $iWikiaId ) {
		global $wgMemc;
		$sKey = wfSharedMemcKey( $iWikiaId, 'latest_dump_info' );
		$dumpInfo = $wgMemc->get( $sKey );
		if ( !$dumpInfo ) {
			$oDB = wfGetDB( DB_SLAVE, array(), 'wikicities' );
			$row = $oDB->selectRow(
				'dumps',
				array(
					'dump_completed',
					'dump_compression'
				),
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
			if ( $row ) {
				$dumpInfo = array(
					'timestamp' => $row->dump_completed,
					'compression' => $row->dump_compression,
				);
			}
			if ( $dumpInfo ) {
				$wgMemc->set( $sKey, $dumpInfo, 7*24*60*60 ); // a week
			}
		}
		return $dumpInfo;
	}

	/**
	 * Purge information about latest dump for a given wikia.
	 *
	 * @param $iWikiaId int Wikia ID
	 */
	static public function purgeLatestDumpInfo( $iWikiaId ) {
		global $wgMemc;
		$sKey = wfSharedMemcKey( $iWikiaId, 'latest_dump_info' );
		$wgMemc->delete($sKey);
	}

	/**
	 * Get file extension from compression format.
	 *
	 * @param $compression string Compression format (should be one of "gzip" or "7zip")
	 * @return string File extension (including dot)
	 */
	static public function getExtensionFromCompression( $compression ) {
		if ( $compression == 'gzip' ) { # old compression format
			return '.gz';
		}
		return '.7z';
	}
}
