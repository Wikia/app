<?php

class ScribeEventProducerController {
	static public function onSaveComplete( &$oPage, &$oUser, $text, $summary, $minor, $undef1, $undef2, &$flags, $oRevision, &$status, $baseRevId ) {
		wfProfileIn( __METHOD__ );

		$key = ( isset( $status->value['new'] ) && $status->value['new'] == 1 ) ? 'create' : 'edit';
		$is_archive = !empty( $undef1 );

 		$oScribeProducer = new ScribeEventProducer( $key, $is_archive );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onSaveRevisionComplete( $oPage, $oRevision, $revision_id, $oUser, $allow = true ) {
		wfProfileIn( __METHOD__ );

		# producer
		if ( $allow ) {
			$oScribeProducer = new ScribeEventProducer( 'edit' );
			if ( is_object( $oScribeProducer ) ) {
				if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision, $revision_id ) ) {
					$oScribeProducer->sendLog();
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onDeleteComplete( &$oPage, &$oUser, $reason, $page_id ) {
		wfProfileIn( __METHOD__ );

 		$oScribeProducer = new ScribeEventProducer( 'delete' );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildRemovePackage ( $oPage, $oUser, $page_id ) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onRevisionUndeleted( &$oTitle, Revision $oRevision, $page_id ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		if ( !is_object( $oTitle ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe ($wgCityId): invalid title object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oPage = WikiPage::factory( $oTitle );
		$oUser = User::newFromId( $oRevision->getUser() );

 		$oScribeProducer = new ScribeEventProducer( 'edit' );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onArticleUndelete( &$oTitle, $is_new = false ) {
		wfProfileIn( __METHOD__ );

 		$oScribeProducer = new ScribeEventProducer( 'undelete' );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildUndeletePackage( $oTitle ) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $page_id, $redirect_id = 0 ) {
		wfProfileIn( __METHOD__ );

 		$oScribeProducer = new ScribeEventProducer( 'edit' );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildMovePackage( $oNewTitle, $oUser, $page_id ) ) {
				$oScribeProducer->sendLog();
			}
		}

		if ( !empty( $redirect_id ) ) {
			$oScribeProducer = new ScribeEventProducer( 'edit' );
			if ( is_object( $oScribeProducer ) ) {
				if ( $oScribeProducer->buildMovePackage( $oOldTitle, $oUser, null, $redirect_id ) ) {
					$oScribeProducer->sendLog();
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
