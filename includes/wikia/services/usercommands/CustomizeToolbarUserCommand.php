<?php

	class CustomizeToolbarUserCommand extends UserCommand {
		
		protected function buildData() {
			global $wgUser;
			$this->available = !$wgUser->isAnon();
			$this->enabled = true;
			$this->imageSprite = 'share';
			$this->caption = wfMsg('oasis-toolbar-customize');
			$this->linkClass = 'tools-customize';
			$this->listItemClass = 'disable-more';
		}
		
		protected function renderIcon() {
			global $wgBlankImgUrl;
			return "<img src=\"$wgBlankImgUrl\" class=\"gear-icon\" height=\"16\" width=\"16\" />";
		}
		
	}