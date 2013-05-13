<?php

class ScribeEventProducer {
	private $app = null;
	private $mParams, $mKey, $mEventType;

	private $mediaNS = array(NS_IMAGE, NS_FILE);

	const
		EDIT_CATEGORY 		    = 'log_edit',
		CREATEPAGE_CATEGORY		= 'log_create',
		UNDELETE_CATEGORY	    = 'log_undelete',
		DELETE_CATEGORY		    = 'log_delete';

	const
		EDIT_CATEGORY_INT			= 1,
		CREATEPAGE_CATEGORY_INT		= 2,
		DELETE_CATEGORY_INT			= 3,
		UNDELETE_CATEGORY_INT		= 4;

	function __construct( WikiaApp $app, $key, $archive = 0 ) {
		$this->app = $app;
		switch ( $key ) {
			case 'edit' 		:
				$this->mKey = self::EDIT_CATEGORY;
				$this->mEventType = self::EDIT_CATEGORY_INT;
				break;
			case 'create' 		:
				$this->mKey = self::CREATEPAGE_CATEGORY;
				$this->mEventType = self::CREATEPAGE_CATEGORY_INT;
				break;
			case 'delete' 		:
				$this->mKey = self::DELETE_CATEGORY;
				$this->mEventType = self::DELETE_CATEGORY_INT;
				break;
			case 'undelete'		:
				$this->mKey = self::UNDELETE_CATEGORY;
				$this->mEventType = self::UNDELETE_CATEGORY_INT;
				break;
		}

		$this->setCityId( $this->app->wg->CityId );
		$this->setServerName( $this->app->wg->Server );
		$this->setIp( $this->app->wg->Request->getIP() );
		$this->setHostname( wfHostname() );
		$this->setBeaconId ( wfGetBeaconId() );
		$this->setArchive( $archive );
		$this->setLanguage();
		$this->setCategory();
	}

	public function buildEditPackage( $oPage, $oUser, $oRevision = null, $revision_id = null ) {
		wfProfileIn( __METHOD__ );

		if ( !is_object( $oPage ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid WikiPage object" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid user object" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !empty( $oRevision ) ) {
			if ( !$oRevision instanceof Revision ) {
				Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid revision object" );
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
		$this->setMediaType( $oTitle );
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
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid WikiPage object" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid user object" );
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

	public function buildUndeletePackage( $oTitle ) {
		wfProfileIn( __METHOD__ );

		if ( !is_object( $oTitle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ({$this->app->wg->CityId}): invalid title object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oPage = WikiPage::factory( $oTitle );
		if ( !$oPage instanceof Article ) {
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

		$oUser = F::build('User', array( $username ), 'newFromName');
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

		$oRevision = F::build('Revision', array( $oTitle ), 'newFromTitle');
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
			$page_id = $oTitle->getArticleId();
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

	public function setMediaType ( $oTitle ) {
		wfProfileIn( __METHOD__ );

		$result = 0;
		$page_namespace = $oTitle->getNamespace();
		if ( in_array( $page_namespace, $this->mediaNS ) ) {

			$mediaType = MEDIATYPE_UNKNOWN;
			$oLocalFile = RepoGroup::singleton()->getLocalRepo()->newFile( $oTitle );

			if ( $oLocalFile instanceof LocalFile ) {
				$mediaType = $oLocalFile->getMediaType();
			}
			if ( empty($mediaType) ) {
				$mediaType = MEDIATYPE_UNKNOWN;
			}
			switch ( $mediaType ) {
				case MEDIATYPE_BITMAP			: $result = 1; break;
				case MEDIATYPE_DRAWING		: $result = 2; break;
				case MEDIATYPE_AUDIO			: $result = 3; break;
				case MEDIATYPE_VIDEO			: $result = 4; break;
				case MEDIATYPE_MULTIMEDIA	: $result = 5; break;
				case MEDIATYPE_OFFICE			: $result = 6; break;
				case MEDIATYPE_TEXT				: $result = 7; break;
				case MEDIATYPE_EXECUTABLE	: $result = 8; break;
				case MEDIATYPE_ARCHIVE		: $result = 9; break;
				default 									: $result = 1; break;
			}
		}

		$this->mParams['mediaType'] = $result;
		wfProfileOut( __METHOD__ );
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
		$this->mParams['categoryId'] = WikiFactory::getCategory( $this->app->wg->CityId );
	}

	public function sendLog() {
		wfProfileIn( __METHOD__ );
		try {
			$data = json_encode($this->mParams);
			WScribeClient::singleton( $this->mKey )->send( $data );
		}
		catch( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}
		wfProfileOut( __METHOD__ );
	}

	public function setMediaLinks( $oPage ) {
		wfProfileIn(__METHOD__);

		$links = array( 'image' => 0, 'video' => 0 );
		if ( isset( $oPage->mPreparedEdit ) && isset( $oPage->mPreparedEdit->output ) ) {
			$images = $oPage->mPreparedEdit->output->getImages();
			if ( !empty($images) ) {
				foreach ($images as $iname => $dummy) {
					if ( WikiaFileHelper::isVideoStoredAsFile() ) {
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
}
