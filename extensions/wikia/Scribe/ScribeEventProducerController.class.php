<?php

class ScribeEventProducerController extends WikiaController {
	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}

	public function onSaveComplete( &$oArticle, &$oUser, $text, $summary, $minor, $undef1, $undef2, &$flags, $oRevision, &$status, $baseRevId ) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$key = ( isset( $status->value['new'] ) && $status->value['new'] == 1 ) ? 'create' : 'edit';
		$is_archive = !empty( $undef1 );

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' =>  $key, 'archive' => $is_archive ) );		
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision ) ) {
				$oScribeProducer->sendLog();
			}
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}

	public function onSaveRevisionComplete( $oArticle, $oRevision, $revision_id, $oUser, $can_added = true ) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		# producer
		if ( $can_added ) {
			$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) );		
			if ( is_object( $oScribeProducer ) ) {
				if ( $oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision, $revision_id ) ) {
					$oScribeProducer->sendLog();
				}
			}
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return true;		
	}

	public function onDeleteComplete( &$oArticle, &$oUser, $reason, $page_id ) {
		$this->app->wf->ProfileIn( __METHOD__ );

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

		$oArticle = new Article( $oTitle );		

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) );		
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision ) ) {
				$oScribeProducer->sendLog();
			}
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;		
	}

	public function onArticleUndelete( &$oTitle, $is_new = false ) {
		$this->app->wf->ProfileIn( __METHOD__ );

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'undelete' ) );		
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildUndeletePackage( $oTitle ) ) {
				$oScribeProducer->sendLog();
			}
		}
			
		$this->app->wf->ProfileOut( __METHOD__ );
		return true;		
	}

	public function onMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $page_id, $redirect_id = 0 ) {
		$this->app->wf->ProfileIn( __METHOD__ );

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) );		
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildMovePackage( $oNewTitle, $oUser, $page_id ) ) {
				$oScribeProducer->sendLog();
			}
		}

		if ( !empty( $redirect_id ) ) {
			$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) );		
			if ( is_object( $oScribeProducer ) ) {
				if ( $oScribeProducer->buildMovePackage( $oOldTitle, $oUser, null, $redirect_id ) ) {
					$oScribeProducer->sendLog();
				}
			}
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;		
	}
}
