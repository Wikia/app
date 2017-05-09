<?php

class ScribeEventProducerController {

	/**
	 * Ugly fix! TODO
	 * The following static properties are declared to store
	 * $oPage, $oUser and $oRevision objects passed from SaveComplete
	 * and SaveRevisionComplete hooks. They are necessary to call
	 * the buildEditPackage() method. For files, to check if they are local,
	 * we need to wait till the UploadComplete hook is run.
	 * This hook only passes an instance of UploadBase class so it is needed
	 * to store the mentioned objects from the previously run hooks.
	 * It is going to be fixed with the new version of the ImageReview tool.
	 * @see    CE-1125 or any ImageReview related ticket
	 * @blame  Adam Karminski <adamk@wikia-inc.com>
	 */
	private static $oPage, $oUser, $oRevision;

	static public function onUploadComplete( UploadBase $oForm ) {
		wfProfileIn( __METHOD__ );

		$oLocalFile = $oForm->getLocalFile();

		$oScribeProducer = new ScribeEventProducer( 'edit' );
		if ( $oScribeProducer->buildEditPackage( self::$oPage, self::$oUser, self::$oRevision, $oLocalFile ) ) {
			$oScribeProducer->sendLog();
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
			/**
			 * Ugly fix! TODO
			 * See the description above.
			 */
			$oTitle = $oPage->getTitle();
			if ( $oTitle->getNamespace() == NS_FILE ) {
				self::$oPage = $oPage;
				self::$oUser = $oUser;
				self::$oRevision = $oRevision;
			}

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
				/**
				 * Ugly fix! TODO
				 * See the description above.
				 */
				$oTitle = $oPage->getTitle();
				if ( $oTitle->getNamespace() == NS_FILE ) {
					self::$oPage = $oPage;
					self::$oUser = $oUser;
					self::$oRevision = $oRevision;
				}

				if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
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
