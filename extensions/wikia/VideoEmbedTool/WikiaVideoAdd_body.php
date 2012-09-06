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
		global $wgOut, $wgRequest, $wgUser;

		if( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'WikiaVideoAdd' );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setPageTitle( "WikiaVideoAdd" );
		$wgOut->setArticleRelated( false );

		$this->mAction = $wgRequest->getVal( "action" );
		$this->mPosted = $wgRequest->wasPosted();

		switch( $this->mAction ) {
			case 'submit' :
				if ( $wgRequest->wasPosted() ) {
					$this->mAction = $this->doSubmit();
				}
				break;
			default:
				$this->showForm();
				break;
		}
	}

	public function showForm() {
		global $wgOut, $wgRequest, $wgUser;
		$titleObj = Title::makeTitle( NS_SPECIAL, 'WikiaVideoAdd' );
		$action = htmlspecialchars($titleObj->getLocalURL( "action=submit" ));
		( '' != $wgRequest->getVal( 'name' ) ) ? $name = $wgRequest->getVal( 'name' ) : $name = '';

		if( !$wgUser->isAllowed( 'upload' ) ) {
			if( !$wgUser->isLoggedIn() ) {
				$wgOut->addHTML( wfMsg( 'wva-notlogged' ) );
			} else {
				$wgOut->addHTML( wfMsg( 'wva-notallowed' ) );
			}
		} else {
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
						"out"		=> 	$wgOut,
						"action"	=>	$action,
						"name"		=> 	$name,
						) );
			$wgOut->addHTML( $oTmpl->render("quickform") );
		}
	}

	public function doSubmit() {
		global $wgOut, $wgRequest, $wgUser;
		$replaced = false;
		if( '' == $wgRequest->getVal( 'wpWikiaVideoAddName' ) ) {
			if( '' != $wgRequest->getVal( 'wpWikiaVideoAddPrefilled' ) ) {
				$this->mName = $wgRequest->getVal( 'wpWikiaVideoAddPrefilled' );
				$replaced = true;
			} else {
				$this->mName = '';
			}
		} else {
			$this->mName = $wgRequest->getVal( 'wpWikiaVideoAddName' );
		}

		( '' != $wgRequest->getVal( 'wpWikiaVideoAddUrl' ) ) ? $this->mUrl = $wgRequest->getVal( 'wpWikiaVideoAddUrl' ) : $this->mUrl = '';

		if ( ( '' != $this->mName ) && ( '' != $this->mUrl ) ) {
			$this->mName = ucfirst($this->mName);

			// sanitize all video titles
			$this->mName = VideoFileUploader::sanitizeTitle( $this->mName );

			$title = Title::makeTitleSafe( NS_VIDEO, $this->mName );
			if ( $title instanceof Title ) {
				$permErrors = $title->getUserPermissionsErrors( 'edit', $wgUser );
				$permErrorsUpload = $title->getUserPermissionsErrors( 'upload', $wgUser );
				$permErrorsCreate = ( $title->exists() ? array() : $title->getUserPermissionsErrors( 'create', $wgUser ) );

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
						$wgOut->addHTML( wfMsg( 'wva-failure' ) );
						return;
					}
				}

				if ( WikiaFileHelper::useWikiaVideoExtForEmbed() ) {
					$video = new VideoPage( $title );
					$video->parseUrl( $this->mUrl );
					$video->setName( $this->mName );
					$video->save();
				}

				$sk = RequestContext::getMain()->getSkin();
				$link_back = $sk->makeKnownLinkObj( $title );

				if ($replaced) {
					$wgOut->addHTML( wfMsg( 'wva-success-replaced', $link_back ) );
				} else {
					$wgOut->addHTML( wfMsg( 'wva-success', $link_back ) );
				}
			} else {
				//bad title returned
				$wgOut->addHTML( wfMsg( 'wva-failure' ) );
			}
		} else {
			//one of two params blank
			$wgOut->addHTML( wfMsg( 'wva-failure' ) );
		}
	}
}

