<?php

class CommentsOnlyPageHeaderModule extends PageHeaderModule {

	protected function getTemplatePath() {
		global $wgAutoloadClasses;
		return dirname($wgAutoloadClasses['PageHeaderModule']).'/templates/'.$this->moduleName.'_'.$this->moduleAction.'.php';
	}

	protected function getDropdownActions() {
		if( wfCommentsOnlyCheck() ) {
			return array();
		} else {
			return parent::getDropdownActions();
		}
	}

	protected function prepareActionButton() {
		if( wfCommentsOnlyCheck() ) {
			if( isset( $this->content_actions['delete'] ) ) {
				wfLoadExtensionMessages('CommentsOnly');
				$this->action = $this->content_actions['delete'];
				$this->action['text'] = wfMsgHtml('comments-only-delete-thread');
				$this->actionName = 'delete';
			}
		} else {
			parent::prepareActionButton();
		}
	}

	protected function getRecentRevisions() {
		if( wfCommentsOnlyCheck() ) {
			global $wgTitle;
			$rev = $wgTitle->getFirstRevision();
			if($rev) {
				$user = User::newFromId( $rev->getUser() );
				if($user) {
					return array( 'current' => array(
						'user' => $user->getName(),
						'link' => AvatarService::renderLink( $user->getName() ),
						'avatarUrl' => AvatarService::getAvatarUrl( $user->getName() ),
						'timestamp' => wfTimestamp( TS_ISO_8601, $rev->getTimestamp() ),
						) );
				}
			}
			return array();
		} else {
			return parent::getRecentRevisions();
		}
	}

}
