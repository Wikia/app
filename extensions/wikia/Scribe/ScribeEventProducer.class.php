<?php

use \Wikia\Logger\WikiaLogger;

class ScribeEventProducer {
	private $app = null;
	private $mParams, $mKey, $mEventType;
	private $errorTemplateMsg;

	const
		EDIT_CATEGORY       = 'log_edit',
		CREATEPAGE_CATEGORY = 'log_create',
		UNDELETE_CATEGORY   = 'log_undelete',
		DELETE_CATEGORY     = 'log_delete';

	const
		EDIT_CATEGORY_INT       = 1,
		CREATEPAGE_CATEGORY_INT = 2,
		DELETE_CATEGORY_INT     = 3,
		UNDELETE_CATEGORY_INT   = 4;

	const IMAGE = 'image';

	const VIDEO = 'video';

	function __construct( $key, $archive = 0 ) {
		$this->app = F::app();
		switch ( $key ) {
			case 'edit':
				$this->mKey = static::EDIT_CATEGORY;
				$this->mEventType = static::EDIT_CATEGORY_INT;
				break;
			case 'create':
				$this->mKey = static::CREATEPAGE_CATEGORY;
				$this->mEventType = static::CREATEPAGE_CATEGORY_INT;
				break;
			case 'delete':
				$this->mKey = static::DELETE_CATEGORY;
				$this->mEventType = static::DELETE_CATEGORY_INT;
				break;
			case 'undelete':
				$this->mKey = static::UNDELETE_CATEGORY;
				$this->mEventType = static::UNDELETE_CATEGORY_INT;
				break;
			default:
				WikiaLogger::instance()->error("ScribeEventProducer::not valid key");
				break;
		}

		$this->setCityId( $this->app->wg->CityId );
		$this->setServerName( $this->app->wg->Server );
		$this->setIP( $this->app->wg->Request->getIP() );
		$this->setHostname( wfHostname() );
		$this->setBeaconId ( wfGetBeaconId() );
		$this->setArchive( $archive );
		$this->setLanguage();
		$this->setCategory();
		$this->setErrorTemplateMessage();
	}

	/**
	 * @param $oUser User
	 * @return bool
	 */
	public function isUser( $oUser ) {
		if ( !$oUser instanceof User ) {
			\Wikia\Logger\WikiaLogger::instance()->error( $this->errorTemplateMsg . "invalid user object" );
			return false;
		}
		return true;
	}

	/**
	 * @param $oPage WikiPage
	 * @return bool
	 */
	public function isObject( $oPage ) {
		if ( !is_object( $oPage ) ) {
			\Wikia\Logger\WikiaLogger::instance()->error( $this->errorTemplateMsg . "invalid WikiPage object" );
			return false;
		}
		return true;
	}

	/**
	 * @param $oRevision Revision
	 * @return bool
	 */
	public function isRevision( $oRevision ) {
		if ( !empty( $oRevision ) && !$oRevision instanceof Revision ) {
			\Wikia\Logger\WikiaLogger::instance()->error( $this->errorTemplateMsg . "invalid revision object" );
			return false;
		}
		return true;
	}

	/**
	 * @param $oPage WikiPage
	 * @param $oUser User
	 * @param null $oRevision Revision
	 * @return bool
	 */
	public function buildEditPackage( $oPage, $oUser, $oRevision = null ) {
		wfProfileIn( __METHOD__ );

		if ( !( $this->isObject( $oPage ) && $this->isUser( $oUser ) && $this->isRevision( $oRevision ) ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$revision_id = $page_id = 0;
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

		if ( $oTitle instanceof Title && $oTitle->getNamespace() == NS_FILE ) {
			$oLocalFile = wfLocalFile( $oTitle );
			if ( $oLocalFile instanceof File ) {
				$this->setMediaType( $oTitle );
				$this->setIsImageForReview();
			} else {
				$this->setIsImageForReview( false );
			}
		}

		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro,$t) );
		$this->setEventTS($d->format("Y-m-d\TH:i:s.uO"));

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @param $oPage WikiPage
	 * @param $oUser User
	 * @param $page_id int
	 * @return bool|int
	 */
	public function buildRemovePackage( $oPage, $oUser, $page_id ) {
		global $wgCityId;

		wfProfileIn( __METHOD__ );

		if ( !( $this->isObject( $oPage ) && $this->isUser( $oUser ) ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$oTitle = $oPage->getTitle();

		if ( $oTitle instanceof Title && $oTitle->getNamespace() == NS_FILE ) {
			$oLocalFile = wfLocalFile( $oTitle );
			if ( $oLocalFile instanceof File ) {
				// Remove Local file from the queue

				\Wikia\Logger\WikiaLogger::instance()->info( 'ScribeEventProducer::buildRemovePackage', [
					'oTitle' => $oTitle,
					'oFile' => $oLocalFile,
				] );
				$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
				$task->call('deleteFromQueue', [
					'wiki_id' => $wgCityId,
					'page_id' => $page_id,
				] );
				$task->prioritize();
				$task->queue();

				wfProfileOut( __METHOD__ );
				return 0;
			}
		}

		$table = 'recentchanges';
		$what = array( 'rc_logid' );
		$cond = array(
			'rc_title'		=> $oTitle->getDBkey(),
			'rc_namespace'	=> $oTitle->getNamespace(),
			'rc_log_action'	=> 'delete',
			'rc_user' 		=> $oUser->getId()
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

	public function buildUndeletePackage( $oTitle ) {
		wfProfileIn( __METHOD__ );

		if ( !is_object( $oTitle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid title object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oPage = WikiPage::factory( $oTitle );
		if ( !$oPage instanceof WikiPage ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid WikiPage object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$username = $oPage->getUserText();
		if ( empty( $username ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid username" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oUser = User::newFromName( $username );
		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid user object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileOut( __METHOD__ );

		return $this->buildEditPackage( $oPage, $oUser );
	}

	public function buildMovePackage( $oTitle, $oUser, $page_id = null, $redirect_id = null ) {
		wfProfileIn( __METHOD__ );

		if ( !$oTitle instanceof Title ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid title object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oRevision = Revision::newFromTitle( $oTitle );
		if ( !is_object($oRevision) && !empty( $redirect_id ) ) {
			$db = wfGetDB( DB_MASTER );
			$oRevision = Revision::loadFromPageId( $db, $redirect_id );
		}
		if ( !$oRevision instanceof Revision ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid revision object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( empty( $page_id ) ) {
			$page_id = $oRevision->getPage();
		}

		if ( empty( $page_id ) || $page_id < 0 ) {
			$page_id = $oTitle->getArticleID();
		}

		$oPage = WikiPage::newFromID( $page_id );
		if ( !$oPage instanceof WikiPage ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid WikiPage object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileOut( __METHOD__ );

		return $this->buildEditPackage( $oPage, $oUser, $oRevision );
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
		$this->mParams['userIp'] = $ip;
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

	public function setMediaType ( $oLocalFile ) {
		$mediaTypeCode = 0;
		if ( $oLocalFile instanceof LocalFile ) {
			$mediaType = $oLocalFile->getMediaType();

			switch ( $mediaType ) {
				case MEDIATYPE_BITMAP:     $mediaTypeCode = 1; break;
				case MEDIATYPE_DRAWING:    $mediaTypeCode = 2; break;
				case MEDIATYPE_AUDIO:      $mediaTypeCode = 3; break;
				case MEDIATYPE_VIDEO:      $mediaTypeCode = 4; break;
				case MEDIATYPE_MULTIMEDIA: $mediaTypeCode = 5; break;
				case MEDIATYPE_OFFICE:     $mediaTypeCode = 6; break;
				case MEDIATYPE_TEXT:       $mediaTypeCode = 7; break;
				case MEDIATYPE_EXECUTABLE: $mediaTypeCode = 8; break;
				case MEDIATYPE_ARCHIVE:    $mediaTypeCode = 9; break;
				default:                   $mediaTypeCode = 1; break;
			}
		}

		return $mediaTypeCode;
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

	public function setBeaconId ( $beacon_id ) {
		$this->mParams['beaconId'] = $beacon_id;
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

		// The code should probably be changed to this after double checking the scribe consumers
		//$category = WikiFactory::getCategory( $this->app->wg->CityId );
		//$this->mParams['categoryId'] = isset($category->cat_id) ? $category->cat_id : 0;
		//
		// And when categories are updated:
		//$this->mParams['categories'] = WikiFactory::getCategories( $this->app->wg->CityId );

	}

	public function setIsImageForReview( $bIsImageForReview = true ) {
		$this->mParams['isImageForReview'] = intval( $bIsImageForReview );
	}

	public function setImageApproved( $approved = false ) {
		$this->mParams['imageApproved'] = intval( $approved );
	}

	/**
	 * Sends a unified ImageReviewLog message
	 * @return void
	 */
	private function logSendScribeMessage() {
		WikiaLogger::instance()->info( 'SendScribeMessage', [
			'method' => __METHOD__,
			'params' => $this->mParams,
		] );
	}

	public function sendLog() {
		wfProfileIn( __METHOD__ );
		try {
			$data = json_encode($this->mParams);
			WScribeClient::singleton( $this->mKey )->send( $data );
			$this->logSendScribeMessage();
		}
		catch( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}
		wfProfileOut( __METHOD__ );
	}

	public function setMediaLinks( $oPage ) {
		wfProfileIn(__METHOD__);

		$links = [ self::IMAGE => 0, self::VIDEO => 0 ];
		if ( isset( $oPage->mPreparedEdit ) && isset( $oPage->mPreparedEdit->output ) ) {
			$images = $oPage->mPreparedEdit->output->getImages();
			if ( !empty($images) ) {
				foreach ($images as $iname => $dummy) {
					$file = wfFindFile($iname);
					if ($file instanceof LocalFile) {
						$mediaType = $file->getMediaType();
						$linkName = $mediaType === MEDIATYPE_VIDEO ? self::VIDEO : self::IMAGE;
					}
					else {
						$linkName = substr( $iname, 0, 1 ) == ':' ? self::VIDEO : self::IMAGE;
					}
					$links[ $linkName ]++;
				}
			}
		}

		$this->setImageLinks( $links[ self::IMAGE ] );
		$this->setVideoLinks( $links[ self::VIDEO ] );

		wfProfileOut(__METHOD__);

		return $links;
	}

	private function setErrorTemplateMessage() {
		$this->errorTemplateMsg = "Cannot send log using scribe ({$this->app->wg->CityId}): ";
	}
}
