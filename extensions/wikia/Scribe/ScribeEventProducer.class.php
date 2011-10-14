<?php

class ScribeEventProducer {
	private $app = null;
	private $mParams, $mKey, $mEventType;

	private $mediaNS = array(NS_VIDEO, NS_IMAGE, NS_FILE);

	const 
		EDIT_CATEGORY 		    = 'log_edit',
		CREATEPAGE_CATEGORY		= 'log_create',
		UNDELETE_CATEGORY	    = 'log_undelete',
		DELETE_CATEGORY		    = 'log_delete';

	const 
		EDIT_CATEGORY_INT					= 1,
		CREATEPAGE_CATEGORY_INT		= 2,
		DELETE_CATEGORY_INT				= 3,
		UNDELETE_CATEGORY_INT			= 4;

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
		$this->setIp( wfGetIp() );
		$this->setHostname( wfHostname() );
		$this->setBeaconId ( wfGetBeaconId() );
		$this->setArchive( $archive );	
	}
	
	public function buildEditPackage( $oArticle, $oUser, $oRevision = null, $revision_id = null ) {
		$this->app->wf->ProfileIn( __METHOD__ );

		$revision_id = $page_id = $page_namespace = 0;
		$oTitle = $oArticle->getTitle();
		
		if ( $oRevision instanceof Revision ) {
			if ( is_null( $revision_id ) ) {
				$revision_id 		= $oRevision->getId();
			}
			$page_id				= $oRevision->getPage();
			$rev_timestamp	= $oRevision->getTimestamp();
			$rev_text 			= $oRevision->getText();
			$rev_size				= $oRevision->getSize();
		} else {
			$page_id 				= $oArticle->getID();
			if ( is_null( $revision_id ) ) {
				$revision_id  = $oTitle->getLatestRevID(GAID_FOR_UPDATE);
			}
			if ( empty( $page_id ) ) {
				$pageId = $oTitle->getArticleID( GAID_FOR_UPDATE );
			}
			$rev_timestamp	= $oArticle->getTimestamp();
			$rev_text				= $oTitle->getText();
			$rev_size				= strlen( $rev_size );
		}

		$this->setPageId( $page_id ) ;
		$this->setPageNamespace( $oTitle->getNamespace() );
		$this->setRevisionId( $revision_id );
		$this->setUserId( $oUser->getId() );
		$this->setUserIsBot( $oUser->isAllowed( 'bot' ) );
		$this->setIsContent( $oTitle->isContentPage() );
		$this->setIsRedirect( $oTitle->isRedirect() );
		$this->setRevisionTimestamp( wfTimestamp( TS_DB, $rev_timestamp ) );
		$this->setRevisionSize( $rev_size );
		$this->setMediaType( $oTitle );
		$this->setMediaLinks( $oArticle );
		$this->setTotalWords( str_word_count( $rev_text ) );	

		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	public function buildRemovePackage ( $oArticle, $oUser, $page_id ) {
		$this->app->wf->ProfileIn( __METHOD__ );
	
		$oTitle = $oArticle->getTitle();
                                    
		$table = 'recentchanges';
		$what = array( 'rc_logid' );
		$cond = array(
			'rc_title'			=> $oTitle->getDBkey(),
			'rc_namespace'	=> $oTitle->getNamespace(),
			'rc_log_action'	=> 'delete',
			'rc_user' 			=> $oUser->getID()
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
			$this->setRevisionId( $oArticle->getLatest() );
			$this->setUserId( $oUser->getId() );
			$this->setUserIsBot( $oUser->isAllowed( 'bot' ) );
			$this->setIsContent( $oTitle->isContentPage() );
			$this->setIsRedirect( $oTitle->isRedirect() );
			$this->setRevisionTimestamp( wfTimestamp( TS_DB, $oArticle->getTimestamp() ) );
		}	

		$this->app->wf->ProfileOut( __METHOD__ );
		return $logid;    
	}
	
	public function setCityId ( $city_id ) { 
		$this->mParams['city_id'] = $city_id; 
	}
	
	public function setServerName ( $server_name ) {
		$this->mParams['server_name'] = $server_name;
	}
	
	public function setHostname ( $hostname ) {
		$this->mParams['hostname'] = $hostname;
	}
	
	public function setPageId ( $page_id ) { 
		$this->mParams['page_id'] = $page_id; 
	}
	
	public function setPageNamespace ( $page_namespace ) { 
		$this->mParams['page_namespace'] = $page_namespace; 
	}
	
	public function setRevisionId ( $revision_id  ) { 
		$this->mParams['revision_id'] = $revision_id;
	}
	
	public function setLogId ( $log_id  ) { 
		$this->mParams['log_id'] = $log_id; 
	}
	
	public function setUserId ( $user_id ) { 
		$this->mParams['user_id'] = $user_id; 
	}
	
	public function setUserIsBot ( $user_is_bot ) { 
		$this->mParams['user_is_bot'] = $user_is_bot; 
	}
	
	public function setIsContent ( $is_content ) { 
		$this->mParams['is_content'] = $is_content; 
	}
	
	public function setIsRedirect ( $is_redirect ) { 
		$this->mParams['is_redirect'] = $is_redirect; 
	}
	
	public function setIP ( $ip ) { 
		$this->mParams['user_ip'] = $ip; 
	}
	
	public function setRevisionTimestamp ( $revision_timestamp ) { 
		$this->mParams['revision_timestamp'] = $revision_timestamp; 
	}
	
	public function setRevisionSize ( $size ) { 
		$this->mParams['revision_size'] = $size; 
	}
	
	public function setMediaType ( $oTitle ) { 
		$this->app->wf->ProfileIn( __METHOD__ );

		$result = 0;
		$page_namespace = $oTitle->getNamespace();
		if ( in_array( $page_namespace, $this->mediaNS ) ) {

			if ( $page_namespace == NS_VIDEO ) {
				if ( !empty($this->app->wg->EnableVideoToolExt) && class_exists( 'VideoPage' ) ) {
					$videoName = F::build('VideoPage', array( $oTitle ), 'getNameFromTitle');
					if ( $videoName ) {
						$oTitle = F::build('Title', array( $page_namespace, $videoName ), 'makeTitle');
					}
				}
			}
			
			$mediaType = MEDIATYPE_UNKNOWN;
			$oLocalFile = F::build('LocalFile', array( $oTitle, RepoGroup::singleton()->getLocalRepo() ), 'newFromTitle');
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

		$this->mParams['media_type'] = $result; 
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	public function setImageLinks ( $image_links ) { 
		$this->mParams['image_links'] = $image_links; 
	}
	
	public function setVideoLinks ( $video_links ) { 
		$this->mParams['video_links'] = $video_links; 
	}
	
	public function setTotalWords ( $total_words ) { 
		$this->mParams['total_Words'] = $total_words; 
	}
	
	public function setArchive ( $archive ) { 
		$this->mParams['archive'] = $archive; 
	}

	public function setBeaconId ( $beacon_id ) {
		$this->mParams['beacon_id'] = $beacon_id;
	}
	
	public function sendLog() {
		$this->app->wf->ProfileIn( __METHOD__ );
		try {
			$data = F::build('Wikia', array( $this->mParams ), 'json_encode');
			WScribeClient::singleton( $this->mKey )->send( $data );
		}
		catch( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	public function setMediaLinks( $oArticle ) {
		$links = array();
		if ( isset( $oArticle->mPreparedEdit ) && isset( $oArticle->mPreparedEdit->output ) ) {
			$images = $oArticle->mPreparedEdit->output->getImages();
			if ( !empty($images) ) {
				foreach ($images as $iname => $dummy) {
					if ( substr($iname, 0, 1) == ':' ) {
						$links['video']++;							
					} else {
						$links['image']++;
					}
				}
			}			
		}
		
		$this->setImageLinks( $links['image'] );
		$this->setVideoLinks( $links['video'] );
		
		return $links;			
	}
}
