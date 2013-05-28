<?php

class VideoHandlerController extends WikiaController {

	public function getEmbedCode() {
		$title = $this->getVal('fileTitle', '');
		$width = $this->getVal('width', '');
		$autoplay = $this->getVal( 'autoplay', false );

		$error = '';
		if (empty($title)) {
			$error = $this->wf->msgForContent('videohandler-error-missing-parameter', 'title');
		}
		else {
			if (empty($width)) {
				$error = $this->wf->msgForContent('videohandler-error-missing-parameter', 'width');
			}
			else {
				$title = Title::newFromText($title, NS_FILE);
				$file = ($title instanceof Title) ? wfFindFile($title) : false;
				if ($file === false) {
					$error = $this->wf->msgForContent('videohandler-error-video-no-exist');
				}
				else {
					$videoId = $file->getVideoId();
					$assetUrl = $file->getPlayerAssetUrl();
					$embedCode = $file->getEmbedCode($width, $autoplay, true);
					$this->setVal('videoId', $videoId);
					$this->setVal('asset', $assetUrl);
					$this->setVal('embedCode', $embedCode);
				}
			}
		}

		if (!empty($error)) {
			$this->setVal('error', $error);
		}
	}

	public function getSanitizedOldVideoTitleString(){
		$sTitle = $this->getVal( 'videoText', '' );

		$prefix = '';
		if ( strpos( $sTitle, ':' ) === 0 ){
			$sTitle = substr( $sTitle, 1);
			$prefix = ':';
		}
		if ( empty( $sTitle ) ){
			$this->setVal( 'error', 1 );
		}

		$sTitle = VideoFileUploader::sanitizeTitle($sTitle, '_');

		$this->setVal(
			'result',
			$prefix.$sTitle
		);
	}

	/**
	 * remove video
	 * @requestParam string title
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function removeVideo() {
		wfProfileIn( __METHOD__ );

		$videoTitle = $this->getVal( 'title', '' );
		if ( empty($videoTitle) ) {
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'videos-error-empty-title' )->text();
			wfProfileOut( __METHOD__ );
			return;
		}

		// check if user is logged in
		if ( !$this->wg->User->isLoggedIn() ) {
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'videos-error-not-logged-in' )->text();
			wfProfileOut( __METHOD__ );
			return;
		}

		// check if user is blocked
		if ( $this->wg->User->isBlocked() ) {
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'videos-error-blocked-user' )->text();
			wfProfileOut( __METHOD__ );
			return;
		}

		// check if read-only
		if ( $this->wf->ReadOnly() ) {
			$this->result = 'error';
			$this->msg = $this->wf->Message( 'videos-error-readonly' )->text();
			wfProfileOut( __METHOD__ );
			return;
		}

		$error = '';

		$title = Title::newFromText( $videoTitle, NS_FILE );
		$file = ( $title instanceof Title ) ? $this->wf->Findfile( $title ) : false;
		if ( $file instanceof File && WikiaFileHelper::isFileTypeVideo($file) ) {
			// check permissions
			$permissionErrors = $title->getUserPermissionsErrors( 'delete', $this->wg->User );
			if ( count( $permissionErrors ) ) {
				$this->result = 'error';
				$this->msg = $this->wf->Message( 'videos-error-permissions' )->text();
				wfProfileOut( __METHOD__ );
				return;
			}

			$reason = '';
			$suppress = false;
			if ( $file->isLocal() ) {
				$status = Status::newFatal( 'cannotdelete', $this->wf->EscapeWikiText( $title->getPrefixedText() ) );
				$page = WikiPage::factory( $title );
				$dbw = $this->wf->GetDB( DB_MASTER );
				try {
					// delete the associated article first
					if ( $page->doDeleteArticleReal( $reason, $suppress, 0, false ) >= WikiPage::DELETE_SUCCESS ) {
						$status = $file->delete( $reason, $suppress );
						if( $status->isOK() ) {
							$dbw->commit();
						} else {
							$dbw->rollback();
						}
					}
				} catch ( MWException $e ) {
					// rollback before returning to prevent UI from displaying incorrect "View or restore N deleted edits?"
					$dbw->rollback();
					$error = $e->getMessage();
				}

				if ( $status->isOK() ) {
					$oldimage = null;
					$user = $this->wg->User;
					$this->wf->RunHooks( 'FileDeleteComplete', array( &$file, &$oldimage, &$page, &$user, &$reason ) );
				} else if ( !empty($error) ) {
					$error = $status->getMessage();
				}
			} else {
				if ( $title->exists() ) {
					$article = Article::newFromID( $title->getArticleID() );
				} else {
					$botUser = User::newFromName( 'WikiaBot' );
					$flags = EDIT_NEW | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT;

					$videoHandlerHelper = new VideoHandlerHelper();
					$status = $videoHandlerHelper->addCategoryVideos( $title, $botUser, $flags );
				}

				if ( !$article->doDeleteArticle( $reason, $suppress, 0, true, $error ) ) {
					if ( empty($error) ) {
						$error = $this->wf->Message( 'videohandler-remove-error-unknow' )->text();
					}
				}
			}
		} else {
			$error = $this->wf->Message( 'videohandler-error-video-no-exist' )->text();
		}

		if ( empty($error) ) {
			$this->result = 'ok';
			$this->msg = $this->wf->Message( 'videohandler-remove-video-modal-success', $title )->text();
		} else {
			$this->result = 'error';
			$this->msg = $error;
		}

		wfProfileOut( __METHOD__ );
	}

}
