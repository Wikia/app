<?php
/**
 * Simple hook for displaying additional information in Special:Statistics
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 */

use Wikia\Logger\WikiaLogger;

$wgHooks["CustomSpecialStatistics" ][] = "DumpsOnDemand::customSpecialStatistics";
$wgExtensionMessagesFiles[ "DumpsOnDemand" ] =  __DIR__ . '/DumpsOnDemand.i18n.php';

class DumpsOnDemand {

	const DEFAULT_COMPRESSION_FORMAT = '7zip';
	const DUMPS_AMAZON_URL_BASE = 'https://s3.amazonaws.com/wikia_xml_dumps/';

	/**
	 * From this moment on we use Amazon S3 storage for the dumps.
	 * All earlier dumps are gone and all data referring to them should be considered invalid.
	 */
	const S3_MIGRATION = '20131002154415';

	const S3_COMMAND = '/usr/bin/s3cmd -c /etc/s3cmd/amazon_prod.cfg';

	/**
	 * @param SpecialStatistics $page
	 * @param string $text
	 * @return bool
	 * @throws \Wikia\Util\AssertionException
	 */
	static public function customSpecialStatistics( SpecialStatistics $page, string &$text ): bool {
		global $wgDBname, $wgCityId;

		$user = $page->getUser();
		$request = $page->getRequest();
		$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		/**
		 * get last dump request timestamp
		 */
		$wiki = WikiFactory::getWikiByID( $wgCityId );
		$available = strtotime( wfTimestampNow() ) - strtotime( $wiki->city_lastdump_timestamp )  > 7 * 24 * 60 * 60;

		$tmpl->set( 'title', $page->getTitle() );
		$tmpl->set( 'isAnon', $user->isAnon() );

		$dumpInfo = self::getLatestDumpInfo( $wgCityId );
		$sTimestamp = $dumpInfo ? $dumpInfo['timestamp'] : false;
		$sDumpExtension = self::getExtensionFromCompression($dumpInfo ? $dumpInfo['compression'] : false);
		$tmpl->set( 'nolink', false);
		if ( empty( $sTimestamp ) ) {
			$sTimestamp = $page->msg( 'dump-database-last-unknown' )->escaped();
			$tmpl->set( 'nolink', true );
		}

		$tmpl->set( "curr", array(
			"url" => self::DUMPS_AMAZON_URL_BASE . self::getPath( "{$wgDBname}_pages_current.xml{$sDumpExtension}" ),
			"timestamp" => $sTimestamp
		));

		$tmpl->set( "full", array(
			"url" => self::DUMPS_AMAZON_URL_BASE . self::getPath( "{$wgDBname}_pages_full.xml{$sDumpExtension}" ),
			"timestamp" => $sTimestamp
		));

		// The Community Central's value of the wgDumpRequestBlacklist variable contains an array of users who are not allowed to request dumps with this special page.
		$aDumpRequestBlacklist = (array) unserialize( WikiFactory::getVarByName( 'wgDumpRequestBlacklist', WikiFactory::COMMUNITY_CENTRAL )->cv_value, [ 'allowed_classes' => false ] );

		$bIsAllowed = $user->isAllowed( 'dumpsondemand' ) && !in_array( $user->getName(), $aDumpRequestBlacklist );
		$tmpl->set( 'bIsAllowed', $bIsAllowed );
		$tmpl->set( 'editToken', $user->getEditToken());

		if ( $request->wasPosted() &&
			 $request->getVal('dumpRequest') &&
		     $available && $bIsAllowed &&
		     $user->matchEditToken( $request->getVal( 'editToken' ) ) ) {
			self::queueDump( $wgCityId );
			wfDebug( __METHOD__, ": request for database dump was posted\n" );
			$text = Wikia::successbox( $page->msg( 'dump-database-request-requested' )->text() ) . $text;
			$available = false;
		}

		$tmpl->set( 'available', $available );

		$text .= $tmpl->render( 'dod' );

		return true;
	}

	/**
	 * @param int $iCityId
	 * @param bool $bHidden
	 * @param bool $bClose
	 * @throws Wikia\Util\AssertionException
	 */
	static public function queueDump( int $iCityId, bool $bHidden = false, bool $bClose = false ) {
		global $wgUser;

		$oWiki = WikiFactory::getWikiByID( $iCityId );

		\Wikia\Util\Assert::true(
			is_object( $oWiki ),
			sprintf( 'No such wiki. city_id: %d.', $iCityId )
		);

		$iUserId = $wgUser->getId();

		$task = ( new \Wikia\Tasks\Tasks\DumpsOnDemandTask() )
			->setQueue( \Wikia\Tasks\Queues\DumpsOnDemandQueue::NAME )
			->wikiId( $iCityId )
			->createdBy( $iUserId );

		$task->call( 'dump' );
		$task_id = $task->queue();

		$row = [
			'task_id'        => $task_id,
			'dump_wiki_id'   => $iCityId,
			'dump_user_id'   => $iUserId,
			'dump_requested' => wfTimestampNow()
		];

		if ( $bHidden ) {
			$row['dump_hidden'] = 'Y';
		}

		if ( $bClose ) {
			$row['dump_closed'] = 'Y';
		}

		$oDB = wfGetDB( DB_MASTER, array(), 'wikicities' );
		$oDB->insert( 'dumps', $row, __METHOD__ );
		$oDB->update(
				'city_list',
				array( 'city_lastdump_timestamp' => wfTimestampNow() ),
				array( 'city_id' => $iCityId ),
				__METHOD__
		);

		WikiFactory::clearCache( $iCityId );
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
	 *
	 * @param string $sPath
	 * @param bool $bPublic
	 * @param string|null $sMimeType
	 * if $sMimeType is set then the specified mime tipe is set, otherwise
	 *      let AmazonS3 decide on mime type.
	 * @return mixed
	 * @throws Exception
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

		wfShellExec( $sCmd, $iStatus );

		WikiaLogger::instance()->info( __METHOD__, [
			'remote_path' => $sDestination,
			'size' => $size,
			'time_sec' => wfTime() - $time,
		] );

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
