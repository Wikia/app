<?php

class ScribeEventProducerController extends WikiaController {
	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}

	public function onSaveComplete( &$oArticle, &$oUser, $text, $summary, $minor, $undef1, $undef2, &$flags, $oRevision, &$status, $baseRevId ) {
		$this->app->wf->ProfileIn( __METHOD__ );
						
		if ( !is_object( $oArticle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid article object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid user object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		$key = ( isset( $status->value['new'] ) && $status->value['new'] == 1 ) ? 'create' : 'edit';
		$is_archive = !empty( $undef1 );

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' =>  $key, 'archive' => $is_archive ) );		
		if ( is_object( $oScribeProducer ) ) {
			$oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision );
			$oScribeProducer->sendLog();
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}

	public function onSaveRevisionComplete( $oArticle, $oRevision, $revision_id, $oUser ) {
		$this->app->wf->ProfileIn( __METHOD__ );
						
		if ( !is_object( $oArticle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid article object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid user object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		# producer
 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) );		
		if ( is_object( $oScribeProducer ) ) {
			$oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision, $revision_id );
			$oScribeProducer->sendLog();
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return true;		
	}

	public function onDeleteComplete( &$oArticle, &$oUser, $reason, $page_id ) {
		$this->app->wf->ProfileIn( __METHOD__ );
						
		if ( !is_object( $oArticle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid article object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid user object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'delete' ) );		
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildRemovePackage ( $oArticle, $oUser, $page_id ) ) {		
				$oScribeProducer->sendLog();
			}
		} 

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}

	public function onRevisionUndeleted( &$oTitle, $oRevision, $page_id ) {
		$this->app->wf->ProfileIn( __METHOD__ );

		if ( !is_object( $oTitle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid title object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		if ( !$oRevision instanceof Revision ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid revision object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}

		$oArticle = new Article( $oTitle );
		if ( !$oArticle instanceof Article ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid article object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) );		
		if ( is_object( $oScribeProducer ) ) {
			$oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision );
			$oScribeProducer->sendLog();
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;		
	}

	public function onArticleUndelete( &$oTitle, $is_new = false ) {
		$this->app->wf->ProfileIn( __METHOD__ );

		if ( !is_object( $oTitle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid title object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}

		$oArticle = new Article( $oTitle );
		if ( !$oArticle instanceof Article ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid article object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		$username = $oArticle->getUserText();
		if ( empty( $username ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid username" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}

		$oUser = F::build('User', array( $username ), 'newFromName');		
		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid user object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
			
 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'undelete' ) );		
		if ( is_object( $oScribeProducer ) ) {
			$oScribeProducer->buildEditPackage( $oArticle, $oUser );
			$oScribeProducer->sendLog();
		}
			
		$this->app->wf->ProfileOut( __METHOD__ );
		return true;		
	}

	public function onMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $page_id, $redirect_id = 0 ) {
		$this->app->wf->ProfileIn( __METHOD__ );

		if ( !$oNewTitle instanceof Title ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid title (new) object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}

		$oRevision = F::build('Revision', array( $oNewTitle ), 'newFromTitle');		
		if ( !$oRevision instanceof Revision ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid revision object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}

		if ( empty( $page_id ) ) {
			$page_id = $oRevision->getPage();
		}

		$oArticle = F::build('Article', array( $page_id ), 'newFromId');		
		if ( !$oArticle instanceof Article ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid article object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) );		
		if ( is_object( $oScribeProducer ) ) {
			$oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision );
			$oScribeProducer->sendLog();
		}

		if ( !empty( $redirect_id ) ) {
			# old title as a #Redirect 
			if ( !$oOldTitle instanceof Title ) {
				Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid title (old) object" );
				$this->app->wf->ProfileOut( __METHOD__ );
				return true;
			}

			$oRevision = F::build('Revision', array( $oOldTitle ), 'newFromTitle');		
			if ( !is_object($oRevision) ) {
				$db = wfGetDB( DB_MASTER );
				$oRevision = Revision::loadFromPageId( $db, $redirect_id );
			}

			if ( !$oRevision instanceof Revision ) {
				Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid revision (old) object" );
				$this->app->wf->ProfileOut( __METHOD__ );
				return true;
			}

			$redirect_page_id = $oRevision->getPage();
			if ( empty( redirect_page_id ) || $redirect_page_id < 0 ) {
				$redirect_page_id = $oOldTitle->getArticleId();
			}
							
			$oArticle = F::build('Article', array( $redirect_page_id ), 'newFromId');		
			if ( !$oArticle instanceof Article ) {
				Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid article (old) object" );
				$this->app->wf->ProfileOut( __METHOD__ );
				return true;
			}
	
	 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) );		
			if ( is_object( $oScribeProducer ) ) {
				$oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision );
				$oScribeProducer->sendLog();
			}
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;		
	}
}