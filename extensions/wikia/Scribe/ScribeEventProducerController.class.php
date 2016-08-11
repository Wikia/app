<?php

use Wikia\Logger\WikiaLogger;

class ScribeEventProducerController {

	static public function onUploadComplete( UploadBase $oForm ) {
		wfProfileIn( __METHOD__ );

		$title = $oForm->getTitle();
		if ( $title instanceof Title ) {
			$article = \Article::newFromID( $title->getArticleID() );
			$revision = \Revision::newFromId( $title->getLatestRevID() );
			$user = \User::newFromId( $revision->getUser() );

			$oScribeProducer = new ScribeEventProducer( 'edit' );
			if ( $oScribeProducer->buildEditPackage( $article, $user, $revision ) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

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

	static public function onArticleDeleteComplete( &$oPage, &$oUser, $reason, $page_id ) {
		wfProfileIn( __METHOD__ );

		WikiaLogger::instance()->debug( "SUS-761::onArticleDeleteComplete", [
			'page_id' => $page_id
		] );

 		$oScribeProducer = new ScribeEventProducer( 'delete' );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildRemovePackage ( $oPage, $oUser, $page_id ) ) {

				WikiaLogger::instance()->debug( "SUS-761::onArticleDeleteComplete LOG");

				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onArticleUndelete( &$oTitle, $created = false ) {
		wfProfileIn( __METHOD__ );

 		$oScribeProducer = new ScribeEventProducer( 'undelete' );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildUndeletePackage( $oTitle, $created ) ) {
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

	static public function notifyPageHasChanged( $oPage ) {
		wfProfileIn( __METHOD__ );

		$username = $oPage->getUserText();
		if ( empty( $username ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe: invalid username" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oUser = User::newFromName( $username );
		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe: invalid user object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oScribeProducer = new ScribeEventProducer( 'edit' );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildEditPackage( $oPage, $oUser) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
