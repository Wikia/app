<?php

class UserAvatarRemovePage extends SpecialPage {
	var $mAvatar;
	var $mTitle;
	var $mPosted;
	var $mUser;
	var $mCommitRemoved;
	var $iStatus;

	#--- constructor
	public function __construct() {
		wfLoadExtensionMessages( 'Masthead' );
		$this->mPosted = false;
		$this->mCommitRemoved = false;
		$this->mSysMsg = false;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'RemoveUserAvatar' );
		parent::__construct( 'RemoveUserAvatar', 'removeavatar');
	}

	public function execute() {
		global $wgUser, $wgOut, $wgRequest;
		wfProfileIn( __METHOD__ );

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			wfProfileOut( __METHOD__ );
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			wfProfileOut( __METHOD__ );
			return;
		}
		if ( !$wgUser->isLoggedIn() ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}
		if ( !$wgUser->isAllowed( 'removeavatar' ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		$wgOut->setPageTitle( wfMsg('blog-avatar-removeavatar') );

		if ($wgRequest->getVal('action') === 'search_user') {
			$this->mPosted = true;
		}

		if ($wgRequest->getVal('action') === 'remove_avatar') {
			$this->mCommitRemoved = true;
		}

		wfProfileOut( __METHOD__ );
		$this->removeForm();
	}

	private function removeForm() {
		global $wgUser, $wgOut, $wgRequest;

		if ($this->mPosted) {
			if ($wgRequest->getVal('av_user')) {
				$avUser = User::newFromName($wgRequest->getVal('av_user'));
				if ($avUser->getID() !== 0) {
					$this->mAvatar = Masthead::newFromUser($avUser);
					$this->mUser = $avUser;
				}
			}
		}

		if ($this->mCommitRemoved) {
			if ($wgRequest->getVal('av_user')) {
				$avUser = User::newFromName($wgRequest->getVal('av_user'));
				if ($avUser->getID() !== 0) {
					$this->mAvatar = Masthead::newFromUser($avUser);
					if (!$this->mAvatar->removeFile( true )) {
						$this->iStatus = 'WMSG_REMOVE_ERROR';
					}
					$this->mUser = $avUser;
					$this->mPosted = true;
				}
			}
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$oTmpl->set_vars( array(
			'title'     	=> $this->mTitle,
			'avatar'   	 	=> $this->mAvatar,
			'search_user'	=> $wgRequest->getVal('av_user'),
			'user'			=> $this->mUser,
			'is_posted' 	=> $this->mPosted,
			'status'    	=> $this->iStatus
		));
		$wgOut->addHTML( $oTmpl->execute('remove-avatar-form') );
	}
}

