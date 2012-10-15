<?php

class ScribeEventProducerController extends WikiaController {
	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}

	public function onSaveComplete( &$oPage, &$oUser, $text, $summary, $minor, $undef1, $undef2, &$flags, $oRevision, &$status, $baseRevId ) {
		$this->app->wf->ProfileIn( __METHOD__ );

		$key = ( isset( $status->value['new'] ) && $status->value['new'] == 1 ) ? 'create' : 'edit';
		$is_archive = !empty( $undef1 );

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' =>  $key, 'archive' => $is_archive ) ); /* @var $oScribeProducer ScribeEventProducer */
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
				$oScribeProducer->sendLog();
			}
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}

	public function onSaveRevisionComplete( $oPage, $oRevision, $revision_id, $oUser, $allow = true ) {
		$this->app->wf->ProfileIn( __METHOD__ );

		# producer
		if ( $allow ) {
			$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) ); /* @var $oScribeProducer ScribeEventProducer */
			if ( is_object( $oScribeProducer ) ) {
				if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision, $revision_id ) ) {
					$oScribeProducer->sendLog();
				}
			}
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}

	public function onDeleteComplete( &$oPage, &$oUser, $reason, $page_id ) {
		$this->app->wf->ProfileIn( __METHOD__ );

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'delete' ) ); /* @var $oScribeProducer ScribeEventProducer */
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildRemovePackage ( $oPage, $oUser, $page_id ) ) {
				$oScribeProducer->sendLog();
			}
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}

	public function onRevisionUndeleted( &$oTitle, Revision $oRevision, $page_id ) {
		$this->app->wf->ProfileIn( __METHOD__ );

		if ( !is_object( $oTitle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($this->app->wg->CityId): invalid title object" );
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}

		$oPage = WikiPage::factory( $oTitle );
		$oUser = User::newFromId( $oRevision->getUser() );

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) ); /* @var $oScribeProducer ScribeEventProducer */
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
				$oScribeProducer->sendLog();
			}
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}

	public function onArticleUndelete( &$oTitle, $is_new = false ) {
		$this->app->wf->ProfileIn( __METHOD__ );

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'undelete' ) ); /* @var $oScribeProducer ScribeEventProducer */
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

 		$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) ); /* @var $oScribeProducer ScribeEventProducer */
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildMovePackage( $oNewTitle, $oUser, $page_id ) ) {
				$oScribeProducer->sendLog();
			}
		}

		if ( !empty( $redirect_id ) ) {
			$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => 'edit' ) ); /* @var $oScribeProducer ScribeEventProducer */
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
