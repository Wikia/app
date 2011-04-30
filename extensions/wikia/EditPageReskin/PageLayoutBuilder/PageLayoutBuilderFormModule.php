<?php

class PageLayoutBuilderFormModule extends Module {
	public function executeIndex() {
		global $wgRequest, $wgContLang;

		$layoutId = $wgRequest->getVal("plbId");
		$pageId = $wgRequest->getVal("pageId");
		
		$this->title = Title::newFromID($layoutId);
		
		if(empty($this->title) || ( ( $pageId != 0 ) && (PageLayoutBuilderModel::articleIsFromPLB( $pageId ) != $layoutId) ) ) {
			$this->display = false;
			return ;
		}

		$this->display = true;
		$this->layoutName = $this->title->getText();
		$rev = $this->title->getFirstRevision();
		$this->profileName =  $rev->getUserText();

		$this->profileLink = AvatarService::getUrl($this->profileName);
		$this->profileAvatar = AvatarService::renderAvatar($this->profileName, 20);

		$info = PageLayoutBuilderModel::getProp($layoutId);
		$this->layoutDesc = $info['desc'];
		$this->titleTime =   $rev->getTimestamp();
		$this->titleTime = $wgContLang->date( $this->titleTime );
	}
}