<?php

use Wikia\Logger\WikiaLogger;
use Wikia\Rabbit\ConnectionBase;

class DataWarehouseEventProducer {
	protected static $rabbit;
	private $app = null;
	private $mParams, $mKey;

	const
		EDIT_CATEGORY       = 'log_edit',
		CREATEPAGE_CATEGORY = 'log_create',
		UNDELETE_CATEGORY   = 'log_undelete',
		DELETE_CATEGORY     = 'log_delete';

	function __construct( $key, $archive = 0 ) {
		$this->app = F::app();
		switch ( $key ) {
			case 'edit':
				$this->mKey = self::EDIT_CATEGORY;
				break;
			case 'create':
				$this->mKey = self::CREATEPAGE_CATEGORY;
				break;
			case 'delete':
				$this->mKey = self::DELETE_CATEGORY;
				break;
			case 'undelete':
				$this->mKey = self::UNDELETE_CATEGORY;
				break;
		}
		$geo = json_decode( RequestContext::getMain()->getRequest()->getCookie( 'Geo', '' ) );
		$this->setCityId( $this->app->wg->CityId );
		$this->setServerName( $this->app->wg->Server );

		$this->setIp( RequestContext::getMain()->getRequest()->getIP() );
		$this->setGeoRegion( $geo->region );
		$this->setGeoCountry( $geo->country );
		$this->setGeoContinent( $geo->continent );
		$this->setHostname( wfHostname() );
		$this->setArchive( $archive );
		$this->setLanguage();
		$this->setCategory();
	}

	public function buildEditPackage( $oPage, $oUser, $oRevision = null ) {
		wfProfileIn( __METHOD__ );

		if ( !is_object( $oPage ) ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid WikiPage object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !$oUser instanceof User ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid user object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !empty( $oRevision ) ) {
			if ( !$oRevision instanceof Revision ) {
				WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid revision object", [
					'method' => __METHOD__
				] );
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		$revision_id = $page_id = $page_namespace = 0;
		$oTitle = $oPage->getTitle();

		if ( $oRevision instanceof Revision ) {
			if ( empty( $revision_id ) ) {
				$revision_id = $oRevision->getId();
			}
			$page_id = $oRevision->getPage();
			$rev_timestamp = $oRevision->getTimestamp();
			$rev_text = $oRevision->getText();
			$rev_size = $oRevision->getSize();
		} else {
			$page_id = $oPage->getId();
			if ( empty( $revision_id ) ) {
				$revision_id = $oTitle->getLatestRevID( Title::GAID_FOR_UPDATE );
			}
			if ( empty( $page_id ) ) {
				$page_id = $oTitle->getArticleID( Title::GAID_FOR_UPDATE );
			}
			$rev_timestamp = $oPage->getTimestamp();
			$rev_text = $oTitle->getText();
			$rev_size = strlen( $rev_text );
		}

		$this->setPageId( $page_id ) ;
		$this->setPageNamespace( $oTitle->getNamespace() );
		$this->setPageTitle( $oTitle->getDBkey() );
		$this->setRevisionId( $revision_id );
		$this->setUserId( $oUser->getId() );
		$this->setUserIsBot( $oUser->isAllowed( 'bot' ) );
		$this->setIsContent( $oTitle->isContentPage() );
		$this->setIsRedirect( $oTitle->isRedirect() );
		$this->setRevisionTimestamp( wfTimestamp( TS_DB, $rev_timestamp ) );
		$this->setRevisionSize( $rev_size );
		$this->setMediaLinks( $oPage );
		$this->setTotalWords( str_word_count( $rev_text ) );

		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro,$t) );
		$this->setEventTS($d->format("Y-m-d\TH:i:s.uO"));

		wfProfileOut( __METHOD__ );

		return true;
	}

	public function buildRemovePackage ( $oPage, $oUser, $page_id ) {
		wfProfileIn( __METHOD__ );

		if ( !is_object( $oPage ) ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid WikiPage object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !$oUser instanceof User ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid user object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return false;
		}

		$oTitle = $oPage->getTitle();

		$table = 'recentchanges';
		$what = array( 'rc_logid' );
		$cond = array(
			'rc_title'		=> $oTitle->getDBkey(),
			'rc_namespace'	=> $oTitle->getNamespace(),
			'rc_log_action'	=> 'delete',
			'rc_user' 		=> $oUser->getID()
		);
		$options = array( 'ORDER BY' => 'rc_id DESC' );

		$dbr = wfGetDB( DB_SLAVE );
		$oRow = $dbr->selectRow( $table, $what, $cond, __METHOD__, $options );
		if ( !isset( $oRow->rc_logid ) ) {
			$dbr = wfGetDB( DB_MASTER );
			$oRow = $dbr->selectRow( $table, $what, $cond, __METHOD__, $options );
		}

		$logid = ( !empty( $oRow ) ) ? $oRow->rc_logid : 0;

		if ( $logid ) {
			$this->setPageId( $page_id ) ;
			$this->setPageNamespace( $oTitle->getNamespace() );
			$this->setPageTitle( $oTitle->getDBkey() );
			$this->setRevisionId( $oPage->getLatest() );
			$this->setUserId( $oUser->getId() );
			$this->setUserIsBot( $oUser->isAllowed( 'bot' ) );
			$this->setIsContent( $oTitle->isContentPage() );
			$this->setIsRedirect( $oTitle->isRedirect() );
			$this->setRevisionTimestamp( wfTimestamp( TS_DB, $oPage->getTimestamp() ) );
			$this->setLogId( $logid );
		}

		wfProfileOut( __METHOD__ );
		return $logid;
	}

	public function buildUndeletePackage( $oTitle, $created = false ) {
		wfProfileIn( __METHOD__ );

		if ( !is_object( $oTitle ) ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid title object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oPage = WikiPage::factory( $oTitle );
		if ( !$oPage instanceof WikiPage ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid WikiPage object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$username = $oPage->getUserText();
		if ( empty( $username ) ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid username", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oUser = User::newFromName( $username );
		if ( !$oUser instanceof User ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid user object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oLocalFile = null;
		if ( $created && $oTitle->getNamespace() == NS_FILE ) {
			$oLocalFile = wfLocalFile( $oTitle );
		}

		wfProfileOut( __METHOD__ );

		return $this->buildEditPackage( $oPage, $oUser, null, $oLocalFile );
	}

	public function buildMovePackage( $oTitle, $oUser, $page_id = null, $redirect_id = null ) {
		wfProfileIn( __METHOD__ );

		if ( !$oTitle instanceof Title ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid title object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oRevision = Revision::newFromTitle( $oTitle );
		if ( !is_object($oRevision) && !empty( $redirect_id ) ) {
			$db = wfGetDB( DB_MASTER );
			$oRevision = Revision::loadFromPageId( $db, $redirect_id );
		}
		if ( !$oRevision instanceof Revision ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid revision object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( empty( $page_id ) ) {
			$page_id = $oRevision->getPage();
		}

		if ( empty( $page_id ) || $page_id < 0 ) {
			$page_id = $oTitle->getArticleId();
		}

		$oPage = WikiPage::newFromID( $page_id );
		if ( !$oPage instanceof WikiPage ) {
			WikiaLogger::instance()->error( "Cannot send log ({$this->app->wg->CityId}): invalid WikiPage object", [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileOut( __METHOD__ );

		return $this->buildEditPackage( $oPage, $oUser, $oRevision );
	}

	public function setGeoRegion ( $region ) {
		$this->mParams['geoRegion'] = $region;
	}

	public function setGeoCountry ( $country ) {
		$this->mParams['geoCountry'] = $country;
	}

	public function setGeoContinent ( $continent ) {
		$this->mParams['geoContinent'] = $continent;
	}

	public function setCityId ( $city_id ) {
		$this->mParams['cityId'] = $city_id;
	}

	public function setServerName ( $server_name ) {
		$this->mParams['serverName'] = $server_name;
	}

	public function setHostname ( $hostname ) {
		$this->mParams['hostname'] = $hostname;
	}

	public function setPageId ( $page_id ) {
		$this->mParams['pageId'] = $page_id;
	}

	public function setPageNamespace ( $page_namespace ) {
		$this->mParams['pageNamespace'] = $page_namespace;
	}

	public function setPageTitle ( $title ) {
		$this->mParams['pageTitle'] = $title;
	}

	public function setRevisionId ( $revision_id  ) {
		$this->mParams['revId'] = $revision_id;
	}

	public function setLogId ( $log_id  ) {
		$this->mParams['logId'] = $log_id;
	}

	public function setUserId ( $user_id ) {
		$this->mParams['userId'] = $user_id;
	}

	public function setUserIsBot ( $user_is_bot ) {
		$this->mParams['userIsBot'] = intval( $user_is_bot );
	}

	public function setIsContent ( $is_content ) {
		$this->mParams['isContent'] = intval( $is_content );
	}

	public function setIsRedirect ( $is_redirect ) {
		$this->mParams['isRedirect'] = intval( $is_redirect );
	}

	public function setIP ( $ip ) {
		$this->mParams['userIp'] = IP::sanitizeIP( $ip );
	}

	public function setRevisionTimestamp ( $revision_timestamp ) {
		$this->mParams['revTimestamp'] = $revision_timestamp;
	}

	public function setRevisionSize ( $size ) {
		$this->mParams['revSize'] = $size;
	}

	public function setEventTS ( $ts ) {
		$this->mParams['eventTS'] = $ts;
	}

	public function setImageLinks ( $image_links ) {
		$this->mParams['imageLinks'] = $image_links;
	}

	public function setVideoLinks ( $video_links ) {
		$this->mParams['videoLinks'] = $video_links;
	}

	public function setTotalWords ( $total_words ) {
		$this->mParams['totalWords'] = $total_words;
	}

	public function setArchive ( $archive ) {
		$this->mParams['archive'] = intval( $archive );
	}

	public function setLanguage( $lang_code = '' ) {
		if ( empty( $lang_code ) ) {
			$lang_code = $this->app->wg->LanguageCode;
		}
		$this->mParams['languageId'] = WikiFactory::LangCodeToId($lang_code);
	}

	public function setCategory() {
		//This field is called categoryId but getCategory returns an object with cat_id and cat_name fields
		$this->mParams['categoryId'] = WikiFactory::getCategory( $this->app->wg->CityId );
	}

	public function sendLog() {
		wfProfileIn( __METHOD__ );
		$data = json_encode($this->mParams);
		$this->getRabbit()->publish( $this->mKey, $data );
		WikiaLogger::instance()->info( 'DW event sent', [
			'method' => __METHOD__
		] );
		wfProfileOut( __METHOD__ );
	}

	public function setMediaLinks( $oPage ) {
		wfProfileIn(__METHOD__);

		$links = array( 'image' => 0, 'video' => 0 );
		if ( isset( $oPage->mPreparedEdit ) && isset( $oPage->mPreparedEdit->output ) ) {
			$images = $oPage->mPreparedEdit->output->getImages();
			if ( !empty($images) ) {
				foreach ($images as $iname => $dummy) {
					$file = wfFindFile($iname);
					if ($file instanceof LocalFile) {
						$mediaType = $file->getMediaType();
						switch ($mediaType) {
							case MEDIATYPE_VIDEO:
								$links['video']++;
								break;
							default:
								$links['image']++;
						}
					}
					else {
						//@todo remove this code after video refactoring
						if ( substr($iname, 0, 1) == ':' ) {
							$links['video']++;
						} else {
							$links['image']++;
						}
					}
				}
			}
		}

		$this->setImageLinks( $links['image'] );
		$this->setVideoLinks( $links['video'] );

		wfProfileOut(__METHOD__);

		return $links;
	}

	/*
	 * Helper methods
	 */
	/** @return \Wikia\Rabbit\ConnectionBase */
	protected static function getRabbit() {
		global $wgEditEventsRabbitConfig;

		if ( !isset( self::$rabbit ) ) {
			self::$rabbit = new ConnectionBase( $wgEditEventsRabbitConfig );
		}

		return self::$rabbit;
	}
}
