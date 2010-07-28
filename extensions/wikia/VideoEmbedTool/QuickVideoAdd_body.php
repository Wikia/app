<?php

class QuickVideoAddForm extends SpecialPage {

	var	$mAction,
		$mPosted,
		$mName,
		$mUrl;

	/* constructor */
	function __construct () {
		$this->mAction = "";
		parent::__construct( "QuickVideoAdd", "quickvideoadd" );
	}

	public function execute( $subpage ) {
		global $wgOut, $wgRequest;

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'QuickVideoAdd' );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setPageTitle( "QuickVideoAdd" );
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
		global $wgOut;
		$titleObj = Title::makeTitle( NS_SPECIAL, 'QuickVideoAdd' );
		$action = $titleObj->escapeLocalURL( "action=submit" );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
					"out"		=> 	$wgOut,
					"action"	=>	$action,
				       ) );
		$wgOut->addHTML( $oTmpl->execute("quickform") );
	}

	public function doSubmit() {
		global $wgOut, $wgRequest, $IP;
		require_once( "$IP/extensions/wikia/WikiaVideo/VideoPage.php" );	

		( '' != $wgRequest->getVal( 'wpQuickVideoAddName' ) ) ? $this->mName = $wgRequest->getVal( 'wpQuickVideoAddName' ) : $this->mName = '';	
		( '' != $wgRequest->getVal( 'wpQuickVideoAddUrl' ) ) ? $this->mUrl = $wgRequest->getVal( 'wpQuickVideoAddUrl' ) : $this->mUrl = '';	

		if ( ( '' != $this->mName ) && ( '' != $this->mUrl ) ) {
			$title = Title::makeTitle( NS_VIDEO, $this->mName );
			if ( $title instanceof Title ) {
				$video = new VideoPage( $title );	
				$video->parseUrl( $this->mUrl );
				$video->setName( $this->mName );
				$video->save();				
			}
			$wgOut->addHTML( "Video page added successfully." ); // FIXME: missing i18n
		} else {
			$wgOut->addHTML( "Error! Please supply parameters!" ); // FIXME: missing i18n
		}
	}
}
