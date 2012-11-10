<?php

class WikiaVideoAddForm extends SpecialPage {
	var	$mAction,
		$mPosted,
		$mName,
		$mUrl;

	/* constructor */
	function __construct () {
		$this->mAction = "";
		parent::__construct( "WikiaVideoAdd", "wikiavideoadd" );
	}

	public function execute( $subpage ) {
		global $wgOut;

		if ( !$this->getUser()->isLoggedIn() ) {
			$wgOut->addHTML( wfMsg( 'wva-notlogged' ) );
			return;
		}

		if ( $this->getUser()->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}

		if ( !$this->getUser()->isAllowed( 'upload' ) ) {
			$wgOut->addHTML( wfMsg( 'wva-notallowed' ) );
			return;
		}

		// Add css for form
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/VideoEmbedTool/css/WikiaVideoAdd.scss'));
		
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'WikiaVideoAdd' );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setPageTitle( "WikiaVideoAdd" );
		$wgOut->setArticleRelated( false );

		$this->mAction = $this->getRequest()->getVal( "action" );
		$this->mPosted = $this->getRequest()->wasPosted();

		switch( $this->mAction ) {
			case 'submit' :
				if ( $this->mPosted ) {
					$this->mAction = $this->doSubmit();
				}
				break;
			default:
				$this->showForm();
				break;
		}
	}

	public function showForm( $errors = array() ) {
		global $wgOut;

		$titleObj = Title::makeTitle( NS_SPECIAL, 'WikiaVideoAdd' );
		$action = htmlspecialchars($titleObj->getLocalURL( "action=submit" ));
		
		$name = $this->getRequest()->getVal( 'name', '' );
		$wpWikiaVideoAddName = $this->getRequest()->getVal( 'wpWikiaVideoAddName', '' );
		$wpWikiaVideoAddUrl = $this->getRequest()->getVal( 'wpWikiaVideoAddUrl', '');
		
		if ( !$wgUser->isAllowed( 'upload' ) ) {
			if ( !$wgUser->isLoggedIn() ) {
				$wgOut->addHTML( wfMsg( 'wva-notlogged' ) );
			} else {
				$wgOut->addHTML( wfMsg( 'wva-notallowed' ) );
			}
		} else {
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				'out' => $wgOut,
				'action' => $action,
				'name' => $name,
				'errors' => $errors,
				'wpWikiaVideoAddName' => $wpWikiaVideoAddName,
				'wpWikiaVideoAddUrl' => $wpWikiaVideoAddUrl,
			) );
			$wgOut->addHTML( $oTmpl->render('quickform') );
		}
	}

	public function doSubmit() {
		global $wgOut;

		$errors = array();
		$replaced = false;

		$this->mUrl = $this->getRequest()->getVal( 'wpWikiaVideoAddUrl', '' );
		$this->mName = $this->getRequest()->getVal( 'wpWikiaVideoAddName', '' );
		if ( $this->mName == '' ) {
			$this->mName = $this->getRequest()->getVal( 'name', '' );
			if ( $this->mName != '' ) {
				$replaced = true;
			}
		}

		if ( $this->mUrl == '' ) {
			$errors['videoUrl'] = wfMsg( 'wva-failure' );
			$this->showForm($errors);
			return;
		} else if ( $this->mName == '' ) {
			$videoService = F::build( 'VideoService' );
			$retval = $videoService->addVideo( $this->mUrl );
			if ( is_array($retval) ) {
				list( $title, $videoPageId, $videoProvider ) = $retval;
			} else {
				$errors['videoUrl'] = wfMsg( 'wva-failure' );
				$this->showForm($errors);
				return;
			}
		} else {
			$this->mName = ucfirst($this->mName);

			// sanitize all video titles
			$this->mName = VideoFileUploader::sanitizeTitle( $this->mName );

			$title = Title::makeTitleSafe( NS_VIDEO, $this->mName );
			if ( $title instanceof Title ) {
				$permErrors = $title->getUserPermissionsErrors( 'edit', $this->getUser() );
				$permErrorsUpload = $title->getUserPermissionsErrors( 'upload', $this->getUser() );
				$permErrorsCreate = ( $title->exists() ? array() : $title->getUserPermissionsErrors( 'create', $this->getUser() ) );

				if( $permErrors || $permErrorsUpload || $permErrorsCreate ) {
					header('X-screen-type: error');
					$wgOut->addWikiMsg( 'wva-protected' );
					return;
				}

				if ( WikiaFileHelper::useVideoHandlersExtForEmbed() ){
					$res = null;
					try {
						$res = VideoFileUploader::URLtoTitle( $this->mUrl, $this->mName );
					} catch (Exception $e) {}

					if( !$res ) {
						$errors['videoUrl'] = wfMsg( 'wva-failure' );	
						$this->showForm($errors);
						return;
					}
				}

				if ( WikiaFileHelper::useWikiaVideoExtForEmbed() ) {
					$video = new VideoPage( $title );
					$video->parseUrl( $this->mUrl );
					$video->setName( $this->mName );
					$video->save();
				}
			} else {
				//bad title returned
				$errors['name'] = wfMsg( 'wva-failure' );			
				$this->showForm($errors);
				return;
			}
		}

		if ( $replaced ) {
			$successMsgKey = 'wva-success-replaced';
		} else {
			$successMsgKey = 'wva-success';
		}

		$query = array(
			"sort" => "recent",
			"msg" => $successMsgKey,
			"msgTitle" => urlencode($title),
		);
		$wgOut->redirect( SpecialPage::getTitleFor("Videos")->escapeLocalUrl( $query ) );
	}
}
